<div>
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>Etiquetas blancas</li>
        </ol>
    @endsection

    @section('page_title', 'Etiquetas blancas | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-rocket"></i>&nbsp;Etiquetas blancas
            </h1>
            <a class="btn btn-success btn-add-new" href="{{ route('interviews.create') }}">
                <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
            </a>
        </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th><small>Label</small></th>
                                                <th><small>Dominio Playhunt</small></th>
                                                <th><small>Dominio personalizado</small></th>
                                                <th><small>Color</small></th>
                                                <th><small>Logo</small></th>
                                                <th><small>Lenguage</small></th>
                                                <th><small>Título</small></th>
                                                <th><small>Predeterminada</small></th>
                                                <th><small>Acciones</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($witheLabels as $witheLabel)
                                                <tr>
                                                    <td>{{ $witheLabel['label'] ?? '-' }}</td>
                                                    <td>{{ $witheLabel['domain_playhunt'] ?? '-' }}</td>
                                                    <td>{{ $witheLabel['domain_custom'] ?? '-' }}</td>
                                                    <td>{{ $witheLabel['color'] ?? '-' }}</td>
                                                    <td><img src="{{ $witheLabel['logo_path'] }}" alt="Logo" style="max-width: 100px; max-height: 100px;"></td>
                                                    <td>{{ $witheLabel['page_lang'] ?? '-' }}</td>
                                                    <td>{{ $witheLabel['text_title'] ?? '-' }}</td>
                                                    <td>{{ $witheLabel['is_default'] ?? '-' == '1' ? 'Si' : 'No' }}</td>
                                                    <td>
                                                        <button class="btn btn-success sm-b" onclick="showDetails(
                                                            '{{ $witheLabel['label'] }}', 
                                                            '{{ $witheLabel['domain_playhunt'] }}', 
                                                            '{{ $witheLabel['domain_custom'] }}', 
                                                            '{{ $witheLabel['color'] }}', 
                                                            '{{ $witheLabel['logo_path'] }}', 
                                                            '{{ $witheLabel['page_lang'] }}', 
                                                            '{{ $witheLabel['text_title'] }}', 
                                                            '{{ $witheLabel['text_body'] }}', 
                                                            '{{ $witheLabel['is_default'] }}'
                                                        )">
                                                            <i class="fa fa-window-maximize" aria-hidden="true"></i>&nbsp;Visualizar
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10">No hay datos disponibles.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-info fade" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"  data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title">
                        <i class="fa fa-link"></i>&nbsp;Detalles de la Etiqueta Blanca
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <div class="row no-margin-bottom">
                                <div class="col-lg-12 text-center">
                                    <img id="detail-logo" src="" alt="Logo" style="max-width: 100px; max-height: 100px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <div class="row no-margin-bottom">
                                <div class="col-lg-6" id="color-background" style="background-color: #fff; height: 100px;">
                                    <!-- Color background column -->
                                </div>
                                <div class="col-lg-6">
                                    <span id="detail-text-body"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <div class="row no-margin-bottom">
                                <div class="col-lg-12">
                                    <p><strong>Label:</strong> <span id="detail-label"></span></p>
                                    <p><strong>Dominio Playhunt:</strong> <span id="detail-domain-playhunt"></span></p>
                                    <p><strong>Dominio Personalizado:</strong> <span id="detail-domain-custom"></span></p>
                                    <p><strong>Color:</strong> <span id="detail-color"></span></p>
                                    <p><strong>Lenguaje:</strong> <span id="detail-page-lang"></span></p>
                                    <p><strong>Título:</strong> <span id="detail-text-title"></span></p>
                                    <p><strong>Cuerpo:</strong> <span id="detail-text-body"></span></p>
                                    <p><strong>Predeterminada:</strong> <span id="detail-is-default"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;{{ __('voyager::generic.close') }}</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function showDetails(label, domainPlayhunt, domainCustom, color, logoPath, pageLang, textTitle, textBody, isDefault) {
            document.getElementById('detail-label').innerText = label;
            document.getElementById('detail-domain-playhunt').innerText = domainPlayhunt;
            document.getElementById('detail-domain-custom').innerText = domainCustom;
            document.getElementById('detail-color').innerText = color;
            document.getElementById('color-background').style.backgroundColor = color;
            document.getElementById('detail-logo').src = logoPath;
            document.getElementById('detail-page-lang').innerText = pageLang;
            document.getElementById('detail-text-title').innerText = textTitle;
            document.getElementById('detail-text-body').innerHTML = textBody;
            document.getElementById('detail-is-default').innerText = isDefault;
            
            $('#details-modal').modal('show');
        }
    </script>
</div>
