<div>
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}">
                    <i class="voyager-boat"></i> {{ __('voyager::generic.dashboard') }}
                </a>
            </li>
            <li><a href="{{ route('processes.contact') }}">Procesos</a></li>
            <li><a href="{{ route('steps.contact', ['id' => $form->step->stage_id]) }}">Pasos</a></li>
            <li>Formulario</li>
        </ol>
    @endsection

    @section('page_title', 'Formulario Información | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-news"></i> {{ $form->name }}
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
                                <li><strong>Proceso:</strong> {{ $form->step->stage->process->name }}</li>
                                <li><strong>Etapa:</strong> {{ $form->step->stage->name }}</li>
                                <li><strong>Paso:</strong> {{ $form->step->name }}</li>
                            </ul>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        @php
            $requiredPoints = $form->required_points ?? 0;
            $userPoints = Auth::user()->contact ? Auth::user()->contact->points : 0;
            $hasAccess = $requiredPoints == 0 || $userPoints >= $requiredPoints;
        @endphp

        @if ($hasAccess)
            <div class="col-md-12">
                <div class="row no-margin-bottom">
                    @if ($form->embebed)
                        <div class="embed-responsive embed-responsive-16by9">
                            {!! $form->embebed !!}
                        </div>
                    @else
                        <form wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))">
                            <div class="col-lg-12">
                                <div class="panel panel-bordered">
                                    <div class="panel-body">
                                        <p>{{ $form->description }}</p>
                                    </div>
                                </div>
                            </div>

                            @foreach ($form->questions as $question)
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

                                                    @switch($question->type)
                                                        @case('OM')
                                                        @case('OS')
                                                            @if ($question->options)
                                                                @foreach ($question->options as $option)
                                                                    <input type="radio" id="option_{{ $option->id }}"
                                                                        name="question_{{ $question->id }}"
                                                                        value="{{ $option->id }}"
                                                                        @if (isset($answers[$question->id]) && $answers[$question->id]->answer == $option->id) checked @endif
                                                                        @if ($hasAnswers) disabled @endif>
                                                                    <label for="option_{{ $option->id }}"
                                                                        class="radio-option">{{ $option->text }}</label><br>
                                                                @endforeach
                                                            @else
                                                                <p>No hay opciones disponibles para esta pregunta.</p>
                                                            @endif
                                                        @break

                                                        @case('AD')
                                                            <input type="file" name="question_{{ $question->id }}"
                                                                accept="image/*"
                                                                @if ($hasAnswers) disabled @endif>
                                                        @break

                                                        @case('AC')
                                                            <input type="text" class="form-control"
                                                                name="question_{{ $question->id }}"
                                                                value="{{ $answers[$question->id]->answer ?? '' }}"
                                                                @if ($hasAnswers) disabled @endif>
                                                        @break

                                                        @case('AL')
                                                            <textarea class="form-control" name="question_{{ $question->id }}" @if ($hasAnswers) disabled @endif>{{ $answers[$question->id]->answer ?? '' }}</textarea>
                                                        @break
                                                    @endswitch
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-md-12 text-center">
                                <div class="panel panel-bordered">
                                    <div class="panel-body">
                                        @if ($hasAnswers)
                                            <p><strong>Ya has completado y enviado este formulario.</strong></p>
                                        @elseif(!$stageActive)
                                            <p><strong>La etapa en la que te encuentras ya no esta activa o ha
                                                    finalizado.</strong>
                                            </p>
                                        @else
                                            <button id="submit-btn" type="submit"
                                                class="btn btn-success">Enviar</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        @else
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <p>No tienes suficientes puntos. Te faltan {{ $requiredPoints - $userPoints }} puntos para
                            acceder a
                            este recurso.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
