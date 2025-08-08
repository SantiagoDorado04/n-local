<div>
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li><a href="{{ route('online-registrations') }}">Controles de registro</a></li>
            <li><a
                    href="{{ route('online-registration-categories', ['id' => $onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->id]) }}">Categorias</a>
            </li>
            <li><a
                    href="{{ route('online-registration-courses', ['id' => $onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->id]) }}">Cursos</a>
            </li>
            <li><a
                    href="{{ route('online-registration-courses-sessions', ['id' => $onlineRegistrationCourseSession->onlineRegistrationCourse->id]) }}">Sesiones</a>
            </li>
            <li><a
                    href="{{ route('online-registration-sessionContent', ['id' => $onlineRegistrationCourseSession->id]) }}">Contenidos</a>
            </li>
            <li><a>Lección</a></li>
        </ol>
    @endsection

    @section('page_title', 'Lección | ' . setting('admin.title'))
    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-book"></i>&nbsp; Lección
            </h1>
        </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin-bottom:0px">
                    <div class="panel-body" style="margin-bottom:0px">
                        <ul>
                            <li><strong>Control de registro: </strong>
                                {{ $onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->name }}<br>
                            </li>
                            <li><strong>Categoria: </strong>
                                {{ $onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->name }}<br>
                            </li>
                            <li><strong>Curso: </strong>
                                {{ $onlineRegistrationCourseSession->onlineRegistrationCourse->name }}<br></li>
                            <li><strong>Sesión: </strong> {{ $onlineRegistrationCourseSession->name }}<br></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Título:</label>
                            <input type="text" class="form-control" wire:model="title"
                                placeholder="Ingrese el título de la lección">
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción:</label>
                            <textarea class="form-control" rows="10" placeholder="Ingrese la descripción" wire:model="description"></textarea>
                        </div>
                        <div class="d-flex justify-content-center text-center">
                            <a href="{{ route('online-registration-sessionContent', ['id' => $this->onlineRegistrationCourseSession->id]) }}"
                                class="btn btn-danger">
                                <i class="fa fa-arrow-left "></i> Volver
                            </a>
                            <button class="btn btn-success" wire:click="store()">
                                <i class="fa fa-save"></i> Guardar
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
