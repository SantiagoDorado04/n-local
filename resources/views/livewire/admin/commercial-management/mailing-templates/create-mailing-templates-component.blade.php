<div>
    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard')}}"><i class="voyager-boat"></i> {{ __('voyager::generic.dashboard')
                }}</a>
        </li>
        <li>
            <a href="{{ route('mailing.templates') }}">Plantillas de correo</a>
        </li>
        @if ($templateId!='')
        <li>Actualizar plantilla</li>
        @else
        <li>Crear plantilla</li>
        @endif
    </ol>
    @endsection

    @section('page_title', 'Terrenos Comerciales | '.setting('admin.title'))

    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-mail"></i>&nbsp;
            @if ($templateId!='')
            Actualizar plantilla de correo electrónico
            @else
            Crear plantilla de correo electrónico
            @endif
        </h1>
    </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label><strong>Título:</strong></label>
                                    <input type="text" class="form-control" wire:model="title">
                                    @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><strong>Cuerpo de la plantilla:</strong></label>
                                    <div>
                                        <div wire:ignore>
                                            <textarea name="content" id="content" class="form-control"
                                                wire:model="content"></textarea>
                                        </div>
                                    </div>
                                    @error('content')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><strong>Previsualización:</strong></label>
                                    <div class="panel panel-bordered">
                                        <div class="panel-body">
                                            {!! $content !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <button class="btn btn-primary pull-right" wire:click='save'>Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('javascript')
<script>
    const editor = CKEDITOR.replace('content',{
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form',
            extraPlugins : 'uicolor',
            height: '800px',
        });
    editor.on('change', function (event) {
        @this.set('content', event.editor.getData());
    })
</script>
@endpush