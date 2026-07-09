<?php

namespace App\Http\Controllers;

use App\Models\RequestVacations;
use App\Models\NoWorkingDays;
use App\Models\RequestApproved;
use App\Models\User;
use App\Models\UserSignature;
use App\Mail\VacationRequestCreated;
use App\Mail\VacationRequestUpdated;
use App\Models\VacationsAvailable;
use App\Models\ManagerApprover;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VacacionesController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        
        // Obtener las solicitudes del usuario autenticado
        $requests = RequestVacations::where('user_id', $userId)
            ->select(['id', 'user_id', 'created_by_user_id', 'reveal_id', 'type_request', 'start', 'end', 
                     'opcion', 'direct_manager_status', 'direction_approbation_status', 'human_resources_status', 'created_at'])
            ->with(['requestDays:id,requests_id,start,end', 'reveal:id,first_name,last_name', 'user:id'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        // Solo cargar solicitudes en representación si el usuario tiene permiso de delegación
        $canDelegate = \App\Models\DelegationPermission::hasPermission($userId);
        $behalfRequests = collect([]);
        
        if ($canDelegate) {
            $behalfRequests = RequestVacations::where('created_by_user_id', $userId)
                ->select(['id', 'user_id', 'created_by_user_id', 'reveal_id', 'type_request', 'start', 'end',
                         'opcion', 'direct_manager_status', 'direction_approbation_status', 'human_resources_status', 'created_at'])
                ->with([
                    'user:id,first_name,last_name,job_id', 
                    'user.job:id,name',
                    'requestDays:id,requests_id,start,end', 
                    'reveal:id,first_name,last_name'
                ])
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        }
        
        // Obtener información del usuario para calcular cuándo se desbloquean vacaciones
        $currentUser = User::find($userId);
        $unlockInfo = null;
        
        // Si el usuario tiene menos de 1 año de antigüedad, calcular cuándo se desbloquean
        if ($currentUser && $currentUser->admission) {
            $admissionDate = \Carbon\Carbon::parse($currentUser->admission);
            $oneYearDate = $admissionDate->copy()->addYear();
            $now = \Carbon\Carbon::now();
            
            if ($now->lt($oneYearDate)) {
                $daysUntilUnlock = $now->diffInDays($oneYearDate);
                $unlockInfo = [
                    'unlock_date' => $oneYearDate->format('d/m/Y'),
                    'days_remaining' => $daysUntilUnlock,
                    'admission_date' => $admissionDate->format('d/m/Y'),
                ];
            }
        }
        
        // Obtener períodos de vacaciones vigentes del usuario
        // IMPORTANTE: Usar 'status' = 'actual' (igual que getUserRestrictions) para consistencia
        $now = \Carbon\Carbon::now();
        $vacationPeriods = VacationsAvailable::where('users_id', $userId)
            ->where('status', 'actual')
            ->orderBy('period')
            ->get() // Obtener modelos completos, no select parcial
            ->map(function ($period) use ($now) {
                // Calcular fecha de expiración (date_end + 15 meses)
                $expirationDate = \Carbon\Carbon::parse($period->date_end)->addMonths(15);
                // Calcular días restantes (positivo = futuro, negativo = pasado)
                $daysUntilExpiration = $now->diffInDays($expirationDate, false);
                
                // Disponible solo desde que cumple el año (date_end <= hoy)
                $dateEnd = \Carbon\Carbon::parse($period->date_end);
                $isNotYetAvailable = \Carbon\Carbon::today()->lt($dateEnd);
                $isExpired = $daysUntilExpiration < 0;
                $availableDays = $period->available_balance;

                $endYear = (int)\Carbon\Carbon::parse($period->date_end)->format('Y');

                return [
                    'period'               => $period->period,
                    'period_name'          => 'Período ' . $endYear . '-' . ($endYear + 1),
                    'date_start'           => $period->date_start,
                    'date_end'             => $period->date_end,
                    'days_availables'      => $period->days_availables,
                    'days_enjoyed'         => $period->days_enjoyed,
                    'available_days'       => floor($availableDays),
                    'available_days_exact' => round($availableDays, 2),
                    'expiration_date'      => $expirationDate,
                    'days_until_expiration'=> $daysUntilExpiration,
                    'is_expired'           => $isExpired,
                    'expires_soon'         => $daysUntilExpiration <= 60 && !$isExpired,
                    'is_not_yet_available' => $isNotYetAvailable,
                ];
            })->reject(function($period) {
                // Filtrar períodos vencidos
                return $period['is_expired'];
            });
        
        // Calcular total de días disponibles
        $totalAvailableDays = $vacationPeriods->sum('available_days');
        $totalAvailable     = $vacationPeriods->sum('days_availables');
        $totalEnjoyed       = $vacationPeriods->sum('days_enjoyed');
        $totalReserved      = $vacationPeriods->sum('days_reserved');
        $totalRemaining     = $totalAvailableDays;

        // Datos del usuario con relaciones para el encabezado de perfil
        $currentUser->load(['job.departamento', 'jefe.job', 'razonSocial']);

        // Firma del usuario (requerida para crear solicitudes)
        $userSignature    = UserSignature::forUser($userId);
        $hasSignature     = $userSignature !== null;
        $isSuperAdmin     = auth()->user()->hasRole('super-admin');

        // Términos y condiciones
        $termsRecord      = UserSignature::where('user_id', $userId)->first();
        $hasAcceptedTerms = $termsRecord && $termsRecord->terms_accepted_at !== null;
        $termsAcceptedAt  = $hasAcceptedTerms ? $termsRecord->terms_accepted_at : null;

        // Mapa period_number → date_end (incluye vencidos) para construir
        // la etiqueta de período en el modal de detalle (formato 2024-2025).
        $allPeriodsMap = VacationsAvailable::where('users_id', $userId)
            ->select(['period', 'date_end'])
            ->get()
            ->keyBy('period');

        return view('vacaciones.index', compact(
            'requests', 'behalfRequests', 'vacationPeriods', 'totalAvailableDays', 'canDelegate', 'unlockInfo',
            'totalAvailable', 'totalEnjoyed', 'totalReserved', 'totalRemaining',
            'currentUser', 'userSignature', 'hasSignature', 'isSuperAdmin',
            'hasAcceptedTerms', 'termsAcceptedAt', 'allPeriodsMap'
        ));
    }

    public function create()
    {
        $userId = auth()->id();
        
        // Limpiar días seleccionados anteriormente que no están asociados a una solicitud
        // Solo del usuario autenticado actual
        RequestApproved::where('users_id', $userId)->whereNull('requests_id')->delete();
        
        // Obtener días no laborables
        $noworkingdays = NoWorkingDays::orderBy('day')->get();
        
        // Verificar si el usuario tiene permiso de delegación
        $canDelegate = \App\Models\DelegationPermission::hasPermission($userId);

        // Obtener todos los usuarios activos para asignar como responsable o para representar
        $users = \App\Models\User::where('id', '!=', $userId)
            ->where('active', 1)
            ->select('id', 'first_name', 'last_name')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get()
            ->mapWithKeys(function ($user) {
                return [$user->id => $user->first_name . ' ' . $user->last_name];
            });

        return view('vacaciones.create', compact('noworkingdays', 'users', 'canDelegate'));
    }

    public function store(Request $request)
    {
        // Verificar que el usuario autenticado tenga firma registrada
        if (!UserSignature::userHasSignature(auth()->id())) {
            return back()->with('error', 'Debes registrar tu firma digital antes de poder crear una solicitud de vacaciones. Ve a tu perfil para agregarla.');
        }

        // Verificar permiso de delegación si se intenta solicitar en representación
        if ($request->behalf_user_id && !\App\Models\DelegationPermission::hasPermission(auth()->id())) {
            return back()->with('error', 'No tienes permiso para solicitar vacaciones en representación de otro usuario.');
        }

        // Determinar el usuario para quien es la solicitud
        $targetUserId = $request->behalf_user_id ?? auth()->id();
        $targetUser = \App\Models\User::findOrFail($targetUserId);
        
        // ASIGNACIÓN INTELIGENTE DE JEFE DIRECTO
        // Busca en la tabla manager_approvers por employee_id
        $customManagerId = ManagerApprover::getManagerForUser($targetUserId);
        
        // Usar el jefe personalizado si existe, sino usar el boss_id del usuario
        $directManagerId = $customManagerId ?? $targetUser->boss_id;
        
        // Validar que haya un jefe directo asignado (personalizado o por defecto)
        if (!$directManagerId) {
            $userName = $request->behalf_user_id ? $targetUser->first_name . ' ' . $targetUser->last_name : 'tú';
            return back()->with('error', "No se puede crear la solicitud porque {$userName} no tiene un jefe directo asignado.");
        }

        // 1. VALIDAR ANTIGÜEDAD MÍNIMA: 1 año
        if ($targetUser->admission && $targetUser->admission->diffInYears(now()) < 1) {
            $userName = $request->behalf_user_id ? $targetUser->first_name . ' ' . $targetUser->last_name : 'tú';
            return back()->with('error', "{$userName} debe tener al menos 1 año de antigüedad para solicitar vacaciones.");
        }

        // Validaciones básicas
        $request->validate([
            'behalf_user_id' => 'nullable|exists:users,id',
            'type_request' => 'required|in:Vacaciones',
            'reason' => 'nullable|string|max:400',
            'reveal' => 'nullable|exists:users,id',
        ]);

        // Validar que haya días seleccionados
        $selectedDays = RequestApproved::where('users_id', $targetUserId)
            ->whereNull('requests_id')
            ->get();
            
        if ($selectedDays->count() <= 0) {
            return back()->with('error', 'Debes seleccionar al menos un día en el calendario.');
        }

        // 2. VALIDAR LÍMITE MÁXIMO: 32 días por solicitud
        if ($selectedDays->count() > 32) {
            return back()->with('error', 'No puedes solicitar más de 32 días de vacaciones por solicitud.');
        }

        // 3. VALIDAR ANTICIPACIÓN MÍNIMA: 5 días antes del inicio
        $earliestDate = $selectedDays->min('start');
        $anticipationDays = now()->diffInDays($earliestDate, false);
        
        if ($anticipationDays < 5) {
            return back()->with('error', 'Debes solicitar las vacaciones con al menos 5 días de anticipación.');
        }

        // Obtener el período del primer día (todos deberían ser del mismo período)
        $period = $request->input('period', null);

        // VALIDAR Y RESERVAR DÍAS DEL PERÍODO
        if ($period) {
            $parts = explode('|', $period);
            if (count($parts) === 2) {
                list($periodNumber, $dateStart) = $parts;
                
                $vacationPeriod = VacationsAvailable::where('users_id', $targetUserId)
                    ->where('period', $periodNumber)
                    ->where('date_start', $dateStart)
                    ->where('is_historical', false)
                    ->first();
                
                if ($vacationPeriod) {
                    // Calcular días realmente disponibles (considerando reservados)
                    $diasDisponibles = $vacationPeriod->available_balance;
                    $fechaLimiteDisfrute = \Carbon\Carbon::parse($vacationPeriod->date_end)->addMonths(15)->endOfDay();

                    $diasFueraDeVigencia = $selectedDays->filter(function ($day) use ($fechaLimiteDisfrute) {
                        return \Carbon\Carbon::parse($day->start)->startOfDay()->gt($fechaLimiteDisfrute);
                    });
                    
                    if ($diasFueraDeVigencia->isNotEmpty()) {
                        return back()->with('error', "Los días seleccionados exceden la vigencia del período {$periodNumber}. Fecha límite para tomarlas: {$fechaLimiteDisfrute->format('d/m/Y')}.");
                    }
                    
                    if ($diasDisponibles < $selectedDays->count()) {
                        return back()->with('error', "El período seleccionado solo tiene {$diasDisponibles} días disponibles (considerando días ya reservados en otras solicitudes pendientes). Solicitados: {$selectedDays->count()}");
                    }
                    
                    // RESERVAR LOS DÍAS
                    $vacationPeriod->update([
                        'days_reserved' => $vacationPeriod->days_reserved + $selectedDays->count()
                    ]);
                } else {
                    return back()->with('error', 'No se encontró el período de vacaciones especificado.');
                }
            }
        }

        // Crear solicitud de vacaciones
        $requestData = [
            'user_id' => $targetUserId,
            'created_by_user_id' => $request->behalf_user_id ? auth()->id() : null,
            'reveal_id' => $request->reveal,
            'type_request' => 'Vacaciones',
            'payment' => 'A cuenta de vacaciones',
            'start' => null,
            'end' => null,  
            'opcion' => $period, // GUARDAR EL PERÍODO AQUÍ
            'reason' => $request->reason ?? "Vacaciones",
            'doc_permiso' => null,
            'direct_manager_id' => $directManagerId, // Jefe personalizado o por defecto
            'direct_manager_status' => 'Pendiente',
            'human_resources_status' => 'Pendiente',
            'visible' => true,
        ];

        $newRequest = RequestVacations::create($requestData);

        // Cargar la relación directManager
        $newRequest->load('directManager');

        // Actualizar días seleccionados
        RequestApproved::where('users_id', $targetUserId)
            ->whereNull('requests_id')
            ->update(['requests_id' => $newRequest->id]);

        // Enviar notificación al jefe directo
        if ($newRequest->directManager && $newRequest->directManager->email) {
            try {
                // Pequeño delay para evitar límite de tasa de Mailtrap
                sleep(1);
                
                Mail::to($newRequest->directManager->email)
                    ->send(new VacationRequestCreated($newRequest));
                Log::info('Correo enviado al jefe directo', [
                    'request_id' => $newRequest->id,
                    'manager_email' => $newRequest->directManager->email
                ]);
            } catch (\Exception $e) {
                Log::error('Error enviando correo al jefe directo: ' . $e->getMessage(), [
                    'request_id' => $newRequest->id,
                    'manager_id' => $newRequest->direct_manager_id
                ]);
            }
        }

        $successMessage = $request->behalf_user_id 
            ? "Solicitud creada correctamente en representación de {$targetUser->first_name} {$targetUser->last_name}."
            : 'Solicitud creada correctamente.';

        return redirect()->route('vacaciones.index')->with('success', $successMessage);
    }

    public function edit(int $id)
    {
        $vacationRequest = RequestVacations::with('requestDays')->findOrFail($id);

        // Solo el dueño o RH puede editar la solicitud
        $isHR = auth()->user()->can('ver modulo rrhh');
        if ($vacationRequest->user_id !== auth()->id() && !$isHR) {
            return redirect()->route('vacaciones.index')->with('error', 'No tienes permiso para editar esta solicitud.');
        }

        // Solo editable cuando nadie ha aprobado ni rechazado
        $notEditable = in_array('Aprobada', [
            $vacationRequest->direct_manager_status,
            $vacationRequest->human_resources_status,
            $vacationRequest->direction_approbation_status,
        ]) || in_array('Rechazada', [
            $vacationRequest->direct_manager_status,
            $vacationRequest->human_resources_status,
            $vacationRequest->direction_approbation_status,
        ]);

        if ($notEditable) {
            return redirect()->route('vacaciones.index')->with('error', 'Esta solicitud no puede editarse porque ya fue procesada por algún nivel de aprobación.');
        }

        // Usar el ID del dueño para los días temporales (RH edita en nombre del empleado)
        $tempUserId = $vacationRequest->user_id;

        // Limpiar días temporales previos
        RequestApproved::where('users_id', $tempUserId)->whereNull('requests_id')->delete();

        // Copiar los días existentes de esta solicitud como temporales
        foreach ($vacationRequest->requestDays as $day) {
            RequestApproved::create([
                'title'       => $day->title,
                'start'       => $day->start,
                'end'         => $day->end,
                'users_id'    => $tempUserId,
                'requests_id' => null,
            ]);
        }

        // Pasar los días temporales al view (con IDs para el calendar)
        $existingDays = RequestApproved::where('users_id', $tempUserId)->whereNull('requests_id')->get();

        // Parsear el período pre-seleccionado desde opcion ("period|date_start")
        $selectedPeriodData = null;
        if ($vacationRequest->opcion) {
            $parts = explode('|', $vacationRequest->opcion);
            if (count($parts) === 2) {
                $selectedPeriodData = ['period' => $parts[0], 'date_start' => $parts[1]];
            }
        }

        $noworkingdays = NoWorkingDays::orderBy('day')->get();

        return view('vacaciones.edit', compact('vacationRequest', 'noworkingdays', 'existingDays', 'selectedPeriodData'));
    }

    public function update(Request $request, int $id)
    {
        $vacationRequest = RequestVacations::with('requestDays')->findOrFail($id);

        // Solo el dueño o RH puede actualizar
        $isHR = auth()->user()->can('ver modulo rrhh');
        if ($vacationRequest->user_id !== auth()->id() && !$isHR) {
            return back()->with('error', 'No tienes permiso para editar esta solicitud.');
        }

        // Verificar que sigue editable
        $notEditable = in_array('Aprobada', [
            $vacationRequest->direct_manager_status,
            $vacationRequest->human_resources_status,
            $vacationRequest->direction_approbation_status,
        ]) || in_array('Rechazada', [
            $vacationRequest->direct_manager_status,
            $vacationRequest->human_resources_status,
            $vacationRequest->direction_approbation_status,
        ]);

        if ($notEditable) {
            return back()->with('error', 'Esta solicitud no puede editarse porque ya fue procesada por algún nivel de aprobación.');
        }

        // Obtener días temporales del dueño de la solicitud
        $newDays = RequestApproved::where('users_id', $vacationRequest->user_id)->whereNull('requests_id')->get();

        if ($newDays->count() === 0) {
            return back()->with('error', 'Debes seleccionar al menos un día en el calendario.');
        }

        if ($newDays->count() > 32) {
            return back()->with('error', 'No puedes solicitar más de 32 días de vacaciones por solicitud.');
        }

        // Validar anticipación mínima de 5 días hábiles
        $earliestDate = $newDays->min('start');
        if (now()->diffInDays($earliestDate, false) < 5) {
            return back()->with('error', 'Debes solicitar las vacaciones con al menos 5 días de anticipación.');
        }

        $newPeriod = $request->input('period', null);

        // 1. Liberar días reservados del período ANTERIOR
        if ($vacationRequest->opcion) {
            $oldParts = explode('|', $vacationRequest->opcion);
            if (count($oldParts) === 2) {
                [$oldPeriodNumber, $oldDateStart] = $oldParts;
                $oldPeriodRecord = VacationsAvailable::where('users_id', $vacationRequest->user_id)
                    ->where('period', $oldPeriodNumber)
                    ->where('date_start', $oldDateStart)
                    ->first();
                if ($oldPeriodRecord) {
                    $oldCount = $vacationRequest->requestDays->count();
                    $oldPeriodRecord->update([
                        'days_reserved' => max(0, $oldPeriodRecord->days_reserved - $oldCount),
                    ]);
                }
            }
        }

        // 2. Validar y reservar días en el período NUEVO
        if ($newPeriod) {
            $newParts = explode('|', $newPeriod);
            if (count($newParts) === 2) {
                [$newPeriodNumber, $newDateStart] = $newParts;
                $newPeriodRecord = VacationsAvailable::where('users_id', $vacationRequest->user_id)
                    ->where('period', $newPeriodNumber)
                    ->where('date_start', $newDateStart)
                    ->where('is_historical', false)
                    ->first();

                if (!$newPeriodRecord) {
                    // Revertir la liberación antes de retornar
                    if (isset($oldPeriodRecord)) {
                        $oldPeriodRecord->update([
                            'days_reserved' => $oldPeriodRecord->days_reserved + $vacationRequest->requestDays->count(),
                        ]);
                    }
                    return back()->with('error', 'No se encontró el período de vacaciones especificado.');
                }

                $diasDisponibles = $newPeriodRecord->available_balance;
                if ($diasDisponibles < $newDays->count()) {
                    // Revertir la liberación antes de retornar
                    if (isset($oldPeriodRecord)) {
                        $oldPeriodRecord->update([
                            'days_reserved' => $oldPeriodRecord->days_reserved + $vacationRequest->requestDays->count(),
                        ]);
                    }
                    return back()->with('error', "El período seleccionado solo tiene {$diasDisponibles} días disponibles. Solicitados: {$newDays->count()}");
                }

                $newPeriodRecord->update([
                    'days_reserved' => $newPeriodRecord->days_reserved + $newDays->count(),
                ]);
            }
        }

        // 3. Reemplazar los días de la solicitud
        $vacationRequest->requestDays()->delete();
        $newDays->each(function ($day) use ($id) {
            $day->update(['requests_id' => $id]);
        });

        // 4. Actualizar la solicitud
        $vacationRequest->update([
            'opcion' => $newPeriod,
        ]);

        // 5. Notificar al dueño de la solicitud por correo
        $vacationRequest->load('requestDays', 'user');
        try {
            if ($vacationRequest->user && $vacationRequest->user->email) {
                Mail::to($vacationRequest->user->email)
                    ->send(new VacationRequestUpdated($vacationRequest, auth()->user()));
            }
        } catch (\Exception $e) {
            Log::error('Error enviando correo de actualización: ' . $e->getMessage(), [
                'request_id' => $vacationRequest->id,
            ]);
        }

        return redirect()->route('vacaciones.index')->with('success', 'Solicitud actualizada correctamente.');
    }

    /**
     * Cancelar la propia solicitud del usuario autenticado.
     * Solo permitido mientras el jefe directo NO la haya aprobado
     * (direct_manager_status === 'Pendiente'), es decir, antes del primer
     * paso del flujo de aprobación. Libera los días reservados al período.
     */
    public function cancelarSolicitud(int $id)
    {
        $userId = auth()->id();

        $solicitud = RequestVacations::with(['requestDays', 'user'])
            ->where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();

        // Solo se puede cancelar si aún no la aprobó (ni rechazó) el jefe directo
        // y no ha sido cancelada previamente.
        if ($solicitud->direct_manager_status !== 'Pendiente'
            || $solicitud->human_resources_status === 'Cancelada') {
            return redirect()
                ->route('vacaciones.index')
                ->with('error', 'Solo puedes cancelar solicitudes que aún no han sido revisadas por tu jefe directo.');
        }

        DB::connection('mysql_vacations')->transaction(function () use ($solicitud) {
            // 1. Liberar días reservados en el período correspondiente
            $this->releaseReservedDays($solicitud);

            // 2. Marcar la solicitud como cancelada
            $solicitud->update([
                'human_resources_status' => 'Cancelada',
            ]);
        });

        Log::info('Solicitud cancelada por el propio usuario', [
            'request_id' => $solicitud->id,
            'user_id'    => $userId,
        ]);

        return redirect()
            ->route('vacaciones.index')
            ->with('success', 'Solicitud cancelada. Los días reservados fueron devueltos al período correspondiente.');
    }

    /**
     * Libera los días reservados de una solicitud al período correspondiente.
     * Reproduce el flujo existente de RequestController::releaseReservedDays.
     */
    protected function releaseReservedDays(RequestVacations $requestVacation)
    {
        if (empty($requestVacation->opcion)) {
            return;
        }

        $parts = explode('|', $requestVacation->opcion);
        if (count($parts) !== 2) {
            return;
        }

        list($periodNumber, $dateStart) = $parts;

        $periodo = VacationsAvailable::where('users_id', $requestVacation->user_id)
            ->where('period', $periodNumber)
            ->where('date_start', $dateStart)
            ->where('is_historical', false)
            ->first();

        if ($periodo) {
            $diasSolicitados = $requestVacation->requestDays->count();
            $periodo->update([
                'days_reserved' => max(0, $periodo->days_reserved - $diasSolicitados),
            ]);

            Log::info('Días reservados liberados (cancelación por usuario)', [
                'request_id'    => $requestVacation->id,
                'period'        => $periodNumber,
                'days_released' => $diasSolicitados,
            ]);
        }
    }

    // AJAX para obtener restricciones del usuario
    public function getUserRestrictions(Request $request)
    {
        $userId = $request->user_id ?? auth()->id();
        $user = User::find($userId);
        
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Calcular días disponibles actuales
        $vacationAvailables = $user->vacationsAvailable()
            ->where('status', 'actual')
            ->orderBy('date_start', 'asc') // Ordenar por fecha de inicio (más antiguo primero)
            ->get();
        
        $totalAvailable = $vacationAvailables->sum(function($period) {
            return floor($period->available_balance); // Sin decimales
        });

        // Construir información detallada por período
        $periods = $vacationAvailables->map(function($period) {
            // Calcular fecha de expiración (date_end + 1 año + 3 meses)
            $expirationDate = \Carbon\Carbon::parse($period->date_end)->addYear()->addMonths(3);
            $availableDays = $period->available_balance;
            
            // Calcular días hasta expiración
            // Si es positivo: aún no vence (futuro)
            // Si es negativo: ya venció (pasado)
            $now = \Carbon\Carbon::now();
            $daysUntilExpiration = $now->diffInDays($expirationDate, false);
            
            // Verificar si está vencido
            $isExpired = $daysUntilExpiration < 0;

            // Etiqueta visual basada en el año de date_end
            $endYear = (int)\Carbon\Carbon::parse($period->date_end)->format('Y');
            $periodLabel = 'Período ' . $endYear . '-' . ($endYear + 1);
            
            return [
                'period' => $period->period,
                'period_name' => $periodLabel,
                'available_days' => floor($availableDays), // Sin decimales
                'available_days_exact' => round($availableDays, 2), // Valor exacto para referencia
                'expiration_date' => $expirationDate->format('d/m/Y'),
                'days_until_expiration' => abs($daysUntilExpiration), // Valor absoluto para mostrar días restantes
                'is_expired' => $isExpired,
                'expires_soon' => $daysUntilExpiration >= 0 && $daysUntilExpiration <= 60, // Entre 0 y 60 días
                'expires_urgent' => $daysUntilExpiration >= 0 && $daysUntilExpiration <= 90, // Entre 0 y 90 días
                'date_start' => $period->date_start->format('Y-m-d'),
                'date_end' => $period->date_end->format('Y-m-d'),
            ];
        })->filter(function($period) {
            // Filtrar períodos vencidos y con días <= 0
            return !$period['is_expired'] && $period['available_days'] > 0;
        })->values();

        // Calcular antigüedad
        $hireDate = $user->admission ? \Carbon\Carbon::parse($user->admission) : null;
        $antiguedad = 0;
        $mesesAntiguedad = 0;
        $meetsAntiquity = false;
        
        if ($hireDate) {
            $today = \Carbon\Carbon::now();
            $antiguedad = $hireDate->diffInYears($today);
            $mesesAntiguedad = $hireDate->diffInMonths($today);
            $meetsAntiquity = $antiguedad >= 1;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'user_name' => $user->first_name . ' ' . $user->last_name,
                'total_available' => round($totalAvailable, 2),
                'max_per_request' => min(32, $totalAvailable), // Máximo 32 o lo que tenga disponible
                'antiquity_years' => $antiguedad,
                'antiquity_months' => $mesesAntiguedad,
                'meets_antiquity' => $meetsAntiquity,
                'admission_date' => $user->admission ? $user->admission->format('Y-m-d') : null,
                'periods' => $periods,
            ]
        ]);
    }

    public function checkDayPeriod(Request $request)
    {
        $userId = $request->user_id ?? auth()->id();
        $date = $request->date; // Formato YYYY-MM-DD
        
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Obtener períodos vigentes del usuario ordenados por antigüedad (período más antiguo primero)
        $vacationPeriods = $user->vacationsAvailable()
            ->where('status', 'actual')
            ->where('is_historical', false)
            ->orderBy('period', 'asc')
            ->get();

        // En lugar de verificar si la fecha está dentro del período,
        // siempre asignar al período más antiguo con días disponibles
        $belongsToPeriod = null;
        
        foreach ($vacationPeriods as $period) {
            $availableDays = $period->available_balance;
            
            if ($availableDays > 0) {
                $endYear = (int)\Carbon\Carbon::parse($period->date_end)->format('Y');
                $periodLabel = 'Período ' . $endYear . '-' . ($endYear + 1);
                $belongsToPeriod = [
                    'period' => $period->period,
                    'period_name' => $periodLabel,
                    'available_days' => round($availableDays, 2),
                    'date_start' => $period->date_start->format('Y-m-d'),
                    'date_end' => $period->date_end->format('Y-m-d'),
                ];
                break; // Tomar el primer período con días disponibles (el más antiguo)
            }
        }

        return response()->json([
            'success' => true,
            'period' => $belongsToPeriod,
        ]);
    }

    // AJAX para manejar selección de días en el calendario
    public function ajax(Request $request)
    {
        // Determinar el usuario (puede ser en representación)
        $userId = $request->behalf_user_id ?? auth()->id();
        
        $date = RequestApproved::where('start', $request->start)->where('users_id', $userId)->first();
        
        if ($date != null) {
            return response()->json(['exist' => true]);
        }
        
        switch ($request->type) {
            case 'add':
                $event = RequestApproved::create([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                    'users_id' => $userId,
                ]);
                
                // Devolver el período para referencia del frontend
                return response()->json([
                    'id' => $event->id,
                    'period' => $request->period,
                ]);

            case 'delete':
                $event = RequestApproved::find($request->id)->delete();
                return response()->json($event);

            case 'delete_all':
                // Eliminar todos los días seleccionados que no tienen request_id asignado
                $deleted = RequestApproved::where('users_id', $userId)
                    ->whereNull('requests_id')
                    ->delete();
                return response()->json(['deleted' => $deleted, 'message' => 'Días eliminados correctamente']);

            default:
                return response()->json(['error' => 'Invalid type']);
        }
    }

    public function acceptTerms()
    {
        UserSignature::acceptTerms(auth()->id());

        return back()->with('terms_accepted', 'Has aceptado los términos y condiciones del sistema de vacaciones.');
    }
}
