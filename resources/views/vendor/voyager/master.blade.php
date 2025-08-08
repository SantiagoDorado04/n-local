<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="{{ __('voyager::generic.is_rtl') == 'true' ? 'rtl' : 'ltr' }}">
<head>
    <title>@yield('page_title', setting('admin.title') . " - " . setting('admin.description'))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="assets-path" content="{{ route('voyager.voyager_assets') }}"/>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">

    <!-- Favicon -->
    <?php $admin_favicon = Voyager::setting('admin.icon_image', ''); ?>
    @if($admin_favicon == '')
        <link rel="shortcut icon" href="{{ voyager_asset('images/logo-icon.png') }}" type="image/png">
    @else
        <link rel="shortcut icon" href="{{ Voyager::image($admin_favicon) }}" type="image/png">
    @endif

    <script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js?skin=sunburst"></script>


    <!-- App CSS -->
    <link rel="stylesheet" href="{{ voyager_asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="https://unpkg.com/jsmind@0.5/style/jsmind.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jsmind@0.5.4/js/jsmind.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jsmind@0.5.4/js/jsmind.draggable-node.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jsmind@0.5.4/js/jsmind.screenshot.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    @yield('css')
    @if(__('voyager::generic.is_rtl') == 'true')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.css">
        <link rel="stylesheet" href="{{ voyager_asset('css/rtl.css') }}">
    @endif

    <style>
        .sm-b {
            padding: 5px 10px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }
    </style>

    <style>
        /* PANELS*/
        .panel-heading-custom {
            padding: 5px;
            padding-top: 15px;
            background-color: #19b5fe !important;
        }
        .panel-heading-custom-success {
            padding: 5px;
            padding-top: 15px;
            background-color: #28a745 !important;
        }
        .panel-heading-default-custom {
            padding: 5px;
            padding-top: 15px;
        }

        .panel-title-default-custom {
            padding-left: 5px;
            color: rgb(139, 139, 139)
        }

        .panel-title-custom {
            padding-left: 5px;
            color: #fff
        }

        .panel-navbar-custom {
            margin-top: -15px;
            margin-right: 0px;
        }

        .is-required:after {
            content: '*';
            margin-left: 3px;
            color: #e64151;

        }

        /* SELECT2*/
        .select2-selection__rendered {
            line-height: 31px !important;
        }

        .select2-container .select2-selection--single {
            height: 35px !important;
        }

            .select2-selection__arrow {
                height: 34px !important;
            }

        /*SWITCH*/
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        /* Table */
        td.fitwidth {
            width: 1px;
            white-space: nowrap;
        }

        .thwidth {
            width: 1px;
            white-space: nowrap;
        }

        .fc-view-container {
            overflow-x: scroll;
        }
    </style>

    <style>
        span.email-ids {
            float: left;
            /* padding: 4px; */
            border: 1px solid #ccc;
            margin-right: 5px;
            padding-left: 10px;
            padding-right: 10px;
            margin-bottom: 5px;
            background: #f5f5f5;
            padding-top: 3px;
            padding-bottom: 3px;
            border-radius: 5px;
        }

        span.cancel-email {
            border: 1px solid #ccc;
            width: 18px;
            display: block;
            float: right;
            text-align: center;
            margin-left: 20px;
            border-radius: 49%;
            height: 18px;
            line-height: 15px;
            margin-top: 1px;
            cursor: pointer;
        }

        .col-sm-12.email-id-row {
            border: 1px solid #ccc;
        }

        .col-sm-12.email-id-row input {
            border: 0px;
            outline: 0px;
        }

        span.to-input {
            display: block;
            float: left;
            padding-right: 11px;
        }

        .col-sm-12.email-id-row {
            padding-top: 6px;
            padding-bottom: 7px;
            margin-top: 23px;
        }
        .ignore-css{all:unset;}

    </style>


    <!-- Few Dynamic Styles -->
    <style type="text/css">
        .voyager .side-menu .navbar-header {
            background:{{ config('voyager.primary_color','#22A7F0') }};
            border-color:{{ config('voyager.primary_color','#22A7F0') }};
        }
        .widget .btn-primary{
            border-color:{{ config('voyager.primary_color','#22A7F0') }};
        }
        .widget .btn-primary:focus, .widget .btn-primary:hover, .widget .btn-primary:active, .widget .btn-primary.active, .widget .btn-primary:active:focus{
            background:{{ config('voyager.primary_color','#22A7F0') }};
        }
        .voyager .breadcrumb a{
            color:{{ config('voyager.primary_color','#22A7F0') }};
        }
    </style>

    @if(!empty(config('voyager.additional_css')))<!-- Additional CSS -->
        @foreach(config('voyager.additional_css') as $css)<link rel="stylesheet" type="text/css" href="{{ asset($css) }}">@endforeach
    @endif

    @yield('head')

    @livewireStyles

</head>

<body class="voyager @if(isset($dataType) && isset($dataType->slug)){{ $dataType->slug }}@endif">

