<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correo de Prueba - Sistema RRHH</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 650px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 0;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 40px 30px;
            text-align: center;
        }
        .test-badge {
            display: inline-block;
            background: #ffc107;
            color: #000;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .content {
            padding: 40px 30px;
        }
        .test-warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .test-warning h3 {
            margin: 0 0 10px 0;
            color: #856404;
            font-size: 18px;
            font-weight: 600;
        }
        .test-warning p {
            margin: 0;
            color: #856404;
            font-size: 14px;
        }
        .info-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 25px;
            margin: 25px 0;
        }
        .info-box h3 {
            margin: 0 0 20px 0;
            color: #495057;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-row {
            margin: 15px 0;
            font-size: 15px;
            display: flex;
            align-items: center;
        }
        .info-label {
            font-weight: 600;
            color: #495057;
            min-width: 140px;
            display: inline-block;
        }
        .info-value {
            color: #212529;
        }
        .success-message {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            border-left: 4px solid #28a745;
            color: #155724;
            padding: 20px;
            border-radius: 4px;
            margin: 25px 0;
        }
        .success-message h3 {
            margin: 0 0 10px 0;
            font-size: 18px;
        }
        .footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }
        .footer p {
            margin: 5px 0;
            font-size: 13px;
            color: #6c757d;
        }
        .button {
            display: inline-block;
            background: #667eea;
            color: #ffffff;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: 600;
        }
        .icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="test-badge">🧪 CORREO DE PRUEBA</div>
            <div class="icon">✉️</div>
            <h1>Sistema RRHH Satech Energy</h1>
            <p style="margin: 10px 0 0 0; font-size: 16px;">Prueba de Envío de Correo Electrónico</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="test-warning">
                <h3>⚠️ Este es un correo de prueba</h3>
                <p>
                    Este mensaje fue enviado desde el sistema de gestión de recursos humanos con el único propósito 
                    de verificar que el sistema de envío de correos electrónicos está funcionando correctamente.
                </p>
            </div>

            <div class="success-message">
                <h3>✅ El sistema de correo funciona correctamente</h3>
                <p>
                    Si estás recibiendo este mensaje, significa que el servidor de correo electrónico está 
                    configurado adecuadamente y puede enviar notificaciones del sistema.
                </p>
            </div>

            <div class="info-box">
                <h3>📋 Información del Remitente</h3>
                <div class="info-row">
                    <span class="info-label">👤 Nombre:</span>
                    <span class="info-value">{{ $senderName }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">📧 Correo:</span>
                    <span class="info-value">{{ $senderEmail }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">📅 Fecha:</span>
                    <span class="info-value">{{ now()->format('d/m/Y H:i:s') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">🖥️ Sistema:</span>
                    <span class="info-value">RRHH Satech Energy</span>
                </div>
            </div>

            <div style="background: #e7f3ff; border: 1px solid #b3d9ff; border-radius: 6px; padding: 20px; margin: 25px 0;">
                <p style="margin: 0; color: #004085; font-size: 14px;">
                    <strong>ℹ️ Nota:</strong> Este correo fue generado desde la herramienta de prueba del módulo de administración. 
                    No requiere ninguna acción por tu parte.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="font-weight: 600; color: #495057;">Sistema de Gestión de Recursos Humanos</p>
            <p>Satech Energy</p>
            <p style="margin-top: 15px; font-size: 12px;">
                Este es un correo generado automáticamente, por favor no responder.
            </p>
        </div>
    </div>
</body>
</html>
