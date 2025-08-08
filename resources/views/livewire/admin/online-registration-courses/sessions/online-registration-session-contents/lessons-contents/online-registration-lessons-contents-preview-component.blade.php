<div>

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li><a href="{{ route('online-registrations') }}">Controles de registro</a></li>
            <li><a
                    href="{{ route('online-registration-categories', ['id' => $sessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->id]) }}">Categorias</a>
            </li>
            <li><a
                    href="{{ route('online-registration-courses', ['id' => $sessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->id]) }}">Cursos</a>
            </li>
            <li><a
                    href="{{ route('online-registration-courses-sessions', ['id' => $sessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->id]) }}">Sesiones</a>
            </li>
            <li><a
                    href="{{ route('online-registration-sessionContent', ['id' => $sessionContent->onlineRegistrationCourseSession->id]) }}">Contenidos</a>
            </li>
            <li><a>Lección</a></li>
        </ol>
    @endsection

    @section('page_title', 'Lección | ' . setting('admin.title'))
    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-book"></i>&nbsp; Previsualización De La Lección
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
                                {{ $sessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->name }}<br>
                            </li>
                            <li><strong>Categoria: </strong>
                                {{ $sessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->name }}<br>
                            </li>
                            <li><strong>Curso: </strong>
                                {{ $sessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->name }}<br>
                            </li>
                            <li><strong>Sesión: </strong>
                                {{ $sessionContent->onlineRegistrationCourseSession->name }}<br></li>
                            <li><strong>Lección: </strong> {{ $sessionContent->title }}<br></li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($lessonContent->isNotEmpty() )
        <div class="page-content browse container-fluid">
            <div class="row no-margin-bottom">
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <div class="row no-margin-bottom">
                                <br><br>
                                <div class="page-content browse container-fluid">
                                    <div class="row no-margin-bottom">
                                        <div class="col-md-12">
                                            <div class="panel panel-bordered text-center">
                                                <h2 class="fw-bold mb-3 ms-2 fs-5">
                                                    {{ $this->sessionContent->title ?? '' }}
                                                </h2>
                                                <p class="text-muted ms-2">
                                                    {{ $this->sessionContent->description ?? '' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="page-content browse container-fluid">
                                        <div class="row no-margin-bottom">
                                            <!-- Imagen a la izquierda -->
                                            @if ($align_image === 'left')
                                                <div class="col-md-4">
                                                    <div class="panel panel-bordered">
                                                        <div class="panel-body text-center">

                                                            <!-- Menú de contenidos dentro de la tarjeta -->
                                                            <div class="panel-group" id="accordion">
                                                                <div class="panel panel-primary">
                                                                    <a data-toggle="collapse" data-parent="#accordion"
                                                                        href="#collapse1" style="text-decoration:none">
                                                                        <div class="panel-heading panel-heading-custom"
                                                                            id="heading1" style="padding: 4px">
                                                                            <p style="padding: 5px; margin-bottom:0px">
                                                                                <strong>Menu de contenidos</strong>
                                                                            </p>
                                                                        </div>
                                                                    </a>
                                                                    <div id="collapse1"
                                                                        class="panel-collapse collapse in">
                                                                        <div class="panel-body">
                                                                            <ul class="list-group">
                                                                                <li class="list-group-item"><a
                                                                                        href="#"
                                                                                        wire:click="">Slide
                                                                                        1</a></li>
                                                                                <li class="list-group-item"><a
                                                                                        href="#"
                                                                                        wire:click="">Video</a></li>
                                                                                <li class="list-group-item"><a
                                                                                        href="#"
                                                                                        wire:click="">Lección</a></li>
                                                                                <li class="list-group-item"><a
                                                                                        href="#"
                                                                                        wire:click="">Test</a></li>
                                                                                <li class="list-group-item"><a
                                                                                        href="#"
                                                                                        wire:click="">Despedida</a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            @if ($image)
                                                                <img src="{{ $image->temporaryUrl() }}"
                                                                    alt="Vista previa" class="img-fluid"
                                                                    style="max-width: 100%; max-height: 400px; margin-bottom: 20px;">
                                                            @elseif($existingFile)
                                                                <img src="{{ $existingFile }}" alt="Vista previa"
                                                                    class="img-fluid"
                                                                    style="max-width: 100%; max-height: 400px; margin-bottom: 20px;">
                                                            @else
                                                                <p class="text-muted">No hay imagen seleccionada</p>
                                                            @endif
                                                            @error('image')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror

                                                        </div>

                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Contenido principal -->
                                            <div class="col-md-8">
                                                <div class="panel panel-bordered" style="margin: 0px; height: 730px;">
                                                    <div class="panel-body">
                                                        <div class="row no-margin-bottom">
                                                            <div class="col-lg-12">
                                                                <h2 class="col-md-12 ms-6 mb-3">{{ $title ?? '' }}
                                                                </h2>
                                                                <br>
                                                                <div class="col-md-12 ms-6 mb-3">
                                                                    {!! $content !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Botones de navegación -->
                                                <div class="col-md-12 text-center mt-3">
                                                    <a href="{{ route('online-registration-sessionContent', ['id' => $this->sessionContent->session_id]) }}"
                                                        class="btn btn-danger">
                                                        <i class="fa fa-arrow-left "></i> Volver a cotenidos del curso
                                                    </a>
                                                    <button class="btn btn-warning" wire:click="prevStep"
                                                        @if ($currentStepIndex == 0) disabled @endif>
                                                        <i class="fa fa-arrow-left"></i>
                                                        Anterior
                                                    </button>

                                                    <button class="btn btn-success" wire:click="nextStep"
                                                        @if ($currentStepIndex >= count($lessonContent) - 1) disabled @endif>
                                                        Siguiente
                                                        <i class="fa fa-arrow-right"></i>
                                                    </button>

                                                </div>
                                            </div>

                                            <!-- Imagen a la derecha -->
                                            @if ($align_image === 'right')
                                                <div class="col-md-4">
                                                    <div class="panel panel-bordered">
                                                        <div class="panel-body text-center">

                                                            <!-- Menú de contenidos dentro de la tarjeta -->
                                                            <div class="panel-group" id="accordion">
                                                                <div class="panel panel-primary">
                                                                    <a data-toggle="collapse" data-parent="#accordion"
                                                                        href="#collapse1"
                                                                        style="text-decoration:none">
                                                                        <div class="panel-heading panel-heading-custom"
                                                                            id="heading1" style="padding: 4px">
                                                                            <p style="padding: 5px; margin-bottom:0px">
                                                                                <strong>Menu de contenidos</strong>
                                                                            </p>
                                                                        </div>
                                                                    </a>
                                                                    <div id="collapse1"
                                                                        class="panel-collapse collapse in">
                                                                        <div class="panel-body">
                                                                            <ul class="list-group">
                                                                                <li class="list-group-item"><a
                                                                                        href="#"
                                                                                        wire:click="">Slide 1</a></li>
                                                                                <li class="list-group-item"><a
                                                                                        href="#"
                                                                                        wire:click="">Video</a></li>
                                                                                <li class="list-group-item"><a
                                                                                        href="#"
                                                                                        wire:click="">Lección</a></li>
                                                                                <li class="list-group-item"><a
                                                                                        href="#"
                                                                                        wire:click="">Test</a></li>
                                                                                <li class="list-group-item"><a
                                                                                        href="#"
                                                                                        wire:click="">Despedida</a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Imagen dentro de la tarjeta -->
                                                            @if ($image)
                                                                <img src="{{ $image->temporaryUrl() }}"
                                                                    alt="Vista previa" class="img-fluid"
                                                                    style="max-width: 100%; max-height: 400px; margin-bottom: 20px;">
                                                            @elseif($existingFile)
                                                                <img src="{{ $existingFile }}" alt="Vista previa"
                                                                    class="img-fluid"
                                                                    style="max-width: 100%; max-height: 400px; margin-bottom: 20px;">
                                                            @else
                                                                <p class="text-muted">No hay imagen seleccionada</p>
                                                            @endif
                                                            @error('image')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror

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
                </div>
            </div>
        </div>
    @else
        <br>
        <h2 class="text-muted text-center">No hay contenidos en esta lección disponibles</h2>
    @endif
</div>
