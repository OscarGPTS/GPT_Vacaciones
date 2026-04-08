<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud Aprobada por Jefe Directo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: #198754;
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px 20px;
        }
        .info-box {
            background: #d1e7dd;
            border-left: 4px solid #198754;
            padding: 15px;
            margin: 20px 0;
        }
        .info-box h3 {
            margin: 0 0 10px 0;
            color: #198754;
            font-size: 16px;
        }
        .info-row {
            margin: 8px 0;
        }
        .info-label {
            font-weight: bold;
            color: #666;
        }
        .days-list {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 15px;
            margin: 15px 0;
        }
        .day-item {
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .day-item:last-child {
            border-bottom: none;
        }
        .checkmark {
            color: #198754;
            font-size: 18px;
            margin-right: 5px;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            background: #198754;
            color: #fff;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
        }
        .warning-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ ¡Tu Solicitud Fue Aprobada!</h1>
        </div>
        
        <div class="content">
            <p>Hola <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong>,</p>
            
            <p>Tenemos buenas noticias. Tu jefe directo <strong>{{ $manager->first_name }} {{ $manager->last_name }}</strong> ha aprobado tu solicitud de vacaciones.</p>
            
            <div class="info-box">
                <h3>✓ Solicitud Aprobada por Jefe Directo</h3>
                <div class="info-row">
                    <span class="info-label">Días solicitados:</span> 
                    <strong>{{ $daysCount }} día(s)</strong>
                </div>
                <div class="info-row">
                    <span class="info-label">Estado actual:</span> 
                    <span class="badge">Pendiente de Recursos Humanos</span>
                </div>
            </div>

            @if($request->requestDays->count() > 0)
            <div class="days-list">
                <strong>📅 Días aprobados por tu jefe:</strong>
                @foreach($request->requestDays->sortBy('start') as $day)
                <div class="day-item">
                    <span class="checkmark">✓</span>
                    {{ \Carbon\Carbon::parse($day->start)->format('d/m/Y - l') }}
                </div>
                @endforeach
            </div>
            @endif

            <div class="warning-box">
                <strong>⏳ Siguiente paso:</strong><br>
                Tu solicitud ahora pasará a revisión de Dirección. Una vez aprobada por Dirección, será enviada a Recursos Humanos para la aprobación final. Te notificaremos del progreso.
            </div>

            <p>Gracias por tu paciencia.</p>
        </div>
        
        <div class="footer">
            <p>Este es un correo automático, por favor no responder.</p>
            <p>&copy; {{ date('Y') }} Sistema de Recursos Humanos - SATECH Energy</p>
        </div>
    </div>
</body>
</html>
