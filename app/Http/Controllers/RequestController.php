<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Job;
use App\Models\NoWorkingDays;
use App\Models\RequestApproved;
use App\Models\RequestVacations;
use App\Models\VacationsAvailable;
use App\Models\Departamento;
use App\Models\DirectionApprover;
use App\Models\ManagerApprover;
use App\Models\UserSignature;
use App\Models\RazonSocial;
use App\Services\VacationCalculatorService;
use App\Services\VacationPeriodCreatorService;
use App\Services\VacationDailyAccumulatorService;
use App\Mail\VacationRequestRejectedByManager;
use App\Mail\VacationRequestApprovedByManager;
use App\Mail\VacationRequestPendingRH;
use App\Mail\VacationRequestPendingDirection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class RequestController extends Controller
{
    //Peticiones de los dias del calendario
    public function ajax(Request $request)
    {
        $id = Auth::id();
        $date = RequestApproved::where('start', $request->start)->where('users_id', $id)->first();
        if ($date != null) {
            return response()->json(['exist' => true]);
        }
        switch ($request->type) {
            case 'add':
                $event = RequestApproved::create([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                    'users_id' => $id,
                    'requests_id' => $request->id,
                ]);

                return response()->json($event);
                break;

            case 'update':
                $event = RequestApproved::find($request->id)->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                    'user_id' => $id
                ]);

                return response()->json($event);
                break;

            case 'delete':
                $event = RequestApproved::find($request->id)->delete();

                return response()->json($event);
                break;

            default:

                break;
        }
    }

    // Pantalla Inicial
    public function index(Request $request)
    {
        return view('request.index');
    }

    public function edit(RequestVacations $request)
    {
        auth()->user()->daysSelected()->delete();
        // Obtener dias no laborables
        $noworkingdays = NoWorkingDays::orderBy('day', 'ASC')->get();
        // Obtener dias de vacaciones
        // Sumar días disponibles (ya no se usa campo 'dv' deprecado)
        $vacations = 0; // Campo dv eliminado
        $dataVacations  = auth()->user()->vacationsAvailables()->where('period', '<>', 3)->orderBy('period', 'DESC')->get();
        if ($vacations == null) {
            $vacations = 0;
        }

        $daysSelected = RequestApproved::where('requests_id', $request->id)->get();


        return view('request.edit', compact('noworkingdays', 'vacations', 'daysSelected', 'request', 'dataVacations'));
    }

    public function update(Request $request, RequestVacations $modelRequest)
    {
        if (auth()->user()->employee->jefe_directo_id == null) {
            return back()->with('message', 'No puedes crear solicitudes por que no tienes un jefe directo asignado o no llenaste todos los campos');
        }

        $request->validate([
            'type_request' => 'required',
            'payment' => 'required',
            'reason' => 'required|max:255',
        ]);

        if ($request->type_request === "Salir durante la jornada") {
            if ($request->start === null && $request->end === null) {
                return back()->with('message', 'Especifica la hora de tu salida o entrada');
            }
        }

        $modelRequest->update([
            'type_request' => $request->type_request,
            'payment' => $request->payment,
            'reason' => $request->reason,
            'start' => $request->start,
            'end' => $request->end,
        ]);

        //Actualizar el request de los dias seleccionados
        auth()->user()->daysSelected()->update(['requests_id' => $modelRequest->id]);

        return redirect()->action([RequestController::class, 'index']);
    }

    public function destroy(RequestVacations $request)
    {
        $request->requestdays()->delete();
        DB::table('notifications')->whereRaw("JSON_EXTRACT(`data`, '$.id') = ?", [$request->id])->delete();
        $request->delete();
        return redirect()->action([RequestController::class, 'index']);
    }

    public function authorizeRequestManager()
    {
        // LÓGICA CORRECTA: Solo mostrar solicitudes donde el usuario autenticado 
        // sea EXACTAMENTE el direct_manager_id asignado en la solicitud.
        // Esto respeta la configuración de manager_approvers que se asigna 
        // automáticamente al crear la solicitud.
        
        $requests = RequestVacations::where('direct_manager_status', 'Pendiente')
            ->where('direct_manager_id', auth()->id())
            ->with(['user', 'user.job', 'user.job.departamento', 'reveal', 'requestDays'])
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('vacaciones.authorize', compact('requests'));
    }

    public function authorizeRequestRH(Request $request)
    {
        // Verificar permisos de RH
        if (!auth()->user()->can('ver modulo rrhh')) {
            return redirect()->route('home')->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        // La lógica de datos ahora se maneja en el componente Livewire
        return view('vacaciones.authorize_rh');
    }

    public function approveRejectManager(Request $request, $id)
    {
        $requestVacation = RequestVacations::with(['user', 'directManager', 'requestDays'])->findOrFail($id);

        $request->validate([
            'action' => 'required|in:aprobar,rechazar'
        ]);

        $status = $request->action === 'aprobar' ? 'Aprobada' : 'Rechazada';
        
        $requestVacation->update([
            'direct_manager_status' => $status
        ]);

        if ($request->action === 'rechazar') {
            // LIBERAR DÍAS RESERVADOS
            $this->releaseReservedDays($requestVacation);
            
            $this->moveToRejected($requestVacation);
            
            // Notificar al empleado sobre el rechazo
            if ($requestVacation->user && $requestVacation->user->email) {
                try {
                    Mail::to($requestVacation->user->email)
                        ->send(new VacationRequestRejectedByManager($requestVacation));
                    Log::info('Correo de rechazo enviado al empleado', [
                        'request_id' => $requestVacation->id,
                        'employee_email' => $requestVacation->user->email
                    ]);
                } catch (\Exception $e) {
                    Log::error('Error enviando correo de rechazo al empleado: ' . $e->getMessage(), [
                        'request_id' => $requestVacation->id,
                        'employee_id' => $requestVacation->user_id
                    ]);
                }
            }
        } else {
            // ASIGNACIÓN INTELIGENTE DE APROBADOR DE DIRECCIÓN
            // Busca en la tabla direction_approvers por employee_id
            $customDirectionApproverId = DirectionApprover::getDirectionApproverForUser($requestVacation->user_id);
            
            // Si no hay aprobador personalizado, buscar usuarios con job_id = 60 (Dirección tradicional)
            $directionApproverId = $customDirectionApproverId;
            if (!$directionApproverId) {
                $defaultDirectionUser = User::where('job_id', 60)->first();
                $directionApproverId = $defaultDirectionUser?->id;
            }
            
            // Actualizar solicitud con aprobador de dirección asignado
            $requestVacation->update([
                'direction_approbation_status' => 'Pendiente',
                'direction_approbation_id' => $directionApproverId
            ]);

            // Notificar SOLO al aprobador asignado
            if ($directionApproverId) {
                $directionUser = User::find($directionApproverId);
                
                if ($directionUser && $directionUser->email) {
                    try {
                        Mail::to($directionUser->email)
                            ->send(new \App\Mail\VacationRequestPendingDirection(
                                $requestVacation->user,
                                $requestVacation->requestDays->count(),
                                auth()->user()
                            ));
                        Log::info('Correo enviado a Dirección', [
                            'request_id' => $requestVacation->id,
                            'direction_approver_id' => $directionApproverId,
                            'direction_user_email' => $directionUser->email
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Error enviando correo a Dirección: ' . $e->getMessage(), [
                            'request_id' => $requestVacation->id,
                            'direction_approver_id' => $directionApproverId
                        ]);
                    }
                }
            }
        }

        $message = $request->action === 'aprobar' 
            ? 'Solicitud aprobada correctamente. Será enviada a Dirección.'
            : 'Solicitud rechazada correctamente.';
            
        return back()->with('success', $message);
    }

    public function approveRejectRH(Request $request, $id)
    {
        $requestVacation = RequestVacations::findOrFail($id);
        
        if ($requestVacation->direct_manager_status !== 'Aprobada') {
            return back()->with('error', 'Esta solicitud no ha sido aprobada por el jefe directo.');
        }

        if ($requestVacation->direction_approbation_status !== 'Aprobada') {
            return back()->with('error', 'Esta solicitud no ha sido aprobada por Dirección.');
        }

        $request->validate([
            'action' => 'required|in:aprobar,rechazar'
        ]);

        $status = $request->action === 'aprobar' ? 'Aprobada' : 'Rechazada';
        
        // Actualizar la solicitud
        $requestVacation->update([
            'human_resources_status' => $status
        ]);

        // Si es rechazada por RH, mover los días de request_approved a request_rejected
        if ($request->action === 'rechazar') {
            $this->moveToRejected($requestVacation);
        }

        $message = $request->action === 'aprobar' 
            ? 'Solicitud aprobada correctamente por Recursos Humanos.'
            : 'Solicitud rechazada por Recursos Humanos.';
            
        return back()->with('success', $message);
    }

    /**
     * Mover días de request_approved a request_rejected cuando se rechaza una solicitud
     */
    private function moveToRejected(RequestVacations $requestVacation)
    {
        // Obtener los días aprobados
        $approvedDays = RequestApproved::where('requests_id', $requestVacation->id)->get();
        
        // Crear registros en request_rejected
        foreach ($approvedDays as $day) {
            \App\Models\RequestRejected::create([
                'title' => $day->title,
                'start' => $day->start,
                'end' => $day->end,
                'users_id' => $day->users_id,
                'requests_id' => $day->requests_id
            ]);
        }
        
        // Eliminar de request_approved
        RequestApproved::where('requests_id', $requestVacation->id)->delete();
    }

    /**
     * Liberar días reservados cuando se rechaza una solicitud
     */
    protected function releaseReservedDays(RequestVacations $requestVacation)
    {
        if (!empty($requestVacation->opcion)) {
            $parts = explode('|', $requestVacation->opcion);
            if (count($parts) === 2) {
                list($periodNumber, $dateStart) = $parts;
                
                $periodo = VacationsAvailable::where('users_id', $requestVacation->user_id)
                    ->where('period', $periodNumber)
                    ->where('date_start', $dateStart)
                    ->where('is_historical', false)
                    ->first();
                
                if ($periodo) {
                    $diasSolicitados = $requestVacation->requestDays->count();
                    $periodo->update([
                        'days_reserved' => max(0, $periodo->days_reserved - $diasSolicitados)
                    ]);
                    
                    Log::info('Días reservados liberados', [
                        'request_id' => $requestVacation->id,
                        'period' => $periodNumber,
                        'days_released' => $diasSolicitados
                    ]);
                }
            }
        }
    }

    public function reportRequest()
    {
        //$vacations = Vacations::all();
        $vacations = DB::connection('mysql_vacations')->table('vacations_availables')->get();
        //dd($vacations);
        //$requestDays = RequestApproved::all();
        $requestDays = DB::table('request_calendars')->get();
        //dd($requestDays);
        $ids = User::where('status', 1)->pluck('id');
        $requests = RequestVacations::whereIn('employee_id', $ids)->where('direct_manager_status', 'Aprobada')
                                            ->where('human_resources_status', 'Aprobada')->orderBy('created_at', 'desc')->get();

        return view('request.reports', compact('requests', 'requestDays', 'vacations'));
    }
    
    //Vista de excel a exportar
    public function exportAll()
    {
        $vacations = VacationsAvailable::all();
        $requestDays = RequestApproved::all();
        $requests = RequestVacations::all()->where('direct_manager_status', 'Aprobada')->where('human_resources_status', 'Aprobada');
        return view('request.excelReport', compact('requests', 'requestDays', 'vacations'));
    }

    public function filter(Request $request)
    {
        $request->validate([
            'start' => 'required',
            'end' => 'required',
        ]);

        $requestDays = RequestApproved::all();
        $requests = RequestVacations::where('direct_manager_status', 'Aprobada')->where('human_resources_status', 'Aprobada')->whereRaw('DATE(created_at) >= ?', [$request->start])->whereRaw('DATE(created_at) <= ?', [$request->end])->get();

        $start = $request->start;

        $end = $request->end;

        return view('request.filter', compact('requests', 'requestDays', 'start', 'end'));
    }

    public function filterDate(Request $request)
    {
        $request->validate([
            'start' => 'required',
            'end' => 'required',
        ]);

        $requestDays = RequestApproved::all()->where('start', '>=', $request->start)->where('end', '<=', $request->end);
        $daySelected = RequestApproved::all()->where('start', '>=', $request->start)->where('end', '<=', $request->end)->pluck('requests_id', 'requests_id');

        $requests = RequestVacations::where('direct_manager_status', 'Aprobada')->where('human_resources_status', 'Aprobada')->whereIn('id', $daySelected)->get();

        $start = $request->start;
        $end = $request->end;

        return view('request.filterDate', compact('requests', 'requestDays', 'start', 'end'));
    }

    //Exportaciones de excel
    public function export()
    {
        return Excel::download(new RequestExport, 'solicitudes.xlsx');
    }

    public function exportfilter(Request $request)
    {
        return Excel::download(new FilterRequestExport($request->start, $request->end), 'solicitudes_por_periodo.xlsx');
    }


    public function getDataFilter(Request $request)
    {

        $daySelected = RequestApproved::all()->where('start', '>=', $request->start)->where('end', '<=', $request->end)->pluck('requests_id', 'requests_id');

        $start = $request->start;
        $end = $request->end;

        return  Excel::download(new DateRequestExport($start, $end, $daySelected), 'solicitudes_por_periodo.xlsx');
    }

    // Recordar las solicitudes que estan pendientes a los jefes directos y a rh
    public function alertPendient()
    {
        $request = ModelsRequest::where('direct_manager_status', 'Pendiente')->get();
        $requestRH = ModelsRequest::where('direct_manager_status', '=', 'Aprobada')->where('human_resources_status', 'Pendiente')->get();
        $usersRH = Role::where('name', 'rh')->first()->users;

        foreach ($request as $req) {
            $userReceiver = $req->manager->user;
            $user = $req->employee->user;
            $userReceiver->notify(new AlertRequestToAuth($req->type_request, $user->name . ' ' . $user->lastname, $userReceiver->name . ' ' . $userReceiver->lastname, $req->direct_manager_status));
        }

        if (count($requestRH) > 0) {
            foreach ($usersRH as $userRH) {
                $userRH->notify(new AlertRequestToRH());
            }
        }
    }

    /**
     * Reporte de vacaciones para RH
     */
    /**
     * Vista con Livewire para reporte de vacaciones
     */
    public function vacationReportLivewire()
    {
        if (!auth()->user()->can('ver modulo rrhh')) {
            return redirect()->route('home')->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        return view('vacaciones.vacation_report_livewire');
    }

    public function cancelarSolicitud(int $userId, int $requestId)
    {
        if (!auth()->user()->can('ver modulo rrhh')) {
            return redirect()->route('home')->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        $solicitud = RequestVacations::with('requestDays')
            ->where('id', $requestId)
            ->where('user_id', $userId)
            ->firstOrFail();

        if ($solicitud->human_resources_status === 'Aprobada') {
            return redirect()
                ->route('vacaciones.reporte.perfil', $userId)
                ->with('error', 'No se puede cancelar una solicitud ya aprobada por Recursos Humanos.');
        }

        DB::connection('mysql_vacations')->transaction(function () use ($solicitud) {
            // 1. Liberar días reservados en el período correspondiente
            $this->releaseReservedDays($solicitud);

            // 2. Marcar la solicitud como cancelada por RH
            $solicitud->update([
                'human_resources_status' => 'Cancelada',
            ]);
        });

        return redirect()
            ->route('vacaciones.reporte.perfil', $userId)
            ->with('success', 'Solicitud marcada como Cancelada. Los días reservados han sido liberados al período correspondiente.');
    }

    public function perfilUsuario(int $userId)
    {
        if (!auth()->user()->can('ver modulo rrhh')) {
            return redirect()->route('home')->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        $currentUser = User::with(['job.departamento', 'jefe.job', 'razonSocial'])->findOrFail($userId);

        $now = \Carbon\Carbon::now();

        // Períodos de vacaciones
        $vacationPeriods = VacationsAvailable::where('users_id', $userId)
            ->where('status', 'actual')
            ->orderBy('period')
            ->get()
            ->map(function ($period) use ($now) {
                $dateEnd            = \Carbon\Carbon::parse($period->date_end);
                $expirationDate     = $dateEnd->copy()->addMonths(15);
                $daysUntilExpiration = $now->diffInDays($expirationDate, false);
                $isExpired          = $daysUntilExpiration < 0;
                // Disponible solo desde que cumple el año (date_end <= hoy)
                $isNotYetAvailable  = \Carbon\Carbon::today()->lt($dateEnd);

                return [
                    'period'               => $period->period,
                    'date_start'           => $period->date_start,
                    'date_end'             => $period->date_end,
                    'days_availables'      => $period->days_availables,
                    'days_enjoyed'         => $period->days_enjoyed,
                    'available_days'       => floor($period->available_balance),
                    'available_days_exact' => round($period->available_balance, 2),
                    'expiration_date'      => $expirationDate,
                    'days_until_expiration'=> $daysUntilExpiration,
                    'is_expired'           => $isExpired,
                    'expires_soon'         => $daysUntilExpiration <= 60 && !$isExpired,
                    'is_not_yet_available' => $isNotYetAvailable,
                ];
            })->reject(fn($p) => $p['is_expired']);

        // Solicitudes del usuario
        $requests = RequestVacations::where('user_id', $userId)
            ->select(['id','user_id','created_by_user_id','reveal_id','type_request','start','end',
                      'opcion','direct_manager_status','direction_approbation_status','human_resources_status','created_at'])
            ->with(['requestDays:id,requests_id,start,end', 'reveal:id,first_name,last_name'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Historial de vacaciones aprobadas agrupado por año
        $vacationHistory = RequestVacations::where('user_id', $userId)
            ->where('type_request', 'Vacaciones')
            ->where('direct_manager_status', 'Aprobada')
            ->where('human_resources_status', 'Aprobada')
            ->with(['approvedRequests'])
            ->orderBy('start', 'desc')
            ->get()
            ->groupBy(fn($v) => date('Y', strtotime($v->start)))
            ->map(function ($yearVacations, $year) {
                $details = $yearVacations->map(fn($v) => [
                    'id'           => $v->id,
                    'start'        => $v->start,
                    'end'          => $v->end,
                    'days_count'   => $v->approvedRequests->count(),
                    'approved_days'=> $v->approvedRequests->map(fn($d) => date('d/m/Y', strtotime($d->start)))->toArray(),
                ]);
                return ['year' => $year, 'total_days' => $details->sum('days_count'), 'vacations' => $details];
            })->sortKeysDesc();

        // Firma y términos
        $userSignature    = UserSignature::forUser($userId);
        $hasSignature     = $userSignature !== null;
        $termsRecord      = UserSignature::where('user_id', $userId)->first();
        $hasAcceptedTerms = $termsRecord && $termsRecord->terms_accepted_at !== null;
        $termsAcceptedAt  = $hasAcceptedTerms ? $termsRecord->terms_accepted_at : null;

        // Info de desbloqueo si < 1 año
        $unlockInfo = null;
        if ($currentUser->admission) {
            $admissionDate = \Carbon\Carbon::parse($currentUser->admission);
            $oneYearDate   = $admissionDate->copy()->addYear();
            if ($now->lt($oneYearDate)) {
                $unlockInfo = [
                    'unlock_date'    => $oneYearDate->format('d/m/Y'),
                    'days_remaining' => $now->diffInDays($oneYearDate),
                    'admission_date' => $admissionDate->format('d/m/Y'),
                ];
            }
        }

        return view('vacaciones.perfil-usuario', compact(
            'currentUser', 'vacationPeriods', 'requests', 'vacationHistory',
            'userSignature', 'hasSignature', 'hasAcceptedTerms', 'termsAcceptedAt',
            'unlockInfo'
        ));
    }

    /**
     * Vista original con Blade para reporte de vacaciones (deprecated - usar vacationReportLivewire)
     */
    public function vacationReport(VacationCalculatorService $calculator)
    {
        // Verificar permisos de RH
        if (!auth()->user()->can('ver modulo rrhh')) {
            return redirect()->route('home')->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        // Obtener todos los usuarios activos con sus relaciones
        $employees = User::with(['job.departamento', 'requestVacations'])
            ->whereHas('job')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        // Obtener departamentos para filtros
        $departments = Departamento::all();

        // Aplicar filtros si existen
        $userFilter = request('user_filter');
        $departmentFilter = request('department_filter');
        $yearFilter = request('year_filter', date('Y'));

        if ($userFilter) {
            $employees = $employees->filter(function ($employee) use ($userFilter) {
                return $employee->id == $userFilter;
            });
        }

        if ($departmentFilter) {
            $employees = $employees->filter(function ($employee) use ($departmentFilter) {
                return $employee->job && $employee->job->departamento && $employee->job->departamento->id == $departmentFilter;
            });
        }

        // Procesar datos de vacaciones para cada empleado usando el servicio
        $employeesData = $employees->map(function ($employee) use ($yearFilter, $calculator) {
            // Obtener datos de vacaciones del servicio
            $vacationData = $calculator->getAvailableDaysForUser($employee);
            
            // Calcular días tomados en el año seleccionado
            $daysTaken = RequestVacations::where('user_id', $employee->id)
                ->where('human_resources_status', 'Aprobada')
                ->whereHas('requestDays', function ($query) use ($yearFilter) {
                    $query->whereYear('start', $yearFilter);
                })
                ->with('requestDays')
                ->get()
                ->sum(function ($request) use ($yearFilter) {
                    return $request->requestDays->filter(function ($day) use ($yearFilter) {
                        return date('Y', strtotime($day->start)) == $yearFilter;
                    })->count();
                });

            // Obtener solicitudes del año para mostrar períodos
            $vacationPeriods = RequestVacations::where('user_id', $employee->id)
                ->where('human_resources_status', 'Aprobada')
                ->whereHas('requestDays', function ($query) use ($yearFilter) {
                    $query->whereYear('start', $yearFilter);
                })
                ->with('requestDays')
                ->get()
                ->map(function ($request) use ($yearFilter) {
                    $days = $request->requestDays->filter(function ($day) use ($yearFilter) {
                        return date('Y', strtotime($day->start)) == $yearFilter;
                    })->sortBy('start');
                    
                    if ($days->count() > 0) {
                        return [
                            'start' => $days->first()->start,
                            'end' => $days->last()->start,
                            'days_count' => $days->count(),
                            'type' => $request->type_request
                        ];
                    }
                    return null;
                })->filter()->values();

            // Obtener TODOS los períodos de vacaciones del usuario (de la tabla vacations_availables)
            $allVacationPeriods = VacationsAvailable::where('users_id', $employee->id)
                ->orderBy('date_start')
                ->get();

            // Usar datos calculados por el servicio
            $daysEntitled = $vacationData['total_available'];
            $daysRemaining = $vacationData['total_remaining'];

            return [
                'employee' => $employee,
                'days_entitled' => $daysEntitled,
                'days_taken' => $daysTaken,
                'days_remaining' => $daysRemaining,
                'vacation_periods' => $vacationPeriods,
                'all_vacation_periods' => $allVacationPeriods, // Todos los períodos históricos y actuales
                'year' => $yearFilter,
                'vacation_data' => $vacationData // Datos adicionales del servicio
            ];
        });

        return view('vacaciones.vacation_report', compact(
            'employeesData',
            'departments',
            'departmentFilter',
            'yearFilter'
        ));
    }

    /**
     * Actualizar días disfrutados de un período de vacaciones
     */
    public function updateDaysEnjoyed(Request $request)
    {
        // Verificar permisos de RH
        if (!auth()->user()->can('ver modulo rrhh')) {
            return response()->json(['success' => false, 'message' => 'No tienes permisos para realizar esta acción.'], 403);
        }

        $request->validate([
            'vacation_id' => 'required|exists:vacations_availables,id',
            'days_enjoyed' => 'required|numeric|min:0',
            'status' => 'sometimes|in:actual,vencido'
        ]);

        try {
            $vacation = VacationsAvailable::findOrFail($request->vacation_id);
            
            // Validar que no exceda los días disponibles
            $maxDays = $vacation->days_availables;
            if ($request->days_enjoyed > $maxDays) {
                return response()->json([
                    'success' => false, 
                    'message' => "Los días disfrutados no pueden exceder {$maxDays} días disponibles."
                ], 400);
            }

            $vacation->days_enjoyed = $request->days_enjoyed;
            
            // Actualizar status si se proporciona y no es histórico
            if ($request->has('status') && !$vacation->is_historical) {
                $vacation->status = $request->status;
            }
            
            $vacation->save();

            return response()->json([
                'success' => true, 
                'message' => 'Período actualizado correctamente.',
                'days_remaining' => $maxDays - $request->days_enjoyed,
                'status' => $vacation->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Sincroniza/actualiza la acumulación de vacaciones de todos los usuarios
     */
    public function syncVacations()
    {
        try {
            $startTime = now();
            
            // Ejecutar el comando Artisan para actualizar vacaciones
            Artisan::call('vacations:update-accrual', [
                '--all' => true,
                '--force' => true
            ]);

            $output = Artisan::output();
            $endTime = now();
            $duration = $startTime->diffInSeconds($endTime);
            
            // Procesar el output para extraer información
            $lines = explode("\n", trim($output));
            $updates = [];
            $errors = [];
            
            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) continue;
                
                if (str_contains($line, 'Actualizando vacaciones para')) {
                    $updates[] = $line;
                } elseif (str_contains($line, 'Error') || str_contains($line, 'error')) {
                    $errors[] = $line;
                } elseif (str_contains($line, '✓') || str_contains($line, 'completado') || str_contains($line, 'actualizado')) {
                    $updates[] = $line;
                }
            }
            
            Log::info('Sincronización manual de vacaciones ejecutada', [
                'duration' => $duration . ' segundos',
                'updates_count' => count($updates),
                'errors_count' => count($errors)
            ]);
            
            // Guardar datos en sesión para mostrar en modal
            return redirect()->back()->with([
                'sync_completed' => true,
                'sync_duration' => $duration,
                'sync_updates' => $updates,
                'sync_errors' => $errors,
                'sync_output' => $output,
                'sync_timestamp' => $startTime->format('d/m/Y H:i:s')
            ]);
        } catch (\Exception $e) {
            Log::error('Error al sincronizar vacaciones: ' . $e->getMessage());
            return redirect()->back()->with([
                'sync_error' => true,
                'sync_error_message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Genera PDF de solicitud de vacaciones
     */
    public function generateVacationPdf($requestId)
    {
        
        try {
            // Obtener la solicitud con sus relaciones
            $request = RequestVacations::with([
                'user.job.departamento',
                'user.jefe',
                'user.razonSocial',
                'directManager',
                'directionApprover',
                'reveal',
                'requestDays'
            ])->findOrFail($requestId);

            // Verificar que la solicitud esté aprobada
            if ($request->human_resources_status !== 'Aprobada') {
                return redirect()->back()->with('error', 'Solo se pueden generar PDFs de solicitudes aprobadas.');
            }

            // Obtener información del usuario
            $user = $request->user;
            $boss = $user->jefe;
            $departamento = $user->job->departamento ?? null;
            $reveal = $request->reveal;

            // Calcular fechas
            $requestDays = $request->requestDays->sortBy('start');
            $fechaInicio = $requestDays->first()->start ?? null;
            $fechaFin = $requestDays->last()->start ?? null;
            $totalDias = $requestDays->count();

            // Obtener años de antigüedad
            $fechaIngreso = Carbon::parse($user->admission);
            $antiguedad = $fechaIngreso->diffInYears(Carbon::now());

            // Obtener el período específico referenciado en la solicitud (campo opcion)
            $vacationPeriod = $request->vacationPeriod;

            if ($vacationPeriod) {
                // days_availables ya ES el saldo real del período específico
                $diasDisponibles = (float) $vacationPeriod->days_availables;
            } else {
                // Fallback: sumar todos los períodos activos si no hay período específico
                $vacationAvailables = VacationsAvailable::where('users_id', $user->id)
                    ->where('status', 'actual')
                    ->get();
                $diasDisponibles = $vacationAvailables->sum(function($vacation) {
                    return $vacation->days_availables;
                });
            }

            // Preparar datos para la vista
            $data = [
                'request' => $request,
                'user' => $user,
                'boss' => $boss,
                'departamento' => $departamento,
                'reveal' => $reveal,
                'fechaInicio' => $fechaInicio ? Carbon::parse($fechaInicio) : null,
                'fechaFin' => $fechaFin ? Carbon::parse($fechaFin) : null,
                'totalDias' => $totalDias,
                'requestDays' => $requestDays,
                'antiguedad' => $antiguedad,
                'diasDisponibles' => $diasDisponibles,
                'vacationPeriod' => $vacationPeriod ?? null,
                'fechaGeneracion' => Carbon::now(),
                'companies' => RazonSocial::whereIn('id', [1,2])->get(),
                'sigColaborador' => UserSignature::forUser($user->id),
                'sigJefe' => $request->direct_manager_id
                    ? UserSignature::forUser($request->direct_manager_id)
                    : null,
                'sigRRHH' => null,
                'sigDireccion' => $request->direction_approbation_id
                    ? UserSignature::forUser($request->direction_approbation_id)
                    : null,
            ];

           /*  return view('vacaciones.pdf.solicitud', $data); */
            // Generar PDF
            $pdf = Pdf::loadView('vacaciones.pdf.solicitud', $data);
            $pdf->setPaper('letter', 'portrait');

            // Nombre del archivo
            $fileName = 'Solicitud_Vacaciones_' . $user->first_name . '_' . $user->last_name . '_' . Carbon::now()->format('Ymd') . '.pdf';

            return $pdf->download($fileName);

        } catch (\Exception $e) {
            Log::error('Error al generar PDF de vacaciones: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar períodos de vacaciones para todos los empleados
     */
    public function updatePeriods()
    {
        try {
            $startTime = now();
            $periodCreator = new VacationPeriodCreatorService();
            
            // Obtener todos los usuarios activos
            $users = User::where('status', 'Activo')->get();
            $results = [
                'total_users' => 0,
                'periods_created' => 0,
                'errors' => 0
            ];
            
            foreach ($users as $user) {
                try {
                    $created = $periodCreator->createMissingPeriodsForUser($user->id);
                    $results['total_users']++;
                    $results['periods_created'] += count($created);
                } catch (\Exception $e) {
                    $results['errors']++;
                    Log::error("Error actualizando períodos para usuario {$user->id}: " . $e->getMessage());
                }
            }
            
            $endTime = now();
            $duration = $startTime->diffInSeconds($endTime);
            
            Log::info('Actualización masiva de períodos ejecutada', [
                'duration' => $duration . ' segundos',
                'results' => $results
            ]);
            
            return redirect()->back()->with([
                'success' => "Períodos actualizados correctamente. Se crearon {$results['periods_created']} nuevos períodos para {$results['total_users']} empleados en {$duration} segundos.",
                'update_periods_completed' => true,
                'update_periods_results' => $results,
                'update_periods_duration' => $duration
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al actualizar períodos: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al actualizar períodos: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar acumulación diaria de días de vacaciones
     */
    public function updateDays()
    {
        try {
            $startTime = now();
            $dailyAccumulator = new VacationDailyAccumulatorService();
            
            // Ejecutar actualización masiva
            $results = $dailyAccumulator->updateDailyAccumulationForAllUsers();
            
            $endTime = now();
            $duration = $startTime->diffInSeconds($endTime);
            
            Log::info('Actualización masiva de días ejecutada', [
                'duration' => $duration . ' segundos',
                'results' => $results
            ]);
            
            $message = "Días actualizados correctamente. " .
                       "Usuarios procesados: {$results['users_processed']}, " .
                       "Períodos actualizados: {$results['periods_updated']}, " .
                       "Períodos vencidos: {$results['periods_expired']}, " .
                       "Tiempo: {$duration} segundos.";
            
            return redirect()->back()->with([
                'success' => $message,
                'update_days_completed' => true,
                'update_days_results' => $results,
                'update_days_duration' => $duration
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al actualizar días: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al actualizar días: ' . $e->getMessage());
        }
    }
}
