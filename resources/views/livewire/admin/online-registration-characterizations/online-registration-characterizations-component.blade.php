<div>
    @include('livewire.admin.online-registration-characterizations.modals.show')
    @include('livewire.admin.online-registration-characterizations.modals.create-specific')
    @include('livewire.admin.online-registration-characterizations.modals.create-general')
    @include('livewire.admin.online-registration-characterizations.modals.delete')
    @include('livewire.admin.online-registration-characterizations.modals.preview')
    @include('livewire.admin.online-registration-characterizations.modals.edit')

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
                    href="{{ route('online-registration-categories', ['id' => $session->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->id]) }}">Categorias</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-courses', ['id' => $session->onlineRegistrationCourse->onlineRegistrationCategory->id]) }}">Cursos</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-courses-sessions', ['id' => $session->onlineRegistrationCourse->id]) }}">Sesiones</a>
            </li>
            <li>
                Formularios de caracterizacion
            </li>
        </ol>
    @endsection

    @section('page_title', 'Caracterizaciones | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-clipboard"></i> Formulario de caracterizacion
            </h1>
            <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal" title="Clic para crear un nuevo formulario específico">
                <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }} formulario específico</span>
            </button>
            <button class="btn btn-primary btn-info" data-toggle="modal" data-target="#create-modal-2" title="Clic para crear un nuevo formulario general">
                <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }} formulario general</span>
            </button>
        </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin-bottom:0px">
                    <div class="panel-body" style="margin-bottom:0px">
                        <small>
                            <ul>
                                <li><strong>Control de registro:</strong>
                                    {{ $session->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->name }}
                                </li>
                                <li><strong>Categoria:</strong>
                                    {{ $session->onlineRegistrationCourse->onlineRegistrationCategory->name }}</li>
                                <li><strong>Curso:</strong> {{ $session->onlineRegistrationCourse->name }}</li>
                                <li><strong>Sesion:</strong> {{ $session->name }}</li>
                            </ul>
                        </small>
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
                                <label><strong>Buscar formulario:</strong></label>
                                <input type="text" class="form-control mb-2" wire:model="searchName"
                                    placeholder="Nombre del formulario">
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            @foreach ($characterizations as $characterization)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="panel panel-secondary">
                                        <div
                                            class="panel-heading panel-heading-custom{{ $characterization->type == 'S' ? '-success' : '' }}">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($characterization->name, 26) }}
                                                <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                    <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                        data-toggle="dropdown" title="Opciones"><i
                                                            class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-toggle="modal" data-target="#edit-modal" title="Clic para editar"
                                                                wire:click="edit({{ $characterization->id }})"><i
                                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                        <li><a data-toggle="modal" data-target="#delete-modal" title="Clic para eliminar"
                                                                wire:click="delete({{ $characterization->id }})"><i
                                                                    class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </h5>
                                        </div>

                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                            data-toggle="modal" data-target="#show-modal"
                                            wire:click="show({{ $characterization->id }})"
                                            title="Clic para mas detalles...">
                                            <div class="panel-body" style="height:140px">
                                                <p style="text-align: justify; text-justify: inter-word;">
                                                    {{ Str::limit($characterization->description, 150) }}
                                                    <br>
                                                    <br>
                                                    <small><strong>Formulario:
                                                        </strong>{{ $characterization->type == 'S' ? 'Especifico' : 'General' }}
                                                    </small>
                                                </p>
                                            </div>
                                        </button>
                                        <div class="panel-footer">
                                            <div class="pull-right">
                                                <a href="{{ route('or-characterization-answers', ['id' => $characterization->id]) }}"
                                                    class="btn btn-success sm-b" title="Respuestas formulario">
                                                    <i class="fa fa-reply"></i>
                                                    &nbsp;Respuetas
                                                </a>
                                                <a data-toggle="modal" data-target="#info-modal"
                                                    wire:click="preview({{ $characterization->id }})"
                                                    class="btn btn-info sm-b" title="Visualizar formulario">
                                                    <i class="fa fa-eye"></i>
                                                    &nbsp;Visualizar
                                                </a>
                                                {{-- <a href="{{ route('information-forms.answers', ['id' => $characterization->id]) }}"
                                                    class="btn btn-warning sm-b" title="Respuestas formulario">
                                                    <i class="fa fa-check-square-o"></i>
                                                    &nbsp;Respuestas
                                                </a> --}}
                                                <a href="{{ route('or-characterization-questions', ['id' => $characterization->id]) }}"
                                                    class="btn btn-success sm-b" title="Preguntas formulario">
                                                    <i class="fa fa-question"></i>
                                                    &nbsp;Preguntas
                                                </a>
                                            </div>
                                            <div class="clearfix">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-lg-6" style="padding-top:22px">
                                <span>{!! $paginationText !!}</span>
                            </div>
                            <div class="col-lg-6 text-right">
                                {{ $characterizations->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
