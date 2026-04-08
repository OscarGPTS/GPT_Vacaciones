<?php

namespace App\Http\Controllers;

use App\Models\RequestVacations;
use App\Models\NoWorkingDays;
use App\Models\RequestApproved;
use App\Models\User;
use App\Mail\VacationRequestCreated;
use App\Models\VacationsAvailable;
use App\Models\ManagerApprover;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class VacacionesController extends Controller
{
    public function index()
    {
        // Obtener las solicitudes del usuario autenticado
        $requests = RequestVacations::where('user_id', auth()->id())
            ->with(['requestDays', 'reveal'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        // Obtener las solicitudes creadas en representación por el usuario autenticado
        $behalfRequests = RequestVacations::where('created_by_user_id', auth()->id())
            ->with(['user', 'user.job', 'requestDays', 'reveal'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        // Obtener períodos de vacaciones vigentes del usuario
        $vacationPeriods = VacationsAvailable::where('users_id', auth()->id())
            ->where('is_historical', false)
            ->orderBy('period')
            ->get()
            ->map(function ($period) {
                // Calcular fecha de expiración (date_end + 1 año + 3 meses)
                // El empleado genera vacaciones durante 1 año, luego tiene 1 año + 3 meses para tomarlas
                // Ejemplo: Período 03/10/2023-02/10/2024 → Vence 02/01/2026 (mismo día que date_end)
                $expirationDate = \Carbon\Carbon::parse($period->date_end)->addYear()->addMonths(3);
                $daysUntilExpiration = $expirationDate->diffInDays(\Carbon\Carbon::now(), false);
                
                // Calcular días disponibles reales del período.
                // Usa days_calculated solo cuando ya tiene valor útil; de lo contrario
                // respalda con days_availables para no ocultar períodos activos importados.
                $availableDays = $period->available_balance;
                
                // Verificar si está vencido (date_end + 15 meses)
                $isExpired = $daysUntilExpiration < 0;
                
                return [
                    'period' => $period->period,
                    'period_name' => $period->period_name,
                    'date_start' => $period->date_start,
                    'date_end' => $period->date_end,
                    'days_availables' => $period->days_availables,
                    'days_enjoyed' => $period->days_enjoyed,
                    'days_reserved' => $period->days_reserved ?? 0,
                    'available_days' => floor($availableDays), // Sin decimales
                    'available_days_exact' => round($availableDays, 2), // Valor exacto para tooltip
                    'expiration_date' => $expirationDate,
                    'days_until_expiration' => $daysUntilExpiration,
                    'is_expired' => $isExpired,
                    'expires_soon' => $daysUntilExpiration <= 60 && $daysUntilExpiration < 0,
                ];
            })->filter(function($period) {
                // Filtrar períodos vencidos
                return !$period['is_expired'];
            });
        
        // Calcular total de días disponibles (redondeado)
        $totalAvailableDays = $vacationPeriods->sum('available_days');
            
        return view('vacaciones.index', compact('requests', 'behalfRequests', 'vacationPeriods', 'totalAvailableDays'));
    }

    public function create()
    {
        // Limpiar días seleccionados anteriormente que no están asociados a una solicitud
        // Solo del usuario autenticado actual
        RequestApproved::where('users_id', auth()->id())->whereNull('requests_id')->delete();
        
        // Obtener días no laborables
        $noworkingdays = NoWorkingDays::orderBy('day')->get();
        
        // Obtener todos los usuarios activos para asignar como responsable o para representar
        $users = \App\Models\User::where('id', '!=', auth()->id())
            ->where('active', 1)
            ->select('id', 'first_name', 'last_name')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get()
            ->mapWithKeys(function ($user) {
                return [$user->id => $user->first_name . ' ' . $user->last_name];
            });

        return view('vacaciones.create', compact('noworkingdays', 'users'));
    }

    public function store(Request $request)
    {
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
            
            return [
                'period' => $period->period,
                'period_name' => $period->period_name,
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
                $belongsToPeriod = [
                    'period' => $period->period,
                    'period_name' => $period->period_name,
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
}
