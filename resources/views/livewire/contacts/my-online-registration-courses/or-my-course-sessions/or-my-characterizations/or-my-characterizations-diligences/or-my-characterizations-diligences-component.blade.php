<div>
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}">
                    <i class="voyager-boat"></i> {{ __('voyager::generic.dashboard') }}
                </a>
            </li>
            <li><a
                    href="{{ route('my-course-sessions', ['id' => $form->session->onlineRegistrationCourse->id]) }}">Sesiones</a>
            </li>
            <li><a href="{{ route('my-or-characterizations', ['id' => $form->session->id]) }}">Caracterizaciones</a>
            </li>
            <li>Diligenciar caracterizacion</li>
        </ol>
    @endsection

    @section('page_title', 'Diligenciar caracterizacion | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-news"></i> Diligencia de caracterizacion - {{ $form->name }}
            </h1>
        </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <small>
                            <ul>
                                <li><strong>Curso:</strong> {{ $form->session->onlineRegistrationCourse->name }}</li>
                                <li><strong>Sesion:</strong> {{ $form->session->name }}</li>
                                <li><strong>Caracterizacion:</strong> {{ $form->name }}</li>
                            </ul>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        @if ($questions->isNotEmpty())
            <div class="col-md-12">
                <div class="row no-margin-bottom">
                    <form wire:submit.prevent="submit">
                        @foreach ($questions as $question)
                            <div class="row no-margin-bottom">
                                <div class="col-md-12">
                                    <div class="panel panel-bordered">
                                        <div class="panel-body">
                                            <div class="row no-margin-bottom">
                                                <div class="col-md-1">
                                                    <strong>{{ $loop->iteration . '. ' }}</strong>
                                                </div>
                                                <div class="col-md-11">
                                                    <p>{{ $question->text }}</p>
                                                    {!! nl2br($question->question) !!}
                                                    @if ($question->type == 'OM')
                                                        <div>
                                                            @foreach ($question->options as $option)
                                                                <input type="checkbox"
                                                                    wire:model="answers.question_{{ $question->id }}"
                                                                    value="{{ $option->id }}"
                                                                    id="option_{{ $option->id }}">
                                                                <label
                                                                    for="option_{{ $option->id }}">{{ $option->text }}</label><br>
                                                            @endforeach
                                                        </div>
                                                    @elseif ($question->type == 'OS')
                                                        <div>
                                                            @foreach ($question->options as $option)
                                                                <input type="radio"
                                                                    name="question_{{ $question->id }}"
                                                                    wire:model.defer="answers.question_{{ $question->id }}"
                                                                    value="{{ $option->id }}">
                                                                <label
                                                                    for="option_{{ $option->id }}">{{ $option->text }}</label>
                                                                <br>
                                                            @endforeach
                                                        </div>
                                                    @elseif ($question->type == 'AC')
                                                        <input type="text"
                                                            wire:model.defer="answers.question_{{ $question->id }}"
                                                            class="form-control">
                                                    @elseif ($question->type == 'AL')
                                                        <textarea wire:model.defer="answers.question_{{ $question->id }}" class="form-control" rows="4"></textarea>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="text-center mt-4">
                                <a href="{{ route('my-or-characterizations', ['id' => $form->session->id]) }}"
                                    class="btn btn-danger">
                                    <i class="fa fa-arrow-left "></i> Regresar a las caracterizaciones
                                </a>
                            <button type="submit"
                                class="btn {{ $hasAnswers ? 'btn-primary' : 'btn-success' }} btn-lg px-5">
                                <i class="fa {{ $hasAnswers ? 'fa-refresh' : 'fa-paper-plane' }}"></i>&nbsp;
                                {{ $hasAnswers ? 'Actualizar' : 'Enviar' }}
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <h5 style="color: crimson"><strong>Este formulario de caracterizacion aun no tiene preguntas,
                                espera para poder
                                diligenciarlo.</strong>
                        </h5>
                        <div class="text-center">
                            <a href="{{ route('my-or-characterizations', ['id' => $form->session->id]) }}"
                                class="btn btn-danger">
                                <i class="fa fa-arrow-left "></i> Regresar a las caracterizaciones
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
