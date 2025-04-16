<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de tu Reservación</title>
    <style>
        /* Estilos base */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        /* Encabezado */
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eaeaea;
        }

        .header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }

        /* Contenido principal */
        .content {
            margin-bottom: 30px;
        }

        p {
            color: #4a5568;
            margin-bottom: 16px;
            font-size: 16px;
        }

        /* Detalles del pedido */
        .reserva-details {
            margin: 25px 0;
            padding: 25px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background-color: #f8fafc;
        }

        .reserva-details h2 {
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px dashed #edf2f7;
        }

        .detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .label {
            font-weight: 600;
            color: #4a5568;
            flex: 1;
        }

        .value {
            color: #2d3748;
            flex: 1;
            text-align: right;
        }

        /* Botón y acciones */
        .button {
            display: inline-block;
            background-color: #3182ce;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #2c5282;
        }

        .actions {
            text-align: center;
            margin-top: 30px;
        }

        /* Pie de página */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eaeaea;
            text-align: center;
            color: #718096;
            font-size: 14px;
        }

        .company-name {
            font-weight: 600;
            color: #4a5568;
        }

        /* Estilos responsivos */
        @media screen and (max-width: 600px) {
            .container {
                padding: 25px;
                margin: 10px;
                width: auto;
            }

            .detail-item {
                flex-direction: column;
            }

            .value {
                text-align: left;
                margin-top: 5px;
            }
        }

        /* Destacado para el precio total */
        .highlight {
            font-weight: 700;
            color: #2c5282;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Tu Reservación ha sido Confirmada!</h1>
        </div>

        <div class="content">
            <p>Hola {{ $user->name }},</p>
            <p>Gracias por tu reservación. Hemos recibido tu solicitud y estamos procesándola. A continuación encontrarás los detalles de tu reserva:</p>

            <div class="reserva-details">
                <h2>Detalles de la reserva</h2>
                <div class="detail-item">
                    <span class="label">Número de la reserva:</span>
                    <span class="value">#{{ $reservation->id }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Fecha de Inicio:</span>
                    <span class="value">{{ $reservation->start_date }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Fecha de Fin:</span>
                    <span class="value">{{ $reservation->end_date }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Precio Total:</span>
                    <span class="value highlight">${{ $reservation->total_price }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Estado del Pago:</span>
                    <span class="value">{{ $reservation->payment_status }}</span>
                </div>
                @isset($reservation->media)
                <div class="detail-item">
                    <span class="label">ID del Medio:</span>
                    <span class="value">{{ $reservation->media_id }} ({{ $media->name ?? 'Información no disponible' }})</span>
                </div>
                @else
                <div class="detail-item">
                    <span class="label">ID del Medio:</span>
                    <span class="value">{{ $reservation->media_id }}</span>
                </div>
                @endisset
            </div>

            <p>Puedes revisar los detalles completos de tu reserva en tu cuenta o contactarnos si tienes alguna pregunta sobre tu reserva.</p>

        </div>

        <div class="footer">
            <p>Gracias nuevamente por tu confianza.</p>
            <!-- <p>Saludos,<br>El equipo de <span class="company-name">[Nombre de tu E-commerce]</span></p> -->
        </div>
    </div>
</body>
</html>
