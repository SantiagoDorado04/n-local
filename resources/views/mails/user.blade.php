<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Notificación de formulario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F5F5F5;
        }
        h1 {
            color: #9492E6;
            margin-bottom: 10px;
        }
        p {
            color: #555555;
            margin-bottom: 20px;
        }
        ul {
            color: #555555;
            margin-bottom: 20px;
        }
        li {
            margin-bottom: 5px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #FFFFFF;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-width: 200px;
        }
        .cta-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #9492E6;
            color: #FFFFFF;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #777777;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php $img = Voyager::setting('admin.icon_image', ''); ?>
        <div class="logo">
            <img src="{{ Voyager::image($img) }}" alt="Logo" width="60">
        </div>
        <h1>Hola, {{ $name }}</h1>
        <p>Bienvenido a {{ setting('admin.title') }}, su registro se completó correctamente.</p>

        Recuerde que para inicar sesión en la plataforma, debe usar su correo electrónico y su número de NIT o cedula como contraseña.
        <br>
        <p>¡Gracias por tu interés!</p>
        <div class="footer">
            Este mensaje es generado automáticamente. Por favor, no respondas a este correo.
        </div>
    </div>
</body>
</html>
