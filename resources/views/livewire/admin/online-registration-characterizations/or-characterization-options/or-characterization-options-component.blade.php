<div>
    @include('livewire.admin.online-registration-characterizations.or-characterization-options.modals-options.show')
    @include('livewire.admin.online-registration-characterizations.or-characterization-options.modals-options.create')
    @include('livewire.admin.online-registration-characterizations.or-characterization-options.modals-options.edit')
    @include('livewire.admin.online-registration-characterizations.or-characterization-options.modals-options.delete')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('online-registrations') }}">Controles de registro</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-categories', ['id' => $question->characterization->session->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->id]) }}">Categorias</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-courses', ['id' => $question->characterization->session->onlineRegistrationCourse->onlineRegistrationCategory->id]) }}">Cursos</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-courses-sessions', ['id' => $question->characterization->session->onlineRegistrationCourse->id]) }}">Sesiones</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-characterizations', ['id' => $question->characterization->session->id]) }}">Caracterizacion</a>
            </li>
            <li>
                <a
                    href="{{ route('or-characterization-questions', ['id' => $question->characterization->id]) }}">preguntas</a>
            </li>
            <li>
                Opciones
            </li>
        </ol>
    @endsection

    @section('page_title', 'Opciones | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-list-ul" aria-hidden="true"></i>Opciones de respuesta
            </h1>
            <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal" title="Clic para crear una nueva opcion de respuesta">
                <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
            </button>
        </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin-bottom:0px">
                    <div class="panel-body" style="margin-bottom:0px">
                        <ul>
                            <small>
                                <li><strong>Control de registro:</strong>
                                    {{ $question->characterization->session->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->name }}
                                </li>
                                <li><strong>Categoria:</strong>
                                    {{ $question->characterization->session->onlineRegistrationCourse->onlineRegistrationCategory->name }}
                                </li>
                                <li><strong>Curso:</strong>
                                    {{ $question->characterization->session->onlineRegistrationCourse->name }}</li>
                                <li><strong>Sesion:</strong> {{ $question->characterization->session->name }}</li>
                                <li><strong>Caracterizacion:</strong> {{ $question->characterization->name }}
                                </li>
                                <li><strong>Pregunta: </strong> {{ $question->text }}<br></li>
                            </small>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom" style="margin-bottom:12px">
                            <div class="col-lg-12">
                                <h3>Pregunta: <strong>{{ $question->text }}</strong></h3>
                            </div>
                        </div>

                        <!-- Leyenda de colores -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="legend-container" style="display: flex; align-items: center; gap: 15px;">
                                    <div style="display: flex; align-items: center;">
                                        <span
                                            style="width: 20px; height: 20px; background-color: #5cb85c; display: inline-block; border-radius: 3px;"></span>
                                        <span style="margin-left: 8px;">Condicional</span>
                                    </div>
                                    <div style="display: flex; align-items: center;">
                                        <span
                                            style="width: 20px; height: 20px; background-color: #2688df; display: inline-block; border-radius: 3px;"></span>
                                        <span style="margin-left: 8px;">No Condicional</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom" style="margin-bottom:12px">
                            <div class="col-lg-12">
                                <label><strong>Buscar opciones:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Opciones">
                            </div>
                        </div>
                        <div class="row no-margin-bottom" id="sortable-list" title="Opciones de la respuesta">
                            @foreach ($options as $option)
                                <div class="col-lg-12 col-md-12 col-sm-12" data-id="{{ $option->id }}">
                                    <div class="panel panel-primary">
                                        <div
                                            class="panel-heading panel-heading-custom{{ $option->conditional == 1 ? '-success' : '' }}">
                                            <h5 class="panel-title-custom">
                                                {{ $loop->iteration . '. ' . Str::limit($option->text, 26) }}
                                                <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                    <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                        data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-toggle="modal" data-target="#edit-modal" title="Clic para editar"
                                                                wire:click="edit({{ $option->id }})"><i
                                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                        <li><a data-toggle="modal" data-target="#delete-modal" title="Clic para eliminar"
                                                                wire:click="delete({{ $option->id }})"><i
                                                                    class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </h5>
                                        </div>
                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                            data-toggle="modal" data-target="#show-modal"
                                            wire:click="show({{ $option->id }})">
                                            <div class="panel-body" style="height:120px">
                                                <p
                                                    style="  text-align: justify;
                                        text-justify: inter-word;">
                                                    <strong>Valor: </strong>{{ $option->value }}
                                                </p>
                                                <p
                                                    style="  text-align: justify;
                                        text-justify: inter-word;">
                                                    <strong>Posicion: </strong>{{ $option->position }}
                                                </p>
                                                <p
                                                    style="  text-align: justify;
                                        text-justify: inter-word;">
                                                    <strong>Condicional:
                                                    </strong>{{ $option->conditional == 1 ? 'Si' : 'No' }}
                                                </p>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-lg-6" style="padding-top:22px">
                                <span>{!! $paginationText !!}</span>
                            </div>
                            <div class="col-lg-6 text-right">
                                {{ $options->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    document.addEventListener('livewire:load', function() {
        var el = document.getElementById('sortable-list');
        var sortable = Sortable.create(el, {
            onEnd: function(evt) {
                var orderedIds = Array.from(el.children).map(child => child.dataset.id);
                @this.call('updateOptionOrder', orderedIds);
            }
        });
    });
</script>