<div id="voyager-loader">
    <?php $admin_loader_img = Voyager::setting('admin.loader', ''); ?>
    @if($admin_loader_img == '')
        <img src="{{ voyager_asset('images/logo-icon.png') }}" alt="Voyager Loader">
    @else
        <img src="{{ Voyager::image($admin_loader_img) }}" alt="Voyager Loader">
    @endif
</div>

<?php
if (\Illuminate\Support\Str::startsWith(Auth::user()->avatar, 'http://') || \Illuminate\Support\Str::startsWith(Auth::user()->avatar, 'https://')) {
    $user_avatar = Auth::user()->avatar;
} else {
    $user_avatar = Voyager::image(Auth::user()->avatar);
}
?>

<div class="app-container">
    <div class="fadetoblack visible-xs"></div>
    <div class="row content-container">
        @include('voyager::dashboard.navbar')
        @include('voyager::dashboard.sidebar')
        <script>
            (function(){
                    var appContainer = document.querySelector('.app-container'),
                        sidebar = appContainer.querySelector('.side-menu'),
                        navbar = appContainer.querySelector('nav.navbar.navbar-top'),
                        loader = document.getElementById('voyager-loader'),
                        hamburgerMenu = document.querySelector('.hamburger'),
                        sidebarTransition = sidebar.style.transition,
                        navbarTransition = navbar.style.transition,
                        containerTransition = appContainer.style.transition;

                    sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition =
                    appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition =
                    navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = 'none';

                    if (window.innerWidth > 768 && window.localStorage && window.localStorage['voyager.stickySidebar'] == 'true') {
                        appContainer.className += ' expanded no-animation';
                        loader.style.left = (sidebar.clientWidth/2)+'px';
                        hamburgerMenu.className += ' is-active no-animation';
                    }

                   navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = navbarTransition;
                   sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition = sidebarTransition;
                   appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition = containerTransition;
            })();
        </script>
        <!-- Main Content -->
        <div class="container-fluid">
            <div class="side-body padding-top">
                @yield('page_header')
                <div id="voyager-notifications"></div>
                @yield('content')
            </div>
        </div>
    </div>
</div>
@include('voyager::partials.app-footer')

<!-- Javascript Libs -->

<script type="text/javascript" src="{{ voyager_asset('js/app.js') }}"></script>
@livewireScripts
<script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.3.3/js/dataTables.fixedColumns.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>

<script>
    @if(Session::has('mensaje'))
        toastr.{{ Session::get('tipo_mensaje', 'info') }}('{{ Session::get('mensaje') }}')
    @endif
</script>

<script>
    @if(Session::has('alerts'))
        let alerts = {!! json_encode(Session::get('alerts')) !!};
        helpers.displayAlerts(alerts, toastr);
    @endif

    @if(Session::has('message'))

    // TODO: change Controllers to use AlertsMessages trait... then remove this
    var alertType = {!! json_encode(Session::get('alert-type', 'info')) !!};
    var alertMessage = {!! json_encode(Session::get('message')) !!};
    var alerter = toastr[alertType];

    if (alerter) {
        alerter(alertMessage);
    } else {
        toastr.error("toastr alert-type " + alertType + " is unknown");
    }
    @endif
</script>
@include('voyager::media.manager')
@yield('javascript')
@stack('javascript')
@if(!empty(config('voyager.additional_js')))<!-- Additional Javascript -->
    @foreach(config('voyager.additional_js') as $js)<script type="text/javascript" src="{{ asset($js) }}"></script>@endforeach
@endif

<script type="text/javascript">

    function copy() {
        var copyText = document.getElementById("linkField").value;

        navigator.clipboard.writeText(copyText).then(function() {
            toastr.success('Enlace copiado!');
        }, function() {
            toastr.error('Error al copiar el enlace');
        });
    }
    window.livewire.on('alert', param => {
        toastr[param['type']](param['message']);
    });

    window.livewire.on('close-modal', () => {
        $('#create-modal').modal('hide');
        $('#edit-modal').modal('hide');
        $('#delete-modal').modal('hide');
        $('#info-modal').modal('hide');
        $('#show-modal').modal('hide');

        $('#create-modal-2').modal('hide');
        $('#edit-modal-2').modal('hide');
        $('#delete-modal-2').modal('hide');
        $('#info-modal-2').modal('hide');
        $('#show-modal-2').modal('hide');

        $('#edit-modal-3').modal('hide');
        $('#info-modal-3').modal('hide');

        $('#info-modal-4').modal('hide');

        $('#info-modal-5').modal('hide');

        $('#info-modal-6').modal('hide');

     
    });

    window.livewire.on('close-modal-2nd', () => {
       
        $('#2nd-create-modal').modal('hide');
        $('#2nd-edit-modal').modal('hide');
        $('#2nd-delete-modal').modal('hide');
        $('#2nd-info-1-modal').modal('hide');
        $('#2nd-info-2-modal').modal('hide');
    });

    window.livewire.on('open-edit-modal', () => {
        setTimeout(function(){
            $('#edit-modal').modal('show');
        }, 500);
    });
</script>

</body>
</html>



