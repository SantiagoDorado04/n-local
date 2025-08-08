<div>
    @include('livewire.admin.online-registration-courses.modals.show')
    @include('livewire.admin.online-registration-courses.modals.create')
    @include('livewire.admin.online-registration-courses.modals.edit')
    @include('livewire.admin.online-registration-courses.modals.info')
    @include('livewire.admin.online-registration-courses.modals.preview')
    @include('livewire.admin.online-registration-courses.modals.delete')
    @include('livewire.admin.online-registration-courses.modals.group')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('online-registrations') }}">Control de registros</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-categories', ['id' => $onlineRegistrationCategory->online_registration_id]) }}">Categorías
                    de cursos</a>
            </li>
            <li>
                Cursos con formulario de control de registro
            </li>
        </ol>
    @endsection

    @section('page_title', 'Cursos con control de registro | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-building-o"></i>&nbsp; Cursos con formulario de control de registro
            </h1>
            <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal"
                title="Clic para crear un nuevo curso">
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
                            <li><strong>Control de registro: </strong>
                                {{ $onlineRegistrationCategory->onlineRegistration->name }}<br></li>
                            <li><strong>Categoria: </strong> {{ $onlineRegistrationCategory->name }}<br></li>
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
                                <label><strong>Buscar curso:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Nombre del curso">
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            @foreach ($onlineRegistrationCourses as $course)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($course->name, 26) }}
                                                <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                    <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                        data-toggle="dropdown" title="Acciones"><i
                                                            class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-toggle="modal" data-target="#edit-modal"
                                                                title="Clic para editar el curso"
                                                                wire:click="edit({{ $course->id }})"><i
                                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                        <li><a data-toggle="modal" data-target="#delete-modal"
                                                                title="Clic para eliminar el curso"
                                                                wire:click="delete({{ $course->id }})"><i
                                                                    class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </h5>
                                        </div>
                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                            data-toggle="modal" data-target="#show-modal"
                                            title="Clic para ver mas detalles..."
                                            wire:click="show({{ $course->id }})">
                                            <div class="panel-body" style="height:140px">
                                                <p style="  text-align: justify; text-justify: inter-word;">
                                                    {{ Str::limit($course->description, 150) }}
                                                    <br>
                                                    <br>
                                                    <small><strong>Activo:
                                                        </strong>{{ $course->active == 1 ? 'Si' : 'No' }}
                                                    </small>
                                                </p>

                                            </div>
                                        </button>

                                        <div class="panel-footer">
                                            <!-- Contenedor para los dropdowns en línea -->
                                            <div class="d-flex flex-wrap gap-2 mb-3">
                                                <!-- Dropdown para Formulario -->
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle sm-b" type="button"
                                                        data-toggle="dropdown">
                                                        <i class="fa fa-list me-1"></i> Formulario <span
                                                            class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                title="Enlace formulario de inscripción"
                                                                data-toggle="modal" data-target="#info-modal-2"
                                                                wire:click='getSlug({{ $course->id }})'>
                                                                <i class="fa fa-link me-1"></i> Link
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" title="Preguntas del formulario"
                                                                href="{{ route('online-registration-form-questions', ['id' => $course->form->id]) }}">
                                                                <i class="fa fa-clipboard me-1"></i> Preguntas
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                title="Visualización del formulario" data-toggle="modal"
                                                                data-target="#info-modal"
                                                                wire:click='preview({{ $course->id }})'>
                                                                <i class="fa fa-eye me-1"></i> Visualizar
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <!-- Dropdown para Usuarios -->
                                                <div class="dropdown">
                                                    <button class="btn btn-warning dropdown-toggle sm-b" type="button"
                                                        data-toggle="dropdown">
                                                        <i class="fa fa-users me-1"></i> Usuarios <span
                                                            class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" title="Ver usuarios registrados"
                                                                href="{{ route('online-registration-contacts-courses', ['id' => $course->id]) }}">
                                                                <i class="fa fa-users me-1"></i> Registrados
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" title="Ver asistencias"
                                                                href="{{ route('online-registration-courses-attendees', ['id' => $course->id]) }}">
                                                                <i class="fa fa-check-square me-1"></i> Asistencias
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" title="Certificados"
                                                                href="{{ route('online-registration-contacts-certificate', ['id' => $course->id]) }}">
                                                                <i class="fa fa-certificate me-1"></i> Certificados
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <!-- Botones principales -->
                                            <div
                                                class="d-flex flex-wrap gap-2 justify-content-between align-items-center mt-3">
                                                @if (!$course->waGroup)
                                                    <a title="Crear grupo" class="btn btn-success sm-b"
                                                        data-toggle="modal" data-target="#create-modal-2"
                                                        wire:click="preparateGroup({{ $course->id }})">
                                                        <i class="fa fa-plus-circle me-1"></i> Crear grupo
                                                    </a>
                                                @else
                                                    <a title="Actualizar grupo de WhatsApp"
                                                        class="btn btn-warning sm-b"
                                                        wire:click="openUpdateGroupModal({{ $course->id }})">
                                                        <i class="fa fa-refresh me-1"></i> Actualizar grupo
                                                    </a>
                                                @endif

                                                <a href="{{ route('online-registration-courses-comunication', ['id' => $course->id]) }}"
                                                    title="Ver comunicaciones" class="btn btn-primary sm-b">
                                                    <i class="fa fa-comments me-1"></i> Comunicaciones
                                                </a>

                                                <a title="Ver sesiones del curso" class="btn btn-danger sm-b"
                                                    href="{{ route('online-registration-courses-sessions', ['id' => $course->id]) }}">
                                                    <i class="fa fa-calendar-check-o me-1"></i> Sesiones
                                                </a>

                                                <a title="Ver documentos del curso" class="btn btn-dark sm-b"
                                                    href="{{ route('online-registration-documents', ['id' => $course->id]) }}">
                                                    <i class="fa fa-folder-open me-1"></i> Documentos
                                                </a>
                                            </div>

                                            <div class="clearfix"></div>
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
                                {{ $onlineRegistrationCourses->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
