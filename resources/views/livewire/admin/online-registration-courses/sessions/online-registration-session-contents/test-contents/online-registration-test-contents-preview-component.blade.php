<div>

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li><a href="{{ route('online-registrations') }}">Controles de registro</a></li>
            <li><a
                    href="{{ route('online-registration-categories', ['id' => $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->id]) }}">Categorias</a>
            </li>
            <li><a
                    href="{{ route('online-registration-courses', ['id' => $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->id]) }}">Cursos</a>
            </li>
            <li><a
                    href="{{ route('online-registration-courses-sessions', ['id' => $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->id]) }}">Sesiones</a>
            </li>
            <li><a
                    href="{{ route('online-registration-sessionContent', ['id' => $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->id]) }}">Contenidos</a>
            </li>
            <li><a>Lección</a></li>
        </ol>
    @endsection

    @section('page_title', 'Test | ' . setting('admin.title'))
    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-book"></i>&nbsp; Previsualización del test
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
                                {{ $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->name }}<br>
                            </li>
                            <li><strong>Categoria: </strong>
                                {{ $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->name }}<br>
                            </li>
                            <li><strong>Curso: </strong>
                                {{ $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->name }}<br>
                            </li>
                            <li><strong>Sesión: </strong> {{ $test->onlineRegistrationSessionContent->title }}<br></li>

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
                                        <!-- Contenido principal -->
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
                                                                                                <input type="radio"
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
                                                        {{--   @php
                                                            dd($cant);
                                                        @endphp --}}
                                                        <div class="step"
                                                            style="display: {{ $count == $cant + 2 ? 'block' : 'none' }};">
                                                            <div class="panel panel-bordered">
                                                                <div class="panel-body">

                                                                    @if ($cant == 0)
                                                                        <h3
                                                                            class="fw-bold text-primary mb-3 text-center">
                                                                            No se encontraron preguntas</h3>
                                                                        <p class="text-muted text-center">Verifica tus
                                                                            preguntas del formulario.
                                                                        </p>
                                                                    @else
                                                                        <h3
                                                                            class="fw-bold text-primary mb-3 text-center">
                                                                            Revisión Final</h3>
                                                                        <p class="text-muted text-center">Verifica tus
                                                                            respuestas antes de enviar el formulario.
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
                                                                                        <span class="text-danger">Sin
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
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Botones de navegación -->
                                                    <div class="col-md-12 text-center mt-3">
                                                        <a href="{{ route('online-registration-sessionContent', ['id' => $test->onlineRegistrationSessionContent->session_id]) }}"
                                                            class="btn btn-danger">
                                                            <i class="fa fa-close"></i> Salir
                                                        </a>

                                                        @if ($count > 1 && !$showResults)
                                                            {{-- ✅ Mostrar "Anterior" en cualquier pregunta --}}
                                                            <button class="btn btn-warning" wire:click="previousItem">
                                                                <i class="fa fa-arrow-left"></i> Anterior
                                                            </button>
                                                        @endif

                                                        @if ($count < $cant + 2)
                                                            {{-- ✅ Mostrar "Siguiente" excepto en el último paso --}}
                                                            <button class="btn btn-success" wire:click="nextItem">
                                                                {{ $count >= 2 ? 'Siguiente' : 'Iniciar' }}
                                                                <i class="fa fa-arrow-right"></i>
                                                            </button>
                                                        @elseif ($cant == 0)

                                                        @elseif ($count == $cant + 2 && !$showResults)
                                                            {{-- ✅ Mostrar "Enviar" en el último paso antes de resultados --}}
                                                            <button class="btn btn-primary" wire:click="submitTest">
                                                                Enviar
                                                                <i class="voyager-paper-plane"></i>
                                                            </button>
                                                        @endif

                                                        @if ($showResults)
                                                            {{-- ✅ Mostrar botón de "Reintentar" en la pantalla de resultados --}}
                                                            <button class="btn btn-primary" wire:click="retryTest">
                                                                <i class="voyager-refresh"></i>
                                                                Reintentar
                                                            </button>
                                                            <button class="btn btn-success">
                                                                Siguiente contenido
                                                                <i class="fa fa-arrow-right"></i>
                                                            </button>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="panel panel-bordered">
                                                <div class="panel-body text-center">
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
                                                                    <ul class="list-group">
                                                                        <li class="list-group-item"><a href="#"
                                                                                wire:click="">Slide
                                                                                1</a>
                                                                        </li>
                                                                        <li class="list-group-item"><a href="#"
                                                                                wire:click="">Video</a>
                                                                        </li>
                                                                        <li class="list-group-item"><a href="#"
                                                                                wire:click="">Lección</a>
                                                                        </li>
                                                                        <li class="list-group-item"><a href="#"
                                                                                wire:click="">Test</a>
                                                                        </li>
                                                                        <li class="list-group-item"><a href="#"
                                                                                wire:click="">Despedida</a></li>
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
