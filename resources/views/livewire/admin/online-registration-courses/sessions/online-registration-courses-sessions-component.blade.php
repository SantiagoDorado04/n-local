<div>
    @include('livewire.admin.online-registration-courses.sessions.modals-sessions.show')
    @include('livewire.admin.online-registration-courses.sessions.modals-sessions.create')
    @include('livewire.admin.online-registration-courses.sessions.modals-sessions.edit')
    @include('livewire.admin.online-registration-courses.sessions.modals-sessions.delete')
    @include('livewire.admin.online-registration-courses.sessions.modals-sessions.import')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('online-registrations') }}">Controles de registros</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-categories', ['id' => $onlineRegistrationCourse->onlineRegistrationCategory->onlineregistration->id]) }}">Categorias</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-courses', ['id' => $onlineRegistrationCourse->onlineRegistrationCategory->id]) }}">Cursos</a>
            </li>
            <li>
                Sesiones del curso
            </li>
        </ol>
    @endsection

    @section('page_title', 'Sesiones de curso | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-puzzle-piece"></i>&nbsp; Sesiones del curso
            </h1>
            <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal"
                title="Clic para crear una nueva sesion">
                <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
            </button>

            <button class="btn btn-primary btn-add-new" data-toggle="modal" data-target="#create-modal-2"
                title="Clic para importar una nueva sesion">
                <i class="fa fa-download"></i> <span>Importar</span>
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
                                {{ $onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->name }}<br>
                            </li>
                            <li><strong>Categoria: </strong>
                                {{ $onlineRegistrationCourse->onlineRegistrationCategory->name }}<br></li>
                            <li><strong>Curso: </strong> {{ $onlineRegistrationCourse->name }}<br></li>
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
                                <label><strong>Buscar sesion:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Nombre de la sesion">
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            @foreach ($courseSessions as $session)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($session->name, 26) }}
                                                <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                    <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                        data-toggle="dropdown" title="Acciones"><i
                                                            class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-toggle="modal" data-target="#edit-modal"
                                                                title="Clic para editar sesion"
                                                                wire:click="edit({{ $session->id }})"><i
                                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                        <li><a data-toggle="modal" data-target="#delete-modal"
                                                                title="Clic para eliminar sesion"
                                                                wire:click="delete({{ $session->id }})"><i
                                                                    class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </h5>
                                        </div>
                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                            data-toggle="modal" data-target="#show-modal"
                                            title="Clic para ver mas detalles..."
                                            wire:click="show({{ $session->id }})">
                                            <div class="panel-body" style="height:140px">
                                                <p style="  text-align: justify; text-justify: inter-word;">
                                                    <strong>Descripcion:
                                                    </strong>{{ Str::limit($session->description, 100) }}
                                                    <br>
                                                    <br>
                                                    <small><strong>Fecha de inicio:
                                                        </strong>{{ $session->start_date }}
                                                    </small>
                                                    <br>
                                                    <br>
                                                    <small><strong>Fecha de fin:
                                                        </strong>{{ $session->end_date }}
                                                    </small>
                                                </p>

                                            </div>
                                        </button>
                                        <div class="panel-footer">
                                            <div class="text-right">
                                                <a class="btn btn-success sm-b"
                                                    title="Clic para ir a contenidos de la sesion"
                                                    href="{{ route('online-registration-sessionContent', ['id' => $session->id]) }}"><i
                                                        class="fa fa-file-text"></i>
                                                    Contenidos</a>

                                                <a class="btn btn-primary sm-b"
                                                    title="Clic para ir a la caracterización de la sesion"
                                                    href="{{ route('online-registration-characterizations', ['id' => $session->id]) }}"><i
                                                        class="fa fa-user-plus"></i>
                                                    Caracterizaciones</a>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row no-margin-bottom">
                        <div class="col-lg-6" style="padding-top:22px">
                            <span>{!! $paginationText !!}</span>
                        </div>
                        <div class="col-lg-6 text-right">
                            {{ $courseSessions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
