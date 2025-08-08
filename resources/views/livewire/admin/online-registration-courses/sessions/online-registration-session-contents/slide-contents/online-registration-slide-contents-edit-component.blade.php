<div>
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
                <a href="{{ route('online-registration-sessionContent', ['id' => $session->id]) }}">Contenidos</a>
            </li>

            <li>
                <a>Slide</a>
            </li>
        </ol>
    @endsection

    @section('page_title', 'Slide | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-play-circle"></i>&nbsp; Crear slide
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
                                {{ $session->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->name }}<br>
                            </li>
                            <li><strong>Categoria: </strong>
                                {{ $session->onlineRegistrationCourse->onlineRegistrationCategory->name }}<br></li>
                            <li><strong>Curso: </strong> {{ $session->onlineRegistrationCourse->name }}<br></li>
                            <li><strong>Sesión: </strong> {{ $session->name }}<br></li>
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
                                placeholder="Ingrese el título del slide">
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción:</label>
                            <textarea class="form-control" rows="20" placeholder="Ingrese la descripción" wire:model="description"></textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-secondary text-white text-center">
                        <h5 class="mb-0">Vista previa del Banner</h5>
                    </div>
                    <div class="card-body text-center">

                        @if ($file)
                            <img src="{{ $file->temporaryUrl() }}" alt="Vista previa" class="img-fluid"
                                style="max-width: 400px; max-height: 400px; margin-bottom: 20px;">
                        @elseif($existingFile)
                            <img src="{{ $existingFile }}" alt="Vista previa" class="img-fluid"
                                style="max-width: 400px; max-height: 400px; margin-bottom: 20px;">
                        @else
                            <p class="text-muted">No hay imagen seleccionada</p>
                        @endif

                        <br>
                        @if ($existingFile)
                            <button class="btn btn-danger mt-2" wire:click="removeFile">
                                <i class="fa fa-trash"></i> Eliminar imagen
                            </button>
                        @endif

                        <div class="mt-3">
                            <label for="fileInput" class="form-label"><strong>Cargar nueva imagen:</strong></label>
                            <input type="file" class="form-control" wire:model="file" accept=".jpg,.jpeg,.png">
                            @error('file')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="text-center">
                    <a href="{{ route('online-registration-sessionContent', ['id' => $this->session->id]) }}"
                        class="btn btn-danger">
                        <i class="fa fa-arrow-left "></i> Volver
                    </a>
                    <button class="btn btn-success" wire:click="update()"><i class="fa fa-save"></i>
                        Guardar</button>
                </div>
            </div>

            {{-- <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h4>Preview:</h4>
                        @if ($file)
                            <img src="{{ $file->temporaryUrl() }}" alt="Vista previa" class="img-fluid"
                                style="max-width: 400px; max-height: 400px; margin-bottom: 20px;">
                        @elseif($existingFile)
                            <img src="{{ $existingFile }}" alt="Vista previa" class="img-fluid">
                        @endif
                        <h2 class="text-justify">{{ $title ?? '' }}</h2>
                        <p class="text-justify">{{ $description ?? '' }}</p>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin-bottom:0px">
                    <div class="panel-body" style="margin-bottom:0px">
                        <div class="card-header bg-secondary text-white text-center py-3 rounded">
                            <h3 class="mb-0">Vista previa</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin-bottom:0px">
                    <div class="panel-body" style="margin-bottom:0px">

                        <div class="col-md-8">
                            <div class="panel panel-bordered" style="margin-bottom:0px">
                                <div class="panel-body " style="margin-bottom:0px">
                                    <div class="text-center">
                                        @if ($file)
                                            <img src="{{ $file->temporaryUrl() }}" alt="Vista previa"
                                                class="img-fluid">
                                        @elseif($existingFile)
                                            <img src="{{ $existingFile }}" alt="Vista previa" class="img-fluid">
                                        @endif
                                    </div>
                                    <br>
                                    <h2 class="mb-3 ">{{ $title ?? '' }}</h2>
                                    <br>
                                    <p class="fs-5">{{ $description ?? '' }}</p>
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
                            <div class="panel panel-bordered">
                                <div class="panel-body">
                                    <div class="row no-margin-bottom">
                                        <div class="col-lg-12">

                                            <div class="panel-group" id="accordion">
                                                <div class="panel panel-primary">
                                                    <a data-toggle="collapse" data-parent="#accordion"
                                                        href="#collapse1" style="text-decoration:none">
                                                        <div class="panel-heading panel-heading-custom" id="heading1"
                                                            style="padding: 4px">
                                                            <p style="padding: 5px; margin-bottom:0px">
                                                                <strong>Menu de contenidos</strong>
                                                            </p>
                                                        </div>
                                                    </a>
                                                    <div id="collapse1" class="panel-collapse collapse in">
                                                        <div class="panel-body">
                                                            <ul class="list-group">
                                                                <li class="list-group-item">
                                                                    <a href="#" wire:click="">Slide
                                                                        1</a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" wire:click="">Video</a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" wire:click="">Leccion</a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" wire:click="">Test</a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="#" wire:click="">Despedida</a>
                                                                </li>
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
</div>
