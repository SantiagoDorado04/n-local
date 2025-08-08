<div>

    <style>
        .ck-editor__editable {
            min-height: 500px;
        }
    </style>
    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li><a href="{{ route('contacts.viability') }}">Viabilidad</a></li>
        <li>Innovación</li>
    </ol>
    @endsection

    @section('page_title', 'Innovación | '.setting('admin.title'))

    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="fa fa-lightbulb-o"></i>Innovación - {{ $project->title }}
        </h1>
    </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-8">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="is-required"><strong>Título:</strong></label>
                                    <input type="text" class="form-control" wire:model="title">
                                    @error('title')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="is-required"><strong>Descripción:</strong></label>
                                    <textarea class="form-control" rows="8" wire:model="description"></textarea>
                                    @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="is-required"><strong>Caracteristicas técnicas: </strong></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" wire:model="tc"
                                            placeholder="Ingrese una caracteristica">
                                        <a class="input-group-addon"
                                            style="color:#fff;background-color:#2ECC71;border:0px" wire:click='addTc'>
                                            <i class="fa fa-plus-square">&nbsp;</i>
                                        </a>
                                    </div>
                                    @error('tc')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    @error('tcs')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="panel panel-bordered">
                                    <div class="panel-body" style="margin:5px; padding:5px">
                                        <ul style="padding-left:20px">
                                            @if (count($tcs) > 0)
                                            @foreach ($tcs as $index => $item)
                                            <li>
                                                {{ $item }} &nbsp;
                                                <a href="javascript:void(0);" wire:click.prevent='removeTc({{ $index }})'>
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </li>
                                            @endforeach
                                            @else
                                            <small>*No se han agregado categorias técnias</small>
                                            @endif
                                        </ul>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="is-required"><strong>Caracteristicas comerciales: </strong></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Ingrese una caracteristica"
                                            wire:model="cc">
                                        <a class="input-group-addon"
                                            style="color:#fff;background-color:#2ECC71;border:0px" wire:click='addCc'>
                                            <i class="fa fa-plus-square">&nbsp;</i>
                                        </a>
                                    </div>
                                    @error('cc')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    @error('ccs')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="panel panel-bordered">
                                    <div class="panel-body" style="margin:5px; padding:5px">
                                        <ul style="padding-left:20px">
                                            @if (count($ccs) > 0)
                                            @foreach ($ccs as $index => $item)
                                            <li>
                                                {{ $item }} &nbsp;
                                                <a href="javascript:void(0);" wire:click.prevent='removeCc({{ $index }})'>
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </li>
                                            @endforeach
                                            @else
                                            <small>*No se han agregado categorias comerciales</small>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="is-required"><strong>Tecnología: </strong></label>
                                    <select class="form-control" wire:model="technology">
                                        <option value="">Seleccionar</option>
                                        @foreach ($technologies as $technology)
                                        <option value="{{ $technology->id }}">{{ $technology->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('technology')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="is-required"><strong>Benchmarking: </strong></label>
                                    <div wire:ignore>
                                        <textarea id="content" name="content" style="  height: 300px;" wire:model="benchmarking">{!! $benchmarking !!}</textarea>
                                        
                                    </div>
                                    @error('benchmarking')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <button class="btn btn-success" wire:click="update()"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('javascript')
    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                @this.set('benchmarking', editor.getData());
                })
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    @endpush
</div>