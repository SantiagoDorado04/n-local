<div>
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>Entrevistas</li>
        </ol>
    @endsection

    @section('page_title', 'Entrevistas | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-rocket"></i>&nbsp;Entrevistas
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
                        <div class="row no-margin-bottom" style="margin-bottom:12px">
                            <div class="col-lg-12">
                                <label><strong>Buscar entrevista:</strong></label>
                                <input type="text" class="form-control" wire:model.debounce.100ms="searchName"
                                    placeholder="Entrevista">
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            @forelse ($interviews as $interview)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($interview['topic'], 26) }}
                                            </h5>
                                        </div>
                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px">
                                            <div class="panel-body" style="height:60px">
                                                <p style="text-align: justify; text-justify: inter-word;">
                                                    {{ $interview['topic'] }}
                                                </p>
                                            </div>
                                        </button>
                                        <div class="panel-footer ">
                                            <div class="text-center">
                                                <a class="btn btn-success sm-b"
                                                    href="{{ route('interviews.questions', ['guid' => $interview['guid']]) }}" title="Preguntas">
                                                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                                                </a>
                                                <a class="btn btn-primary sm-b"
                                                    href="{{ route('interviews.answers', ['guid' => $interview['guid']]) }}" title="Respuestas">
                                                    <i class="fa fa-weixin" aria-hidden="true"></i>
                                                </a>
                                                <button class="btn btn-danger sm-b" data-toggle="modal" data-target="#delete-modal" wire:click="selectInterviewToDelete('{{ $interview['guid'] }}')" title="Eliminar">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                                <button class="btn btn-warning sm-b" onclick="copyToClipboard('{{ $interview['url'] }}')" title="Copiar URL">
                                                    <i class="fa fa-clipboard" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                            <div class="clearfix">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-lg-12">
                                    <p>No se encontraron entrevistas.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal modal-danger fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="delete-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}" wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title">
                        <i class="fa fa-trash"></i>&nbsp;¿Estás seguro de que deseas eliminar esta entrevista? Esta acción no se puede deshacer.
                    </h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger pull-right" wire:click="confirmDelete()">{{ __('voyager::generic.delete_confirm') }}</button>
                    <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function copyToClipboard(url) {
            var tempInput = document.createElement("input");
            tempInput.style.position = "absolute";
            tempInput.style.left = "-1000px";
            tempInput.style.top = "-1000px";
            tempInput.value = url;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            alert("URL copiada al portapapeles: " + url);
        }
    </script>    
</div>
