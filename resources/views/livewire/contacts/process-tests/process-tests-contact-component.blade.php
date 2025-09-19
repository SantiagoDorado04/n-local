<div>
    <div wire:loading wire:target="downloadResult">
        @include('partials.loader')
    </div>
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}">
                    <i class="voyager-boat"></i> {{ __('voyager::generic.dashboard') }}
                </a>
            </li>
            <li><a href="{{ route('processes.contact') }}">Procesos</a></li>
            <li><a href="{{ route('steps.contact', ['id' => $processTest->step->stage_id]) }}">Pasos</a></li>
            <li>Test</li>
        </ol>
    @endsection

    @section('page_title', 'Test | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-news"></i> {{ $processTest->name }}
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
                                <li><strong>Proceso:</strong> {{ $processTest->step->stage->process->name }}</li>
                                <li><strong>Etapa:</strong> {{ $processTest->step->stage->name }}</li>
                                <li><strong>Paso:</strong> {{ $processTest->step->name }}</li>
                            </ul>
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row no-margin-bottom">
                <form wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))">
                    <div class="col-lg-12">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <p> {!! nl2br(e($processTest->description)) !!}</p>
                            </div>
                        </div>
                    </div>
                    @foreach ($processTest->questions as $question)
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if (!$hasAnswers)
                        <div class="col-md-12 text-center">
                            <div class="panel panel-bordered">
                                <div class="panel-body">

                                    @if (!$stageActive)
                                        <p><strong>La etapa en la que te encuentras ya no esta activa o ha
                                                finalizado.</strong>
                                        </p>
                                    @else
                                        <button id="submit-btn" type="submit" class="btn btn-success">Enviar</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
                <div class="col-md-12 text-center">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            @if ($hasAnswers)
                                <button wire:click="downloadResult" class="btn btn-primary">
                                    Descargar resultado
                                </button>
                            @elseif(!$stageActive)
                                <button wire:click="downloadResult" class="btn btn-primary">
                                    Descargar resultado
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
