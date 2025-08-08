<div>
    @include('livewire.admin.support.modals.show')
    @include('livewire.admin.support.modals.create')
    @include('livewire.admin.support.modals.edit')
    @include('livewire.admin.support.modals.delete')
    
    @include('livewire.admin.support.modals.edit-2')
    @include('livewire.admin.support.modals.show-2')

    @include('livewire.admin.support.modals.edit-3')

    @section('page_title', 'Soportes | '.setting('admin.title'))

    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard')}}"><i class="voyager-boat"></i> {{ __('voyager::generic.dashboard')
                }}</a>
        </li>
        <li>Soportes</li>
    </ol>
    @endsection

    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title"> 
            <i class="voyager-lifebuoy"></i>&nbsp;Soportes
        </h1>
        <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal">
            <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
        </button>
    </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <label><strong>Buscar Soportes:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName" placeholder="Soportes">
                                <hr>
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-responsive">
                                        <thead>
                                            <tr>
                                                <th class="thwidth text-center"><small>Acciones</small></th>
                                                <th class="thwidth"><small>Estado</small></th>
                                                <th class="thwidth"><small>Asunto Soporte</small></th>
                                                <th class="thwidth"><small>Slug</small></th>
                                                <th class="thwidth"><small>Contenido Soporte</small></th>
                                                <th class="thwidth"><small>Categoría</small></th>
                                                <th class="thwidth"><small>Adjunto Soporte</small></th>
                                                <th class="thwidth"><small>Nivel</small></th>
                                                <th class="thwidth"><small>Usuario soporte</small></th>
                                                <th class="thwidth"><small>Fecha de registro</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($supports as $item)
                                            <tr>
                                                @if ($item->support_user_id == Auth::user()->id|| Auth::user()->id)
                                                <td class="thwidth">
                                                    <button class="btn btn-primary sm-b"
                                                        onclick="mostrarHijos({{ $item->id }})">
                                                        <i class="fa fa-chevron-down"></i>
                                                    </button>

                                                    <button class="btn btn-primary sm-b" title="Detalles Soporte"
                                                    data-toggle="modal" data-target="#show-modal"
                                                    wire:click="show({{ $item->id }})">
                                                        <i class="voyager-eye"></i>
                                                    </button>
                                                    
                                                    <button type="button" class="btn btn-warning sm-b" title="Editar"
                                                        data-toggle="modal" data-target="#edit-modal"
                                                        wire:click="edit({{ $item->id }})">
                                                        <i class="fa fa-pencil-square"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-success sm-b" title="Responder"
                                                        data-toggle="modal" data-target="#edit-modal-2"
                                                        wire:click="reply({{ $item->id }})">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </td>
                                                @endif
                                                <td>{{ $item->state_support ?? '' }}</td>
                                                <td>{{ $item->subject ?? '' }}</td>
                                                <td>{{ $item->slug ?? '' }}</td>
                                                <td>{!! Str::limit($item->body, 30) !!}</td>
                                                <td>{{ $item->category->title ?? '' }}</td>
                                                <td class="thwidth">
                                                    @if ($item->support_attached!='')
                                                        <a href="{{ url('storage/'.substr($item->support_attached,7)) }}" class="btn btn-success sm-b" download style="text-decoration:none">
                                                            <i class="fa fa-cloud-download"></i>&nbsp;Descargar
                                                        </a>
                                                    @else
                                                    <i>Sin archivos</i>
                                                    @endif                                                        
                                                </td>
                                                <td>
                                                    @switch($item->level_support)
                                                        @case('alto')
                                                            Alto
                                                            @break
                                                        @case('alto')
                                                            Médio
                                                            @break
                                                        @case('bajo')
                                                            Bajo
                                                        @break
                                                        @default
                                                            
                                                    @endswitch
                                                </td>
                                                <td class="thwidth">{{ $item->supportUser->name }}</td>
                                                <td class="thwidth">{{ $item->date_support }}</td>
                                            </tr>
                                            <tr wire:ignore.self class="hijos-{{ $item->id }}" style="display: none;">
                                                <td colspan="10">
                                                    <table class="table table-hover table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th class="thwidth"><small>Acciones</small></th>
                                                                <th class="thwidth"><small>Descripción</small></th>
                                                                <th class="thwidth"><small>Adjunto</small></th>
                                                                <th class="thwidth"><small>Fecha de respuesta</small></th>
                                                                <th class="thwidth"><small>Quién respondió</small></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($item->responses as $item2)
                                                                <tr>
                                                                    <td>
                                                                        <button class="btn btn-primary sm-b" title="Ver Respuesta"
                                                                        data-toggle="modal" data-target="#show-modal-2"
                                                                        wire:click="showResponse({{ $item2->id }})">
                                                                            <i class="voyager-eye"></i>
                                                                        </button>

                                                                        <button class="btn btn-warning sm-b" title="Editar Respuesta"
                                                                            data-toggle="modal" data-target="#edit-modal-3"
                                                                            wire:click="editResponse({{ $item2->id }})">
                                                                                <i class="fa fa-pencil-square"></i>
                                                                        </button>
                                                                    </td>
                                                                    <td>{!! Str::limit($item2->body_response, 30) !!}</td>
                                                                    <td class="thwidth text-center">
                                                                        @if ($item2->response_attached!='')
                                                                        <a href="{{ url('storage/'.substr($item2->response_attached,7)) }}" class="btn btn-success sm-b" download style="text-decoration:none">
                                                                            <i class="fa fa-cloud-download"></i>&nbsp;Descargar
                                                                        </a>
                                                                        @else
                                                                            <i>Sin archivos</i>
                                                                        @endif  
                                                                    </td>
                                                                    <td>{{ $item2->date_response }}</td>
                                                                    <td>{{ $item2->responseUser->name }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            @endforeach
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
    <script>
        function mostrarHijos(idPadre) {
            var hijos = $('.hijos-' + idPadre);
            if (hijos.is(":visible")) {
                hijos.hide();
            } else {
                hijos.show();
            }
        }
    </script>
</div>

@push('javascript')
    <script>

        const editor = CKEDITOR.replace('content', {
            filebrowserUploadUrl: "{{ route('upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form',
            extraPlugins: 'uicolor',
            height: '200px',
        });
        editor.on('change', function(event) {
            @this.set('body', event.editor.getData());
        });

        //------------------------------------------------------------//
        const editor2 = CKEDITOR.replace('content2', {
            filebrowserUploadUrl: "{{ route('upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form',
            extraPlugins: 'uicolor',
            height: '200px',
        });
        editor2.on('change', function(event) {
            @this.set('body', event.editor.getData());
        });

        window.livewire.on('load-cke', () => {
            editor2.setData(@this.body, {
                callback: function() {
                    this.checkDirty();
                }
            });
        });

        //------------------------------------------------------------//
        const editor3 = CKEDITOR.replace('content3', {
            filebrowserUploadUrl: "{{ route('upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form',
            extraPlugins: 'uicolor',
            height: '200px',
        });
        editor3.on('change', function(event) {
            @this.set('body', event.editor.getData());
        });

        window.livewire.on('load-cke', () => {
            editor3.setData(@this.body, {
                callback: function() {
                    this.checkDirty();
                }
            });
        });

        //------------------------------------------------------------//
        const editor4 = CKEDITOR.replace('content4', {
            filebrowserUploadUrl: "{{ route('upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form',
            extraPlugins: 'uicolor',
            height: '200px',
        });
        editor4.on('change', function(event) {
            @this.set('body_response', event.editor.getData());
        });

        window.livewire.on('load-cke', () => {
            editor4.setData(@this.body_response, {
                callback: function() {
                    this.checkDirty();
                }
            });
        });
    </script>
@endpush