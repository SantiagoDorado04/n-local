<div>

    @include('livewire.admin.faqs.modals.create')
    @include('livewire.admin.faqs.modals.edit')
    @include('livewire.admin.faqs.modals.edit-2')
    @include('livewire.admin.faqs.modals.delete')
    @include('livewire.admin.faqs.modals.show')

    @section('page_title', 'FAQs | ' . setting('admin.title'))

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>FAQ's</li>
        </ol>
    @endsection


    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-logbook"></i>&nbsp;FAQ's
            </h1>
            @if (Auth::user()->role_id == '1')
                <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal">
                    <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
                </button>
            @endif
        </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-4">
                                <label><strong>Buscar FAQ's:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName" placeholder="FAQ's">
                            </div>
                            <div class="col-lg-4">
                                <label><strong>Categoría:</strong></label>
                                <select class="form-control" wire:model="searchCategory">
                                    <option value="">Seleccionar</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if (Auth::user()->role_id == '1')
                                <div class="col-lg-4">
                                    <label><strong>Estado:</strong></label>
                                    <select class="form-control" wire:model="searchState">
                                        <option value="">Seleccionar</option>
                                        <option value="pregunta">Pregunta</option>
                                        <option value="respuesta">Respuesta</option>
                                    </select>
                                </div>
                            @endif
                        </div>
                        @if (Auth::user()->role_id == 7)
                            <div class="row no-margin-bottom">
                                @foreach ($faqs as $faq)
                                    <div class="col-md-12">
                                        <div class="panel panel-info">
                                            <div class="panel-heading panel-heading-custom">
                                                <h5 class="panel-title-custom">
                                                    {{ $faq->title }}
                                                    <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                        <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                            data-toggle="dropdown"><i
                                                                class="fa fa-ellipsis-v"></i></button>
                                                        <ul class="dropdown-menu">
                                                            @if ($faq->state == 'pregunta')
                                                                @if ($faq->question_user_id == Auth::user()->id && Auth::user()->role_id == '1')
                                                                    <li>
                                                                        <a data-toggle="modal" data-target="#edit-modal"
                                                                            wire:click="edit({{ $faq->id }})">
                                                                            <i
                                                                                class="fa fa-pencil"></i>&nbsp;&nbsp;Editar
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a data-toggle="modal"
                                                                            data-target="#delete-modal"
                                                                            wire:click="delete({{ $faq->id }})">
                                                                            <i
                                                                                class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </h5>
                                            </div>
                                            <div class="panel-body" style="padding:20px">
                                                <div class="row no-margin-bottom">
                                                    <div class="col-lg-12">
                                                        <h5>Descripción Pregunta:</h5>
                                                        {!! $faq->description_question !!}
                                                        <hr>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <h5>Descripción Respuesta:</h5>
                                                        {!! $faq->description_response ? $faq->description_response : 'No hay respuesta' !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="row no-margin-bottom">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-responsive">
                                            <thead>
                                                <tr>
                                                    <th class="thwidth text-center"><small>Acciones</small></th>
                                                    <th class="thwidth"><small>Estado</small></th>
                                                    <th class="thwidth"><small>Título</small></th>
                                                    <th class="thwidth"><small>Slug</small></th>
                                                    <th class="thwidth"><small>Descripción Pregunta</small></th>
                                                    <th class="thwidth"><small>Categoría</small></th>
                                                    <th class="thwidth"><small>Adjunto</small></th>
                                                    <th class="thwidth"><small>Fecha de Registro</small></th>
                                                    <th class="thwidth"><small>Quien preguntó</small></th>
                                                    <th class="thwidth"><small>Descripción Respuesta</small></th>
                                                    <th class="thwidth"><small>Adjunto Respuesta</small></th>
                                                    <th class="thwidth"><small>Quien respondió</small></th>
                                                    <th class="thwidth"><small>Fecha de Respuesta</small></th>
                                                    <th class="thwidth"><small>Visbilidad</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($faqs as $faq)
                                                    <tr>
                                                        <td wisth="10%" class="thwidth">
                                                            <button type="button" class="btn btn-primary sm-b"
                                                                title="Ver" data-toggle="modal"
                                                                data-target="#show-modal"
                                                                wire:click="show({{ $faq->id }})">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                            <a class="btn btn-success sm-b" style="text-decoration:none"
                                                                href="{{ route('faqs-content', ['id' => $faq->id]) }}">
                                                                <i class="fa fa-pencil"></i>&nbsp;&nbsp;Contenido
                                                            </a>
                                                            @if ($faq->state == 'pregunta')
                                                                @if ($faq->question_user_id == Auth::user()->id || Auth::user()->role_id == '1')
                                                                    <button type="button" class="btn btn-warning sm-b"
                                                                        title="Editar" data-toggle="modal"
                                                                        data-target="#edit-modal"
                                                                        wire:click="edit({{ $faq->id }})">
                                                                        <i class="fa fa-pencil-square"></i>
                                                                    </button>

                                                                    <button type="button" class="btn btn-danger sm-b"
                                                                        title="Eliminar" data-toggle="modal"
                                                                        data-target="#delete-modal"
                                                                        wire:click="delete({{ $faq->id }})"><i
                                                                            class="fa fa-trash"></i>
                                                                    </button>
                                                                @endif
                                                            @endif
                                                            @if (Auth::user()->role_id == '1')
                                                                <a class="btn btn-success sm-b" title="Responder"
                                                                    style="text-decoration:none"
                                                                    href="{{ route('faqs-content', ['id' => $faq->id]) }}">
                                                                    <i class="fa fa-check"></i> Responder
                                                                </a>
                                                            @endif

                                                        </td>
                                                        <td width="5%">
                                                            @if (isset($faq->state))
                                                                @if ($faq->state == 'pregunta')
                                                                    <span
                                                                        class="badge badge-primary">{{ ucfirst($faq->state) }}</span>
                                                                @elseif($faq->state == 'respuesta')
                                                                    <span
                                                                        class="badge badge-success">{{ ucfirst($faq->state) }}</span>
                                                                @else
                                                                    {{ ucfirst($faq->state) }}
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td width="10%" class="thwidth">{{ $faq->title }}</td>
                                                        <td width="10%" class="thwidth">{{ $faq->slug }}</td>
                                                        <td width="10%" class="thwidth">
                                                            {{ Str::limit($faq->description_question, 30) }}</td>
                                                        <td width="10%" class="thwidth">
                                                            {{ $faq->category->title ?? '' }}</td>
                                                        <td width="5%">
                                                            @if ($faq->attached_question != '')
                                                                <a href="{{ url('storage/' . substr($faq->attached_question, 7)) }}"
                                                                    class="btn btn-success sm-b" download
                                                                    style="text-decoration:none">
                                                                    <i class="fa fa-cloud-download"></i>&nbsp;Descargar
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td width="5%" class="thwidth">{{ $faq->date_question }}
                                                        </td>
                                                        <td width="5%" class="thwidth">
                                                            {{ $faq->questionUser->name }}</td>
                                                        <td width="10%" class="thwidth">
                                                            {{ Str::limit($faq->description_response, 30) }}</td>
                                                        <td width="5%">
                                                            @if ($faq->attached_response != '')
                                                                <a href="{{ url('storage/' . substr($faq->attached_response, 7)) }}"
                                                                    class="btn btn-success sm-b" download
                                                                    style="text-decoration:none">
                                                                    <i class="fa fa-cloud-download"></i>&nbsp;Descargar
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td width="5%" class="thwidth">
                                                            {{ $faq->responseUser->name ?? '' }}</td>
                                                        <td width="5%" class="thwidth">
                                                            {{ $faq->date_response ?? '' }}</td>
                                                        <td width="5%">
                                                            {{ $faq->public == '1' ? 'Publica' : 'Oculta' }}</td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            @this.set('description_question', event.editor.getData());
        });

        //------------------------------------------------------------//
        const editor2 = CKEDITOR.replace('content2', {
            filebrowserUploadUrl: "{{ route('upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form',
            extraPlugins: 'uicolor',
            height: '200px',
        });
        editor2.on('change', function(event) {
            @this.set('description_question', event.editor.getData());
        });

        window.livewire.on('load-cke', () => {
            editor2.setData(@this.description_question, {
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
            @this.set('description_question', event.editor.getData());
        });

        window.livewire.on('load-cke', () => {
            editor3.setData(@this.description_question, {
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
            @this.set('description_response', event.editor.getData());
        });

        window.livewire.on('load-cke', () => {
            editor4.setData(@this.description_response, {
                callback: function() {
                    this.checkDirty();
                }
            });
        });
    </script>
@endpush
