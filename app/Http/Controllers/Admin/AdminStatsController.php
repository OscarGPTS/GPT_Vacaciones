<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;

class AdminStatsController extends Controller
{
    private function ensureSuperOwner(): void
    {
        if (auth()->id() !== 333) {
            abort(403, 'Acceso denegado.');
        }
    }

    /** Centralised data-gathering used by index, exportExcel and exportPdf */
    private function buildStats(int $range): array
    {
        $since = Carbon::now()->subDays($range)->startOfDay();

        $reqBase = DB::connection('mysql_vacations')->table('requests');

        $totalRequests        = (clone $reqBase)->count();
        $requestsSince        = (clone $reqBase)->where('created_at', '>=', $since)->count();

        $fullyApproved = (clone $reqBase)
            ->where('direct_manager_status', 'Aprobada')
            ->where('human_resources_status', 'Aprobada')
            ->where('direction_approbation_status', 'Aprobada')
            ->count();

        $rejected = (clone $reqBase)
            ->where(function ($q) {
                $q->where('direct_manager_status', 'Rechazada')
                  ->orWhere('human_resources_status', 'Rechazada')
                  ->orWhere('direction_approbation_status', 'Rechazada');
            })
            ->count();

        $pendingAll = (clone $reqBase)
            ->where('direct_manager_status', 'Pendiente')
            ->where('human_resources_status', 'Pendiente')
            ->count();

        $requestsPerDay = (clone $reqBase)
            ->select(DB::raw('DATE(created_at) as day'), DB::raw('COUNT(*) as cnt'))
            ->where('created_at', '>=', $since)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        $dailyLabels = [];
        $dailyData   = [];
        for ($i = $range - 1; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i)->format('Y-m-d');
            $dailyLabels[] = Carbon::now()->subDays($i)->format('d/m');
            $dailyData[]   = $requestsPerDay->has($day) ? $requestsPerDay[$day]->cnt : 0;
        }

