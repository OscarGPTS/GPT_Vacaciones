<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Tus vacaciones están disponibles!</title>
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
            background: #CF0A2C;
            color: #ffffff;
            padding: 40px 30px;
            text-align: center;
        }
        .logo {
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .header p {
            margin: 8px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
            color: #333333;
        }
        .success-message {
            background: #f0fdf4;
            border-left: 3px solid #22c55e;
            padding: 20px;
            margin: 25px 0;
            color: #166534;
        }
        .success-message h3 {
            margin: 0 0 10px 0;
            font-size: 16px;
            font-weight: 600;
        }
        .info-box {
            background: #fafafa;
            border-left: 3px solid #CF0A2C;
            padding: 20px;
            margin: 25px 0;
        }
        .info-box h3 {
            margin: 0 0 15px 0;
            color: #CF0A2C;
            font-size: 15px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-row {
            margin: 10px 0;
            font-size: 14px;
        }
        .info-label {
            font-weight: 600;
            color: #555555;
            display: inline-block;
            min-width: 160px;
        }
        .policy-box {
            background: #fef9ec;
            border-left: 3px solid #F9BE00;
            padding: 20px;
            margin: 25px 0;
        }
        .policy-box h3 {
            margin: 0 0 12px 0;
            color: #92400e;
            font-size: 15px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .policy-box ul {
            margin: 0;
            padding-left: 18px;
            font-size: 14px;
            color: #78350f;
        }
        .policy-box li {
            margin-bottom: 7px;
        }
        .cta-box {
            text-align: center;
            margin: 30px 0;
        }
        .cta-button {
            display: inline-block;
            background: #CF0A2C;
            color: #ffffff;
            padding: 14px 36px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 0.3px;
        }
        .badge-period {
            display: inline-block;
            padding: 6px 14px;
            background: #CF0A2C;
            color: #ffffff;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }
        .badge-days {
            display: inline-block;
            padding: 6px 14px;
            background: #22c55e;
            color: #ffffff;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }
        .footer {
            background: #2c2c2c;
            padding: 30px;
            text-align: center;
            font-size: 12px;
            color: #999999;
        }
        .footer-accent {
            color: #F9BE00;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">

        {{-- HEADER --}}
        <div class="header">
            <div class="logo">
                <svg width="140" height="57" viewBox="0 0 93.133331 37.835415" xmlns="http://www.w3.org/2000/svg">
                    <g transform="translate(-58.223892,-108.28795)">
                        <path style="fill:#ffffff" d="m 66.454435,117.49915 c -2.816387,1.1181 -5.310212,2.71303 -6.619458,6.05908 1.47735,3.71076 4.619124,6.10255 9.596462,7.03974 l 16.706249,0.1401 -0.07004,-12.81864 -13.27394,5e-5 -3.607429,4.41296 10.577123,0.1401 v 3.01203 l -10.787264,-0.17512 c -2.92795,-1.95664 -4.271273,-4.40429 -2.521703,-7.8103 z"/>
                        <path style="fill:#ffffff" d="M 89.815165,119.98583 V 130.633 l 6.33927,0.035 0.03503,-5.14847 13.168855,-0.14009 c 13.10808,-2.6908 8.64852,-14.21576 0.035,-15.51545 l -39.751761,0.17507 c -7.9867,1.18021 -10.636765,6.50987 -10.121816,11.24257 2.429541,-4.16438 6.111582,-5.10007 9.911674,-5.84894 l 39.436553,-0.21014 c 2.65766,0.99397 3.35436,4.03851 0,4.9033 z"/>
                        <path style="fill:#ffffff" d="m 124.89239,115.32133 0.19812,15.30502 6.33995,0.0495 -0.1486,-15.35455 7.67728,-0.0495 4.012,-5.10168 -29.02507,-0.0495 c 2.30505,1.31576 3.96832,2.96117 4.32069,5.25328 z"/>
                        <ellipse style="fill:none;stroke:#ffffff;stroke-width:0.429953" cx="146.76024" cy="112.72095" rx="2.5674231" ry="2.5178928"/>
                        <text style="font-weight:bold;font-size:4.23333px;font-family:Helvetica;fill:#ffffff" x="145.24956" y="114.18214"><tspan x="145.24956" y="114.18214">R</tspan></text>
                        <text style="font-weight:bold;font-size:13.8441px;font-family:Helvetica;fill:#F9BE00" transform="scale(1.2263456,0.81543083)" x="48.113392" y="174.89142"><tspan x="48.113392" y="174.89142">SERVICES</tspan></text>
                    </g>
                </svg>
            </div>
            <h1>🎉 ¡Feliz Aniversario! Tus vacaciones están disponibles</h1>
            <p>Período {{ $periodYear }}-{{ $periodYearEnd }}</p>
        </div>

        {{-- CONTENT --}}
        <div class="content">

            <p class="greeting">
                Estimado(a) <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong>,
            </p>

            {{-- CELEBRACIÓN --}}
            <div class="success-message">
                <h3>🎊 ¡Hoy es tu aniversario y tus días de vacaciones ya están disponibles!</h3>
                <p style="margin: 5px 0;">
                    Gracias por tu dedicación y compromiso. Como parte de tus prestaciones,
                    a partir de hoy puedes solicitar y disfrutar los días de vacaciones
                    correspondientes a tu período <strong>{{ $periodYear }}-{{ $periodYearEnd }}</strong>.
                    ¡Te los has ganado!
                </p>
            </div>

            {{-- DETALLES DEL PERÍODO --}}
            <div class="info-box">
                <h3>Detalle de Vacaciones Disponibles</h3>
                <div class="info-row">
                    <span class="info-label">Período:</span>
                    <span class="badge-period">{{ $periodYear }}-{{ $periodYearEnd }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Días disponibles:</span>
                    <span class="badge-days">{{ number_format($daysAvailable, 0) }} días</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Disponibles desde:</span>
                    <strong>{{ $dateEnd }}</strong>
                </div>
                <div class="info-row">
                    <span class="info-label">Fecha límite de uso:</span>
                    <strong>{{ $cutoffDate }}</strong>
                </div>
                <div class="info-row">
                    <span class="info-label">Tiempo para usarlos:</span>
                    <strong>15 meses</strong>
                    <span style="color:#666666; font-size:13px;">(del {{ $dateEnd }} al {{ $cutoffDate }})</span>
                </div>
            </div>

            {{-- POLÍTICAS --}}
            <div class="policy-box">
                <h3>Políticas de Vacaciones</h3>
                <ul>
                    <li>Tienes <strong>15 meses</strong> a partir de hoy para solicitar y disfrutar tus días de vacaciones.</li>
                    <li>Los días no utilizados antes del <strong>{{ $cutoffDate }}</strong> se perderán conforme a la política de la empresa.</li>
                    <li>Toda solicitud debe ser aprobada por tu jefe directo y por el Departamento de Recursos Humanos.</li>
                    <li>Te recomendamos planificar y solicitar tus vacaciones con anticipación.</li>
                    <li>Puedes revisar tu saldo y crear solicitudes en cualquier momento desde el sistema.</li>
                </ul>
            </div>

            {{-- CTA --}}
            <div class="cta-box">
                <a href="{{ config('app.url') }}/vacaciones" class="cta-button">
                    Solicitar mis vacaciones
                </a>
            </div>

            <p style="margin-top: 25px; font-size: 14px; color: #666666;">
                Si tienes alguna duda sobre tu saldo o el proceso de solicitud, comunícate con el
                Departamento de Recursos Humanos.
            </p>

        </div>

        {{-- FOOTER --}}
        <div class="footer">
            <p><span class="footer-accent">GPT Services</span> | Sistema de Recursos Humanos</p>
            <p>Este es un mensaje automático, por favor no responda a este correo.</p>
        </div>

    </div>
</body>
</html>
