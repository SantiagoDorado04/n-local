<div>
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a
                    href="{{ route('my-registrations', ['id' => $onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->id]) }}">Cursos</a>
            </li>
            <li>
                <a
                    href="{{ route('my-course-sessions', ['id' => $onlineRegistrationCourseSession->onlineRegistrationCourse->id]) }}">Sesiones</a>
            </li>
            <li>
                <a>Contenidos</a>
            </li>
        </ol>
    @endsection
    @section('page_title', 'Contenidos del curso | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid ">
            <div class="d-flex align-items-center justify-content-between">
                <h1 class="page-title mb-0">
                    <i class="fa fa-building-o"></i>&nbsp; Contenido del  curso
                </h1>
            </div>
        </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin-bottom:0px">
                    <div class="panel-body" style="margin-bottom:0px">
                        <ul>
                            <li><strong>Curso: </strong>
                                {{ $onlineRegistrationCourseSession->onlineRegistrationCourse->name }}<br></li>

                            <li><strong>Sesión: </strong> {{ $onlineRegistrationCourseSession->name }}<br></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if ($type == 'V')
        <div class="page-content browse container-fluid">
            <div class="row no-margin-bottom">
                <div class="col-md-12">
                    <div class="panel panel-bordered" style="margin-bottom:0px">
                        <div class="panel-body" style="margin-bottom:0px">

                            <div class="col-md-8">
                                <div class="panel panel-bordered" style="margin-bottom:0px">
                                    <div class="panel-body " style="margin-bottom:0px">
                                        <h2 class="mb-3 ">{{ $titleV ?? '' }}</h2>
                                        <br>
                                        <p class="fs-5">{{ $descriptionV ?? '' }}</p>
                                        <br>
                                        <p class="fs-5"><strong>Instrucciones:</strong>
                                            {{ $instructionV ?? 'Sin instrucciones' }}</p>
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
                                            <a href="{{ route('my-course-sessions', ['id' => $this->onlineRegistrationCourseSession->or_course_id]) }}"
                                                class="btn btn-danger">
                                                <i class="fa fa-arrow-left "></i> Regresar a la session
                                            </a>
                                            <button wire:click="prevStep" class="btn btn-warning"
                                                {{ $currentStepIndex == 0 ? 'disabled' : '' }}>
                                                <i class="fa fa-arrow-left"></i> Anterior
                                            </button>
                                            <button wire:click="nextStep" class="btn btn-success"
                                                {{ $currentStepIndex == count($this->OnlineRegistrationSessionContent) - 1 ? '' : '' }}>
                                                Siguiente
                                                <i class="fa fa-arrow-right"></i>
                                            </button>
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
                                                            <div class="panel-heading panel-heading-custom"
                                                                id="heading1" style="padding: 4px">
                                                                <p style="padding: 5px; margin-bottom:0px">
                                                                    <strong>Menu de contenidos</strong>
                                                                </p>
                                                            </div>
                                                        </a>
                                                        <div id="collapse1" class="panel-collapse collapse in">
                                                            <div class="panel-body">
                                                                <ul class="list-group list-group-flush">
                                                                    @foreach ($OnlineRegistrationSessionContent as $index => $content)
                                                                        <li class="list-group-item">
                                                                            <a href="#"
                                                                                wire:click.prevent="goToStep({{ $index }})"
                                                                                class="text-decoration-none {{ $currentStepIndex == $index ? 'fw-bold text-primary' : '' }}">
                                                                                {{ $content->title }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
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
    @elseif ($type == 'S')
        <div class="page-content browse container-fluid">
            <div class="row no-margin-bottom">
                <div class="col-md-12">
                    <div class="panel panel-bordered" style="margin-bottom:0px">
                        <div class="panel-body" style="margin-bottom:0px">

                            <div class="col-md-8">
                                <div class="panel panel-bordered" style="margin-bottom:0px">
                                    <div class="panel-body " style="margin-bottom:0px">
                                        <div class="text-center">
                                            @if ($banner_image)
                                                <img src="{{ $banner_image }}" alt="Vista previa" class="img-fluid">
                                            @endif
                                        </div>
                                        <br>
                                        <h2 class="mb-3 ">{{ $titleS ?? '' }}</h2>
                                        <br>
                                        <p class="fs-5">{{ $descriptionS ?? '' }}</p>
                                        <br>
                                        <div class="text-center">
                                            <a href="{{ route('my-course-sessions', ['id' => $onlineRegistrationCourseSession->or_course_id]) }}"
                                                class="btn btn-danger">
                                                <i class="fa fa-arrow-left "></i> Regresar a las sesiones
                                            </a>
                                            <button wire:click="prevStep" class="btn btn-warning"
                                                {{ $currentStepIndex == 0 ? 'disabled' : '' }}>
                                                <i class="fa fa-arrow-left"></i> Anterior
                                            </button>
                                            <button wire:click="nextStep" class="btn btn-success"
                                                {{ $currentStepIndex == count($this->OnlineRegistrationSessionContent) - 1 ? 'disabled' : '' }}>
                                                Siguiente
                                                <i class="fa fa-arrow-right"></i>
                                            </button>
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
                                                            <div class="panel-heading panel-heading-custom"
                                                                id="heading1" style="padding: 4px">
                                                                <p style="padding: 5px; margin-bottom:0px">
                                                                    <strong>Menu de contenidos</strong>
                                                                </p>
                                                            </div>
                                                        </a>
                                                        <div id="collapse1" class="panel-collapse collapse in">
                                                            <div class="panel-body">
                                                                <ul class="list-group list-group-flush">
                                                                    @foreach ($OnlineRegistrationSessionContent as $index => $content)
                                                                        <li class="list-group-item">
                                                                            <a href="#"
                                                                                wire:click.prevent="goToStep({{ $index }})"
                                                                                class="text-decoration-none {{ $currentStepIndex == $index ? 'fw-bold text-primary' : '' }}">
                                                                                {{ $content->title }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
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
    @elseif ($type == 'L')
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
                                @if ($lessonContent->isNotEmpty())

                                    <div class="col-md-12">
                                        <div class="page-content browse container-fluid">
                                            <div class="row no-margin-bottom">
                                                <!-- Imagen a la izquierda -->
                                                @if ($align_image === 'left')
                                                    <div class="col-md-4">
                                                        <div class="panel panel-bordered">
                                                            <div class="panel-body text-center">

                                                                @if ($image)
                                                                    <img src="{{ $image->temporaryUrl() }}"
                                                                        alt="Vista previa" class="img-fluid"
                                                                        style="max-width: 100%; max-height: 400px; margin-bottom: 20px;">
                                                                @elseif($existingFile)
                                                                    <img src="{{ $existingFile }}" alt="Vista previa"
                                                                        class="img-fluid"
                                                                        style="max-width: 100%; max-height: 400px; margin-bottom: 20px;">
                                                                @else
                                                                    <p class="text-muted">No hay imagen seleccionada
                                                                    </p>
                                                                @endif
                                                                @error('image')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror

                                                                <!-- Menú de contenidos dentro de la tarjeta -->
                                                                <div class="panel-group" id="accordion">
                                                                    <div class="panel panel-primary">
                                                                        <a data-toggle="collapse"
                                                                            data-parent="#accordion" href="#collapse1"
                                                                            style="text-decoration:none">
                                                                            <div class="panel-heading panel-heading-custom"
                                                                                id="heading1" style="padding: 4px">
                                                                                <p
                                                                                    style="padding: 5px; margin-bottom:0px">
                                                                                    <strong>Menu de contenidos</strong>
                                                                                </p>
                                                                            </div>
                                                                        </a>
                                                                        <div id="collapse1"
                                                                            class="panel-collapse collapse in">
                                                                            <div class="panel-body">
                                                                                <ul
                                                                                    class="list-group list-group-flush">
                                                                                    @foreach ($OnlineRegistrationSessionContent as $index => $contents)
                                                                                        <li class="list-group-item">
                                                                                            <a href="#"
                                                                                                wire:click.prevent="goToStep({{ $index }})"
                                                                                                class="text-decoration-none {{ $currentStepIndex == $index ? 'fw-bold text-primary' : '' }}">
                                                                                                {{ $contents->title }}
                                                                                            </a>
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <!-- Contenido principal -->
                                                <div class="col-md-8">
                                                    <div class="panel panel-bordered"
                                                        style="margin: 0px; height: 730px;">
                                                        <div class="panel-body">
                                                            <div class="row no-margin-bottom">
                                                                <div class="col-lg-12">
                                                                    <h2 class="col-md-12 ms-6 mb-3">
                                                                        {{ $title ?? '' }}
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
                                                    <div class="text-center mt-3">
                                                        <a href="{{ route('my-course-sessions', ['id' => $this->onlineRegistrationCourseSession->or_course_id]) }}"
                                                            class="btn btn-danger">
                                                            <i class="fa fa-arrow-left "></i> Regresar a las sesiones
                                                        </a>
                                                        <button class="btn btn-warning" wire:click="prevLessonStep"
                                                            @if ($currentStepIndex == 0 && $currentLessonStepIndex == 0) disabled @endif>
                                                            <i class="fa fa-arrow-left"></i>
                                                            Anterior
                                                        </button>

                                                        <button class="btn btn-success" wire:click="nextLessonStep"
                                                            @if (
                                                                $currentStepIndex >= count($OnlineRegistrationSessionContent) - 1 &&
                                                                    $currentLessonStepIndex >= count($lessonContent) - 1)  @endif>
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

                                                                @if ($image)
                                                                    <img src="{{ $image->temporaryUrl() }}"
                                                                        alt="Vista previa" class="img-fluid"
                                                                        style="max-width: 100%; max-height: 400px; margin-bottom: 20px;">
                                                                @elseif($existingFile)
                                                                    <img src="{{ $existingFile }}" alt="Vista previa"
                                                                        class="img-fluid"
                                                                        style="max-width: 100%; max-height: 400px; margin-bottom: 20px;">
                                                                @else
                                                                    <p class="text-muted">No hay imagen seleccionada
                                                                    </p>
                                                                @endif
                                                                @error('image')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                                <br><br>

                                                                <!-- Menú de contenidos dentro de la tarjeta -->
                                                                <div class="panel-group" id="accordion">
                                                                    <div class="panel panel-primary">
                                                                        <a data-toggle="collapse"
                                                                            data-parent="#accordion" href="#collapse1"
                                                                            style="text-decoration:none">
                                                                            <div class="panel-heading panel-heading-custom"
                                                                                id="heading1" style="padding: 4px">
                                                                                <p
                                                                                    style="padding: 5px; margin-bottom:0px">
                                                                                    <strong>Menu de contenidos</strong>
                                                                                </p>
                                                                            </div>
                                                                        </a>
                                                                        <div id="collapse1"
                                                                            class="panel-collapse collapse in">
                                                                            <div class="panel-body">
                                                                                <ul
                                                                                    class="list-group list-group-flush">
                                                                                    @foreach ($OnlineRegistrationSessionContent as $index => $contents)
                                                                                        <li class="list-group-item">
                                                                                            <a href="#"
                                                                                                wire:click.prevent="goToStep({{ $index }})"
                                                                                                class="text-decoration-none {{ $currentStepIndex == $index ? 'fw-bold text-primary' : '' }}">
                                                                                                {{ $contents->title }}
                                                                                            </a>
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <br>
                                    <h2 class="text-muted text-center">No hay contenido en las lecciones disponibles
                                    </h2>
                                    <div class="text-center">
                                        <a href="{{ route('my-course-sessions', ['id' => $onlineRegistrationCourseSession->or_course_id]) }}"
                                            class="btn btn-danger">
                                            <i class="fa fa-arrow-left "></i> Regresar a contenidos
                                        </a>
                                        <button wire:click="prevStep" class="btn btn-warning"
                                            {{ $currentStepIndex == 0 ? 'disabled' : '' }}>
                                            <i class="fa fa-arrow-left"></i> Anterior
                                        </button>
                                        <button wire:click="nextStep" class="btn btn-success"
                                            {{ $currentStepIndex == count($this->OnlineRegistrationSessionContent) - 1 ? '' : '' }}>
                                            Siguiente
                                            <i class="fa fa-arrow-right"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif ($type == 'T')
        <div class="page-content browse container-fluid">
            <div class="row no-margin-bottom">
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <div class="row no-margin-bottom">
                                <br><br>
                                <div class="step" style="display: 'block'; width:100%">
                                    <div class="page-content browse container-fluid">
                                        <div class="row no-margin-bottom">
                                            <div class="col-md-12">
                                                <div class="panel panel-bordered text-center">
                                                    <h2 class="fw-bold mb-3 ms-2 fs-5">
                                                        {{ $test->onlineRegistrationSessionContent->title ?? '' }}
                                                    </h2>
                                                    <p class="text-muted ms-2">
                                                        {{ $test->onlineRegistrationSessionContent->description ?? '' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="page-content browse container-fluid">
                                        <div class="row no-margin-bottom">
                                            <div class="col-md-8">
                                                <div class="panel panel-bordered">
                                                    <div class="panel-body">
                                                        <div class="row no-margin-bottom">
                                                            <div class="step"
                                                                style="display:{{ $count == 1 ? 'block' : 'none' }};">
                                                                <div class="row no-margin-bottom">
                                                                    <div class="row justify-content-center">
                                                                        <div class="col-md-12">

                                                                            <div class="card-body text-center">
                                                                                <h3 class="fw-bold text-primary mb-3">
                                                                                    Instrucciones:</h3>
                                                                                <h4 class="text-muted">
                                                                                    <small>{{ $test->instructions }}</small>
                                                                                </h4>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            @foreach ($items as $index => $item)
                                                                <div class="step"
                                                                    style="display: {{ $count === $index + 2 ? 'block' : 'none' }};">
                                                                    <div class="row no-margin-bottom">
                                                                        <div class="col-md-12">
                                                                            <div class="panel panel-bordered">
                                                                                <div class="panel-body">
                                                                                    <div class="row no-margin-bottom">
                                                                                        <div class="col-md-1">
                                                                                            <strong>{{ $index + 1 . '. ' }}</strong>
                                                                                        </div>
                                                                                        <div class="col-md-11">
                                                                                            <p>{{ $item->text }}</p>
                                                                                            {!! nl2br($item->item) !!}
                                                                                            <div>
                                                                                                @foreach ($item->choices as $choice)
                                                                                                    <input
                                                                                                        type="radio"
                                                                                                        id="choice_{{ $choice->id }}"
                                                                                                        name="item_{{ $item->id }}"
                                                                                                        value="{{ $choice->id }}"
                                                                                                        class="radio-option"
                                                                                                        data-question-id="{{ $item->id }}"
                                                                                                        wire:model.defer="responses.item_{{ $item->id }}">
                                                                                                    <label
                                                                                                        for="choice_{{ $choice->id }}">{{ $choice->text }}</label><br>
                                                                                                @endforeach
                                                                                            </div>
                                                                                            @error("responses.item_{$item->id}")
                                                                                                <small
                                                                                                    class="text-danger">{{ $message }}</small>
                                                                                            @enderror
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                            <div class="step"
                                                                style="display: {{ $count == $cant + 2 ? 'block' : 'none' }};">
                                                                <div class="panel panel-bordered">
                                                                    <div class="panel-body">
                                                                        @if ($cant == 0)
                                                                            <h3
                                                                                class="fw-bold text-primary mb-3 text-center">
                                                                                No se encontraron preguntas</h3>
                                                                            <p class="text-muted text-center">Verifica
                                                                                tus
                                                                                preguntas del formulario.
                                                                            </p>
                                                                        @else
                                                                            <h3
                                                                                class="fw-bold text-primary mb-3 text-center">
                                                                                Revisión Final</h3>
                                                                            <p class="text-muted text-center">
                                                                                Verifica
                                                                                tus
                                                                                respuestas antes de enviar el
                                                                                formulario.
                                                                            </p>

                                                                            <ul class="list-group">
                                                                                @foreach ($items as $index => $item)
                                                                                    <li class="list-group-item">
                                                                                        <strong>{{ $index + 1 }}.
                                                                                            {{ $item->text }}</strong><br>
                                                                                        <em>Respuesta:</em>
                                                                                        @if (isset($responses["item_{$item->id}"]))
                                                                                            {{ $item->choices->where('id', $responses["item_{$item->id}"])->first()->text ?? 'Sin respuesta' }}
                                                                                        @else
                                                                                            <span
                                                                                                class="text-danger">Sin
                                                                                                respuesta</span>
                                                                                        @endif
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        @endif

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Botones de navegación -->
                                                        <div class="step"
                                                            style="display: {{ $count == $cant + 3 ? 'block' : 'none' }};">
                                                            <div class="panel panel-bordered">
                                                                <div class="panel-body text-center">
                                                                    <h3 class="fw-bold text-primary mb-3">
                                                                        Resultado del Test
                                                                    </h3>
                                                                    <h4
                                                                        class="{{ $testPassed ? 'text-success' : 'text-danger' }}">
                                                                        {{ $testPassed ? '¡Felicidades, aprobaste!' : 'Lo sentimos, debes intentarlo de nuevo' }}
                                                                    </h4>
                                                                    <p>Tu puntaje:
                                                                        <strong>{{ number_format($score, 2) }}%</strong>
                                                                    </p>

                                                                    @if (!$testPassed)
                                                                        <button class="btn btn-warning"
                                                                            wire:click="retryTest">
                                                                            <i class="voyager-refresh"></i>
                                                                            Reintentar
                                                                        </button>
                                                                    @elseif($testPassed)
                                                                    <p>El test ya fue aprobado </p>

                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Botones de navegación -->
                                                        <div class="col-md-12 text-center mt-3">
                                                            <button class="btn btn-danger" wire:click="prevStep"
                                                                @if ($currentStepIndex == 0 && $currentStepIndex == 0) disabled @endif>
                                                                <i class="fa fa-arrow-left "></i>
                                                                Anterior Contenido
                                                            </button>

                                                            @if ($count > 1 && !$showResults)
                                                                <button class="btn btn-warning"
                                                                    wire:click="previousItem">
                                                                    <i class="fa fa-arrow-left "></i>
                                                                    Anterior
                                                                </button>
                                                            @endif

                                                            @if ($count < $cant + 2)
                                                                <button class="btn btn-success" wire:click="nextItem">
                                                                    {{ $count >= 2 ? 'Siguiente' : 'Iniciar' }}
                                                                    <i class="fa fa-arrow-right "></i>
                                                                </button>
                                                            @elseif ($cant == 0)
                                                                <button class="btn btn-success" wire:click="nextStep">
                                                                    {{ $count >= 2 ? 'Siguiente' : 'Iniciar' }}
                                                                    <i class="fa fa-arrow-right "></i>
                                                                </button>
                                                            @elseif ($count == $cant + 2 && !$showResults)
                                                                <button class="btn btn-primary"
                                                                    wire:click="submitTest">
                                                                    <i class=" voyager-paper-plane"></i>
                                                                    Enviar
                                                                </button>
                                                            @endif

                                                            @if ($showResults)
                                                                {{-- ✅ Mostrar botón de "Reintentar" en la pantalla de resultados --}}
                                                                <button class="btn btn-primary"
                                                                    wire:click="retryTest">
                                                                    <i class="voyager-refresh"></i>
                                                                    Reintentar
                                                                </button> <button class="btn btn-success"
                                                                    wire:click="nextStep">
                                                                    <i class="fa fa-arrow-right"></i>
                                                                    Siguiente contenido
                                                                </button>
                                                            @endif
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
                                                                        <a data-toggle="collapse"
                                                                            data-parent="#accordion" href="#collapse1"
                                                                            style="text-decoration:none">
                                                                            <div class="panel-heading panel-heading-custom"
                                                                                id="heading1" style="padding: 4px">
                                                                                <p
                                                                                    style="padding: 5px; margin-bottom:0px">
                                                                                    <strong>Menu de contenidos</strong>
                                                                                </p>
                                                                            </div>
                                                                        </a>
                                                                        <div id="collapse1"
                                                                            class="panel-collapse collapse in">
                                                                            <div class="panel-body">
                                                                                <ul
                                                                                    class="list-group list-group-flush">
                                                                                    @foreach ($OnlineRegistrationSessionContent as $index => $content)
                                                                                        <li class="list-group-item">
                                                                                            <a href="#"
                                                                                                wire:click.prevent="goToStep({{ $index }})"
                                                                                                class="text-decoration-none {{ $currentStepIndex == $index ? 'fw-bold text-primary' : '' }}">
                                                                                                {{ $content->title }}
                                                                                            </a>
                                                                                        </li>
                                                                                    @endforeach
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
                </div>
            </div>
        </div>
    @elseif ($type == 'fin')
        <div class="text-center">
            <h2 class="text-success">¡Has finalizado el contenido!</h2>
            <p>Gracias por completar el curso.</p>
            <button wire:click="prevStep" class="btn btn-warning" {{ $currentStepIndex == 0 ? 'disabled' : '' }}>
                <i class="fa fa-arrow-left"></i> Anterior
            </button>
            <a href="{{ route('my-course-sessions', ['id' => $onlineRegistrationCourseSession->or_course_id]) }}"
                class="btn btn-primary">
                Regresar a las sesiones
            </a>
        </div>
    @elseif ($type == '')
        <div class="text-center">
            <h2 class="text-success">¡Aún no hay contenidos!</h2>
            <p>Ingresa un contenido.</p>
            <a href="{{ route('my-course-sessions', ['id' => $onlineRegistrationCourseSession->or_course_id]) }}"
                class="btn btn-primary">
                Regresar a las sesiones
            </a>
        </div>
    @endif
</div>