        $requestsByMonth = (clone $reqBase)
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('COUNT(*) as cnt'))
            ->where('created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
            ->orderBy('month')
            ->get();

        $monthLabels = [];
        $monthData   = [];
        foreach ($requestsByMonth as $row) {
            $monthLabels[] = Carbon::createFromFormat('Y-m', $row->month)->locale('es')->isoFormat('MMM YY');
            $monthData[]   = $row->cnt;
        }

        $activeEmployeesCount = (clone $reqBase)
            ->where('created_at', '>=', $since)
            ->distinct('user_id')
            ->count('user_id');

        $totalUsers = User::where('active', 1)->count();
        $newUsers   = User::where('active', 1)->where('created_at', '>=', $since)->count();

        $topRequesters = (clone $reqBase)
            ->select('user_id', DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', $since)
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $topRequesterIds   = $topRequesters->pluck('user_id')->toArray();
        $topRequesterUsers = User::whereIn('id', $topRequesterIds)
            ->get(['id', 'first_name', 'last_name', 'email'])
            ->keyBy('id');

        $topRequestersList = $topRequesters->map(function ($row) use ($topRequesterUsers) {
            $user = $topRequesterUsers->get($row->user_id);
            return [
                'name'  => $user ? $user->first_name . ' ' . $user->last_name : 'Usuario #' . $row->user_id,
                'email' => $user?->email ?? '—',
                'total' => $row->total,
            ];
        });

        $vaBase            = DB::connection('mysql_vacations')->table('vacations_availables');
        $totalPeriods      = (clone $vaBase)->count();
        $totalAvailDays    = (clone $vaBase)->sum('days_availables');
        $totalEnjoyedDays  = (clone $vaBase)->sum('days_enjoyed');
        $totalReservedDays = (clone $vaBase)->sum('days_reserved');
        $expiredPeriods    = (clone $vaBase)->where('status', 'vencido')->count();
        $activePeriods     = (clone $vaBase)->where('status', 'actual')->count();

        $logsBase     = DB::connection('mysql_vacations')->table('system_logs');
        $recentLogs   = (clone $logsBase)->orderByDesc('created_at')->limit(50)->get();
        $logsByLevel  = (clone $logsBase)->select('level', DB::raw('COUNT(*) as cnt'))->groupBy('level')->get()->keyBy('level');
        $logsByStatus = (clone $logsBase)->select('status', DB::raw('COUNT(*) as cnt'))->groupBy('status')->get()->keyBy('status');

        $recentAudits = DB::table('audits')
            ->select('id', 'user_id', 'event', 'auditable_type', 'ip_address', 'created_at')
            ->orderByDesc('created_at')
            ->limit(30)
            ->get();

        $auditsByEvent = DB::table('audits')
            ->select('event', DB::raw('COUNT(*) as cnt'))
            ->where('created_at', '>=', $since)
            ->groupBy('event')
            ->get()
            ->keyBy('event');

        $auditUserIds     = DB::table('audits')->where('created_at', '>=', $since)->whereNotNull('user_id')->distinct('user_id')->pluck('user_id')->toArray();
        $activeAuditUsers = User::whereIn('id', $auditUserIds)->get(['id', 'first_name', 'last_name'])->keyBy('id');

        $recentAuditsEnriched = $recentAudits->map(function ($audit) use ($activeAuditUsers) {
            $user = $activeAuditUsers->get($audit->user_id);
            $audit->user_name  = $user ? $user->first_name . ' ' . $user->last_name : '—';
            $audit->model_name = class_basename($audit->auditable_type ?? '');
            return $audit;
        });

        $auditPerDay = DB::table('audits')
            ->select(DB::raw('DATE(created_at) as day'), DB::raw('COUNT(DISTINCT user_id) as users'))
            ->where('created_at', '>=', $since)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        $auditDailyData = [];
        for ($i = $range - 1; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i)->format('Y-m-d');
            $auditDailyData[] = $auditPerDay->has($day) ? $auditPerDay[$day]->users : 0;
        }

        return compact(
            'range', 'since',
            'totalRequests', 'requestsSince', 'fullyApproved', 'rejected', 'pendingAll',
            'dailyLabels', 'dailyData', 'monthLabels', 'monthData',
            'activeEmployeesCount', 'topRequestersList',
            'totalUsers', 'newUsers',
            'totalPeriods', 'totalAvailDays', 'totalEnjoyedDays', 'totalReservedDays', 'expiredPeriods', 'activePeriods',
            'recentLogs', 'logsByLevel', 'logsByStatus',
            'recentAuditsEnriched', 'auditsByEvent', 'auditDailyData'
        );
    }

    public function index(Request $request)
    {
        $this->ensureSuperOwner();

        $range = (int) $request->input('range', 30);
        $data  = $this->buildStats($range);

        return view('admin.stats.index', $data);
    }

    public function exportExcel(Request $request)
    {
        $this->ensureSuperOwner();

        $range = (int) $request->input('range', 30);
        $data  = $this->buildStats($range);

        // ── Hoja 1: Resumen General ──────────────────────────────────
        $sheetResumen = collect([
            ['Métrica' => 'Rango de días analizado',          'Valor' => $data['range']],
            ['Métrica' => 'Desde',                            'Valor' => $data['since']->format('d/m/Y')],
            ['Métrica' => 'Generado el',                      'Valor' => now()->format('d/m/Y H:i')],
            ['Métrica' => '',                                  'Valor' => ''],
            ['Métrica' => '--- SOLICITUDES ---',              'Valor' => ''],
            ['Métrica' => 'Total de solicitudes',             'Valor' => $data['totalRequests']],
            ['Métrica' => 'Solicitudes en el rango',          'Valor' => $data['requestsSince']],
            ['Métrica' => 'Completamente aprobadas',          'Valor' => $data['fullyApproved']],
            ['Métrica' => 'Con algún rechazo',                'Valor' => $data['rejected']],
            ['Métrica' => 'Sin ninguna aprobación',           'Valor' => $data['pendingAll']],
            ['Métrica' => '',                                  'Valor' => ''],
            ['Métrica' => '--- EMPLEADOS ---',                'Valor' => ''],
            ['Métrica' => 'Empleados activos (total)',        'Valor' => $data['totalUsers']],
            ['Métrica' => 'Nuevos en el rango',               'Valor' => $data['newUsers']],
            ['Métrica' => 'Empleados que solicitaron (rango)', 'Valor' => $data['activeEmployeesCount']],
            ['Métrica' => '',                                  'Valor' => ''],
            ['Métrica' => '--- SALDO VACACIONES (GLOBAL) ---', 'Valor' => ''],
            ['Métrica' => 'Total períodos registrados',       'Valor' => $data['totalPeriods']],
            ['Métrica' => 'Períodos activos',                 'Valor' => $data['activePeriods']],
            ['Métrica' => 'Períodos vencidos',                'Valor' => $data['expiredPeriods']],
            ['Métrica' => 'Días disponibles (suma)',          'Valor' => number_format($data['totalAvailDays'], 1)],
            ['Métrica' => 'Días disfrutados (suma)',          'Valor' => number_format($data['totalEnjoyedDays'], 1)],
            ['Métrica' => 'Días reservados (suma)',           'Valor' => number_format($data['totalReservedDays'], 1)],
            ['Métrica' => '',                                  'Valor' => ''],
            ['Métrica' => '--- AUDITORÍA (rango) ---',        'Valor' => ''],
            ['Métrica' => 'Registros creados',                'Valor' => $data['auditsByEvent']->get('created')?->cnt ?? 0],
            ['Métrica' => 'Registros actualizados',           'Valor' => $data['auditsByEvent']->get('updated')?->cnt ?? 0],
            ['Métrica' => 'Registros eliminados',             'Valor' => $data['auditsByEvent']->get('deleted')?->cnt ?? 0],
        ]);

        // ── Hoja 2: Solicitudes por día ─────────────────────────────
        $sheetDias = collect();
        foreach ($data['dailyLabels'] as $i => $label) {
            $sheetDias->push(['Fecha' => $label, 'Solicitudes' => $data['dailyData'][$i]]);
        }

        // ── Hoja 3: Top solicitantes ─────────────────────────────────
        $sheetTop = collect();
        foreach ($data['topRequestersList'] as $i => $row) {
            $sheetTop->push([
                '#'             => $i + 1,
                'Nombre'        => $row['name'],
                'Correo'        => $row['email'],
                'Solicitudes'   => $row['total'],
            ]);
        }

        // ── Hoja 4: System Logs ──────────────────────────────────────
        $sheetLogs = $data['recentLogs']->map(fn ($l) => [
            'Nivel'   => $l->level,
            'Tipo'    => $l->type,
            'Mensaje' => $l->message,
            'Estado'  => $l->status,
            'Fecha'   => $l->created_at,
        ]);

        // ── Hoja 5: Auditoría ────────────────────────────────────────
        $sheetAudits = $data['recentAuditsEnriched']->map(fn ($a) => [
            'Evento'   => $a->event,
            'Modelo'   => $a->model_name,
            'Usuario'  => $a->user_name,
            'IP'       => $a->ip_address ?? '—',
            'Fecha'    => $a->created_at,
        ]);

        $sheets = new SheetCollection([
            'Resumen'         => $sheetResumen,
            'Solicitudes x Día' => $sheetDias,
            'Top Solicitantes' => $sheetTop,
            'System Logs'     => $sheetLogs,
            'Auditoría'       => $sheetAudits,
        ]);

        $filename = 'estadisticas-sistema-' . now()->format('Y-m-d') . '.xlsx';

        return (new FastExcel($sheets))->download($filename);
    }

    public function exportPdf(Request $request)
    {
        $this->ensureSuperOwner();

        $range = (int) $request->input('range', 30);
        $data  = $this->buildStats($range);

        $pdf = Pdf::loadView('admin.stats.export-pdf', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions(['defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => true]);

        $filename = 'estadisticas-sistema-' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}

