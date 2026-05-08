<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas del Sistema</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.45;
        }

        /* ── Cover header ──────────────────────── */
        .page-header {
            background: #CF0A2C;
            color: #fff;
            padding: 18px 22px 14px;
            margin-bottom: 18px;
        }
        .page-header h1 {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: .4px;
        }
        .page-header p {
            font-size: 10px;
            margin-top: 3px;
            opacity: .85;
        }
        .accent-bar {
            height: 3px;
            background: #F9BE00;
            margin-bottom: 20px;
        }

        /* ── Sections ─────────────────────────── */
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #CF0A2C;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 4px;
            margin-bottom: 10px;
        }

        /* ── KPI grid ─────────────────────────── */
        .kpi-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .kpi-grid td {
            width: 25%;
            padding: 10px 12px;
            vertical-align: top;
        }
        .kpi-box {
            background: #f8f9fa;
            border-left: 3px solid #CF0A2C;
            padding: 8px 10px;
            border-radius: 2px;
        }
        .kpi-value {
            font-size: 20px;
            font-weight: 700;
            color: #CF0A2C;
            line-height: 1.1;
        }
        .kpi-label {
            font-size: 9px;
            color: #666;
            margin-top: 2px;
            text-transform: uppercase;
            letter-spacing: .3px;
        }
        .kpi-sub {
            font-size: 9px;
            color: #999;
            margin-top: 2px;
        }

        /* ── Tables ───────────────────────────── */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 6px;
        }
        .data-table thead th {
            background: #f0f0f0;
            padding: 5px 8px;
            text-align: left;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 9px;
            letter-spacing: .3px;
            border-bottom: 1px solid #ccc;
        }
        .data-table tbody td {
            padding: 5px 8px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: top;
        }
        .data-table tbody tr:nth-child(even) td {
            background: #fafafa;
        }

        /* ── Two-column layout ────────────────── */
        .two-col {
            width: 100%;
            border-collapse: collapse;
        }
        .two-col > tbody > tr > td {
            width: 50%;
            vertical-align: top;
            padding: 0 8px 0 0;
        }
        .two-col > tbody > tr > td:last-child {
            padding: 0 0 0 8px;
        }

        /* ── Badges ───────────────────────────── */
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: 700;
        }
        .badge-error   { background: #fee2e2; color: #b91c1c; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-info    { background: #dbeafe; color: #1d4ed8; }
        .badge-created { background: #d1fae5; color: #065f46; }
        .badge-updated { background: #fef3c7; color: #92400e; }
        .badge-deleted { background: #fee2e2; color: #b91c1c; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-resolved { background: #d1fae5; color: #065f46; }

        /* ── Footer ──────────────────────────── */
        .page-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 22px;
            background: #222;
            color: #aaa;
            font-size: 9px;
            text-align: center;
            padding-top: 6px;
        }
        .footer-accent { color: #F9BE00; font-weight: 700; }

        /* ── Daily sparkline table ────────────── */
        .spark-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 3px;
        }
        .spark-cell {
            display: inline-block;
            width: 28px;
            text-align: center;
            font-size: 9px;
            background: #f0f4ff;
            border-radius: 2px;
            padding: 2px 0;
        }
        .spark-cell span {
            display: block;
            font-size: 10px;
            font-weight: 700;
            color: #3b82f6;
        }
        .spark-cell small {
            display: block;
            color: #999;
            font-size: 8px;
        }
    </style>
</head>
<body>

<div class="page-header">
    <h1>Panel de Estadísticas — Sistema de RRHH</h1>
    <p>
        Período analizado: últimos {{ $range }} días &nbsp;·&nbsp;
        Desde {{ $since->format('d/m/Y') }} hasta {{ now()->format('d/m/Y') }} &nbsp;·&nbsp;
        Generado el {{ now()->format('d/m/Y H:i') }}
    </p>
</div>
<div class="accent-bar"></div>

{{-- ── KPIs ──────────────────────────────────────────────────────── --}}
<div class="section">
    <div class="section-title">Resumen General</div>

    <table class="kpi-grid">
        <tr>
            <td>
                <div class="kpi-box">
                    <div class="kpi-value">{{ $totalRequests }}</div>
                    <div class="kpi-label">Solicitudes totales</div>
                    <div class="kpi-sub">+{{ $requestsSince }} en el rango</div>
                </div>
            </td>
            <td>
                <div class="kpi-box" style="border-color:#10b981;">
                    <div class="kpi-value" style="color:#10b981;">{{ $fullyApproved }}</div>
                    <div class="kpi-label">Aprobadas completas</div>
                    <div class="kpi-sub">{{ $rejected }} con algún rechazo</div>
                </div>
            </td>
            <td>
                <div class="kpi-box" style="border-color:#f59e0b;">
                    <div class="kpi-value" style="color:#f59e0b;">{{ $pendingAll }}</div>
                    <div class="kpi-label">Pendientes sin aprobación</div>
                    <div class="kpi-sub">&nbsp;</div>
                </div>
            </td>
            <td>
                <div class="kpi-box" style="border-color:#8b5cf6;">
                    <div class="kpi-value" style="color:#8b5cf6;">{{ $totalUsers }}</div>
                    <div class="kpi-label">Empleados activos</div>
                    <div class="kpi-sub">{{ $activeEmployeesCount }} solicitaron en rango</div>
                </div>
            </td>
        </tr>
    </table>
</div>

{{-- ── Saldo Vacaciones ──────────────────────────────────────────── --}}
<div class="section">
    <div class="section-title">Saldo Global de Vacaciones</div>
    <table class="kpi-grid">
        <tr>
            <td>
                <div class="kpi-box" style="border-color:#3b82f6;">
                    <div class="kpi-value" style="color:#3b82f6;">{{ number_format($totalAvailDays, 1) }}</div>
                    <div class="kpi-label">Días disponibles (suma)</div>
                </div>
            </td>
            <td>
                <div class="kpi-box" style="border-color:#10b981;">
                    <div class="kpi-value" style="color:#10b981;">{{ number_format($totalEnjoyedDays, 1) }}</div>
                    <div class="kpi-label">Días disfrutados (suma)</div>
                </div>
            </td>
            <td>
                <div class="kpi-box" style="border-color:#f59e0b;">
                    <div class="kpi-value" style="color:#f59e0b;">{{ number_format($totalReservedDays, 1) }}</div>
                    <div class="kpi-label">Días reservados (suma)</div>
                </div>
            </td>
            <td>
                <div class="kpi-box" style="border-color:#ef4444;">
                    <div class="kpi-value" style="color:#ef4444;">{{ $expiredPeriods }}</div>
                    <div class="kpi-label">Períodos vencidos</div>
                    <div class="kpi-sub">{{ $activePeriods }} activos</div>
                </div>
            </td>
        </tr>
    </table>
</div>

{{-- ── Solicitudes por día ───────────────────────────────────────── --}}
<div class="section">
    <div class="section-title">Solicitudes Creadas por Día (últimos {{ $range }} días)</div>
    <table class="data-table">
        <thead>
            <tr>
                @foreach($dailyLabels as $label)
                    <th style="text-align:center; padding:3px 4px;">{{ $label }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach($dailyData as $count)
                    <td style="text-align:center; font-weight:{{ $count > 0 ? '700' : '400' }}; color:{{ $count > 0 ? '#3b82f6' : '#ccc' }};">
                        {{ $count }}
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>
</div>

{{-- ── Two-col: Top Solicitantes + Auditoría Eventos ────────────── --}}
<div class="section">
    <table class="two-col">
        <tr>
            <td>
                <div class="section-title">Top Solicitantes — Rango {{ $range }} días</div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Empleado</th>
                            <th style="text-align:right;">Solicitudes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topRequestersList as $i => $tr)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>
                                {{ $tr['name'] }}
                                <br><span style="color:#999; font-size:9px;">{{ $tr['email'] }}</span>
                            </td>
                            <td style="text-align:right; font-weight:700; color:#CF0A2C;">{{ $tr['total'] }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" style="color:#999; text-align:center; padding:8px;">Sin solicitudes en el rango</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </td>

            <td>
                <div class="section-title">Eventos de Auditoría (rango)</div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Evento</th>
                            <th style="text-align:right;">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['created' => 'Creaciones', 'updated' => 'Actualizaciones', 'deleted' => 'Eliminaciones'] as $key => $label)
                        <tr>
                            <td>{{ $label }}</td>
                            <td style="text-align:right; font-weight:700;">{{ $auditsByEvent->get($key)?->cnt ?? 0 }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="section-title" style="margin-top:12px;">System Logs por Nivel</div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nivel</th>
                            <th style="text-align:right;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['error' => 'Error', 'warning' => 'Advertencia', 'info' => 'Info', 'debug' => 'Debug'] as $key => $label)
                        @if(isset($logsByLevel[$key]))
                        <tr>
                            <td><span class="badge badge-{{ $key }}">{{ $label }}</span></td>
                            <td style="text-align:right; font-weight:700;">{{ $logsByLevel[$key]->cnt }}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</div>

{{-- ── System Logs recientes ─────────────────────────────────────── --}}
<div class="section" style="page-break-before: always;">
    <div class="section-title">System Logs Recientes (últimos 50)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:60px;">Nivel</th>
                <th style="width:110px;">Tipo</th>
                <th>Mensaje</th>
                <th style="width:70px;">Estado</th>
                <th style="width:80px;">Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentLogs as $log)
            <tr>
                <td><span class="badge badge-{{ $log->level }}">{{ $log->level }}</span></td>
                <td>{{ $log->type }}</td>
                <td>{{ \Illuminate\Support\Str::limit($log->message, 90) }}</td>
                <td><span class="badge badge-{{ $log->status }}">{{ $log->status }}</span></td>
                <td style="color:#999;">{{ \Carbon\Carbon::parse($log->created_at)->format('d/m H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center; color:#999; padding:8px;">Sin logs registrados</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ── Auditoría reciente ────────────────────────────────────────── --}}
<div class="section">
    <div class="section-title">Auditoría Reciente (últimos 30 registros)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:65px;">Evento</th>
                <th style="width:90px;">Modelo</th>
                <th>Usuario</th>
                <th style="width:80px;">IP</th>
                <th style="width:80px;">Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentAuditsEnriched as $audit)
            <tr>
                <td><span class="badge badge-{{ $audit->event }}">{{ $audit->event }}</span></td>
                <td>{{ $audit->model_name }}</td>
                <td>{{ $audit->user_name }}</td>
                <td style="color:#999; font-size:9px;">{{ $audit->ip_address ?? '—' }}</td>
                <td style="color:#999;">{{ \Carbon\Carbon::parse($audit->created_at)->format('d/m H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center; color:#999; padding:8px;">Sin registros de auditoría</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="page-footer">
    <span class="footer-accent">GPT Services</span> · Sistema de Recursos Humanos · Generado el {{ now()->format('d/m/Y H:i') }} · Documento confidencial
</div>

</body>
</html>
