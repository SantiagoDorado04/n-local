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
            <li><a>Video</a></li>
        </ol>
    @endsection

    @section('page_title', 'Video | ' . setting('admin.title'))
    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-video-camera"></i>&nbsp; Video
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
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Título:</label>
                            <input type="text" class="form-control" wire:model="title"
                                placeholder="Ingrese el título del video">
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción:</label>
                            <textarea class="form-control" rows="10" placeholder="Ingrese la descripción" wire:model="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Instrucciones:</label>
                            <textarea class="form-control" rows="10" placeholder="Ingrese las instrucciones" wire:model="instruction"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="embed" class="form-label">Embebido de video:</label>
                            <textarea class="form-control" id="embebido" rows="4" wire:model="embedCode"
                                placeholder="Ingrese el código de inserción del video"></textarea>
                        </div>
                        @error('embedCode')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded text-center">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Vista Previa Del Video</h5>
                    </div>
                    <div class="card-body d-flex flex-column align-items-center">
                        <div class="embed-responsive embed-responsive-16by9">
                            @if ($embedCode)
                                {!! $embedCode !!}
                            @else
                                <p>No se ha ingresado ningún video</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <a href="{{ route('online-registration-sessionContent', ['id' => $this->onlineRegistrationCourseSession->id]) }}"
                        class="btn btn-danger">
                        <i class="fa fa-arrow-left "></i> Volver
                    </a>
                    <button class="btn btn-success" wire:click="store()">
                        <i class="fa fa-save"></i> Guardar
                    </button>
                </div>
            </div>

            <div class="row justify-content-center mt-4">
                <div class="col-md-12">
                    <div class="card-header bg-secondary text-white text-center">
                        <h3 class="mb-0">Vista previa</h3>
                    </div>

                    <div class="page-content browse container-fluid">
                        <div class="row no-margin-bottom">
                            <div class="col-md-12">
                                <div class="panel panel-bordered" style="margin-bottom:0px">
                                    <div class="panel-body" style="margin-bottom:0px">

                                        <div class="col-md-8">
                                            <div class="panel panel-bordered" style="margin-bottom:0px">
                                                <div class="panel-body " style="margin-bottom:0px">
                                                    <h2 class="mb-3 ">{{ $title ?? '' }}</h2>
                                                    <br>
                                                    <p class="fs-5">{{ $description ?? '' }}</p>
                                                    <br>
                                                    <p class="fs-5"><strong>Instrucciones:</strong>
                                                        {{ $instruction ?? 'Sin instrucciones' }}</p>
                                                    <br>

                                                    <div class="text-center my-4">
                                                        <div class="ratio ratio-16x9">
                                                            @if ($embedCode)
                                                                {!! $embedCode !!}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="text-center">
                                                        <a href="#" class="btn btn-warning">
                                                            <i class="fa fa-arrow-left"></i> Anterior
                                                        </a>
                                                        <a href="#" class="btn btn-success">
                                                            Siguiente
                                                            <i class="fa fa-arrow-right"></i>
                                                        </a>
                                                        <br>
                                                        <a href="{{ route('online-registration-sessionContent', ['id' => $this->session_id]) }}"
                                                            class="btn btn-primary">
                                                            <i class="fa fa-close"></i> Cerrar
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="panel panel-bordered" style="margin-bottom:0px">
                                                <div class="panel-body" style="margin-bottom:0px">
                                                    <div class="panel-heading panel-heading-custom" id="heading0"
                                                        style="padding: 4px; background-color: #343a40; color: white;">
                                                        <p style="padding: 5px; margin-bottom: 0px; color: white;">
                                                            <strong>Navegación en Internet</strong>
                                                        </p>
                                                    </div>

                                                    <div class="card-body">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item"><a href="#"
                                                                    class="text-decoration-none">Inicio</a></li>
                                                            <li class="list-group-item"><a href="#"
                                                                    class="text-decoration-none">Cursos</a></li>
                                                            <li class="list-group-item"><a href="#"
                                                                    class="text-decoration-none">Sesiones</a></li>
                                                            <li class="list-group-item"><a href="#"
                                                                    class="text-decoration-none">Contenidos</a>
                                                            </li>
                                                            <li class="list-group-item"><a href="#"
                                                                    class="text-decoration-none">Soporte</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>


</div>
