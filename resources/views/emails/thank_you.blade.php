<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Arial', sans-serif; line-height: 1.6; color: #fff; background-color: #1a1a1d; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #222; padding: 30px; border: 1px solid #e62020; border-radius: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #e62020; text-transform: uppercase; font-size: 28px; margin-bottom: 5px; }
        .content { font-size: 16px; color: #ccc; }
        .highlight { color: #fff; font-weight: bold; }
        .footer { margin-top: 40px; text-align: center; font-size: 12px; color: #666; border-top: 1px solid #444; padding-top: 20px; }
        .btn { display: inline-block; background-color: #e62020; color: #fff; text-decoration: none; padding: 12px 25px; border-radius: 6px; font-weight: bold; text-transform: uppercase; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Gracias por unirte al equipo!</h1>
            <p>Tu apoyo nos acerca más a la meta.</p>
        </div>
        
        <div class="content">
            <p>Hola <span class="highlight">{{ $data['name'] ?? 'Conejo Fan' }}</span>,</p>
            
            <p>Queremos agradecerte enormemente por tu aportación reciente ({{ $data['plan'] ?? 'Aportación Libre' }}). Gracias a personas como tú, el sueño de llegar a la Fórmula 1 está cada día más cerca.</p>
            
            @if(isset($data['claim_url']) && $data['claim_url'])
            <p>Tu pago fue registrado exitosamente. Para activar tu membresía y acceder al contenido exclusivo, completa la creación de tu cuenta haciendo clic en el siguiente botón:</p>
            <div style="text-align: center;">
                <a href="{{ $data['claim_url'] }}" class="btn">Crear mi Cuenta y Activar Membresía</a>
            </div>
            @elseif(isset($data['is_subscription']) && $data['is_subscription'])
            <p>Tu membresía ha sido activada exitosamente. Ya puedes acceder a todo el contenido exclusivo directamente desde tu Panel Privado.</p>
            <div style="text-align: center;">
                <a href="{{ url('/dashboard') }}" class="btn">Ir a mi Panel</a>
            </div>
            @endif
            
            <p style="margin-top: 30px;">¡Vamos con todo!</p>
            <p><strong>Cristian "Conejo" Cantú</strong></p>
        </div>
        
        <div class="footer">
            <p>Este correo fue generado automáticamente. Si tienes alguna duda, escríbenos a contacto@conejocantu.com</p>
        </div>
    </div>
</body>
</html>
