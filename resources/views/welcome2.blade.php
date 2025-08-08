<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Nido de Saberes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $admin_favicon = Voyager::setting('admin.icon_image', ''); ?>
    @if ($admin_favicon == '')
        <link rel="shortcut icon" href="{{ voyager_asset('images/logo-icon.png') }}" type="image/png">
    @else
        <link rel="shortcut icon" href="{{ Voyager::image($admin_favicon) }}" type="image/png">
    @endif
    <style>
        body {
            background-color: #FBF3FF;
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            border-radius: 10px;
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        .card-body {
            text-align: center;
        }

        .btn-login {
            background-color: #F5B029;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px;
            border-radius: 5px;
            width: 160px;
        }

        .btn-register {
            background-color: #28a745;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px;
            border-radius: 5px;
            width: 160px;
        }

        a:hover {
            color: rgb(255, 255, 255);
        }

        .btn-login,
        .btn-register {
            color: rgb(255, 255, 255);
            text-decoration: none;
            font-weight: bold;
        }

        .btn-login:hover,
        .btn-register:hover {
            color: #dddddd;
        }
    </style>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    {!! setting('site.front_css_header') !!}

    {!! setting('site.front_javascript_header') !!}
</head>

<body>

    <div class="container-fluid">

        {!! setting('site.front_header') !!}

        {!! setting('site.front_hero') !!}


        <div class="row d-flex align-items-center" style="height: 100vh;">
            <div class="col-sm-12 col-md-6 mx-auto">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                <img src="{{ setting('admin.icon_image') }}" width="15%"
                    style="margin-bottom: 5px; border-radius:10px; display: block; margin: 0 auto;">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="color:#616161">{{ setting('admin.title') }}<h5>
                                <h6 class="card-text" style="color:#8b8b8b">¡Bienvenido! Por favor, seleccione una
                                    opción:</h6>
                                <a type="button" href="{{ route('voyager.login') }}" class="btn-login"
                                    style="text-decoration: none; font-weight:bold;">Ingresar</a>
                                <a type="button" href="{{ route('signup') }}"
                                    style="text-decoration: none; font-weight:bold;"
                                    class="btn-register">Registrarme</a>
                    </div>
                </div>
            </div>
        </div>
        {!! setting('site.front_footer') !!}
    </div>
    {!! setting('site.front_javascript_post_html') !!}
</body>

</html>
