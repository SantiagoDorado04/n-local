<div>
    <style>
        iframe {
            width: 100%;
            border: none;
        }
    </style>

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('processes.contact') }}">Procesos</a>
            </li>
            <li>
                <a href="{{ route('steps.contact', ['id' => $step->stage_id]) }}">Pasos</a>
            </li>
            <li>
                Video Entrevista
            </li>
        </ol>
    @endsection

    @section('page_title', 'Video Entrevista | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title"><i class="fa fa-cloud-upload"></i>&nbsp;Video Entrevista</h1>
        </div>
    @endsection

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom text-center">
                            <div class="col-lg-12">
                                @if (!$stageActive)
                                    <h4>La etapa en la que estas se encuentra inactiva o ya no esta disponible, esta
                                        entrevista no puede realizarse.</h4>
                                @else
                                    <h4>Para iniciar la entrevista, haga click en el siguiente botón:</h4>
                                    <br>
                                    <button class="btn btn-success btn-new" onclick="openPopup('{{ $url }}')">
                                        <i class="voyager-video"></i>
                                        &nbsp;Abrir Entrevista
                                    </button>
                                @endif
                                {{-- <iframe id="contentIframe" src="{{ $url }}" style="width: 100%;"
                                    sandbox="allow-forms allow-scripts allow-same-origin">
                                </iframe> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openPopup(url) {
            var screenWidth = window.screen.width;
            var screenHeight = window.screen.height;

            var popupWidth = screenWidth * 0.6;
            var popupHeight = screenHeight * 0.6;

            var left = (screenWidth - popupWidth) / 2;
            var top = (screenHeight - popupHeight) / 2;

            window.open(
                url,
                "popupWindow",
                "width=" + popupWidth + ",height=" + popupHeight + ",left=" + left + ",top=" + top + ",scrollbars=yes"
            );
        }


        function adjustIframeHeight() {
            var iframe = document.getElementById('contentIframe');
            iframe.style.height = window.innerHeight + 'px';
        }

        window.onload = adjustIframeHeight;
        window.onresize = adjustIframeHeight;
    </script>
</div>
