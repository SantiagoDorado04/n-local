<div>
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li><a href="{{ route('processes.contact') }}">Procesos</a></li>
            <li><a href="{{ route('steps.contact', ['id' => $compliance->step->stage_id]) }}">Pasos</a></li>
            <li>Formulario de Compliance Verification</li>
        </ol>
    @endsection

    @section('page_title', 'Compliance Verification | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-check-square-o"></i> {{ $compliance->step->name }}
            </h1>
        </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin-bottom:0px">
                    <div class="panel-body" style="margin-bottom:0px">
                        <small>
                            <ul>
                                <li><strong>Proceso:</strong> {{ $compliance->step->stage->process->name }}</li>
                                <li><strong>Etapa:</strong> {{ $compliance->step->stage->name }}</li>
                                <li><strong>Paso:</strong> {{ $compliance->step->name }}</li>
                            </ul>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Contenido principal --}}
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">

                        @if ($requirementsMet)
                            <form wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))">
                                <p>{{ $compliance->step->description }}</p>

                                @foreach ($compliance->questions as $question)
                                    <div class="form-group">
                                        <label><strong>{{ $loop->iteration }}. {{ $question->text }}</strong></label>
                                        <input type="text" class="form-control" name="question_{{ $question->id }}"
                                            value="{{ $answers[$question->id]->answer ?? '' }}"
                                            @if ($hasAnswers) disabled @endif>
                                    </div>
                                @endforeach

                                <div class="text-center">
                                    @if ($hasAnswers)
                                        <p><strong>Ya has completado y enviado este formulario.</strong></p>
                                    @else
                                        <button id="submit-btn" type="submit" class="btn btn-success">Enviar</button>
                                    @endif
                                </div>
                            </form>
                        @else
                            <div class="alert alert-danger">
                                Debe completar estos pasos antes de poder acceder al formulario:
                            </div>
                        @endif

                        {{-- pasos incompletos --}}
                        @if (!empty($incompleteSteps))
                            <div class="row">
                                @foreach ($incompleteSteps as $step)
                                    @if (\Carbon\Carbon::parse($step->available_from)->lessThanOrEqualTo(\Carbon\Carbon::now()))
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading panel-heading-custom">
                                                    <h5 class="panel-title-custom">
                                                        <strong>Paso:</strong> {{ $step->name }}
                                                    </h5>
                                                </div>

                                                <div class="panel-body" style="height:120px">
                                                    <p style="text-align: justify; text-justify: inter-word;">
                                                        <strong>Descripción: </strong>
                                                        {{ Str::limit($step->description, 145) }}
                                                    </p>
                                                </div>

                                                <div class="panel-footer">
                                                    <div class="pull-right">
                                                        @switch($step->step_type)
                                                            @case('F')
                                                                <a class="btn btn-success sm-b"
                                                                    href="{{ route('information-forms.contact', ['id' => $step->id]) }}">
                                                                    <i class="fa fa-arrow-right"></i> Ver Formulario
                                                                </a>
                                                            @break

                                                            @case('CD')
                                                                <a class="btn btn-success sm-b"
                                                                    href="{{ route('challenges.contact', ['id' => $step->id]) }}">
                                                                    <i class="fa fa-arrow-right"></i> Ver Reto / Entregable
                                                                </a>
                                                            @break

                                                            @case('LZ')
                                                                <a class="btn btn-success sm-b"
                                                                    href="{{ route('canvas.contact', ['id' => $step->id]) }}">
                                                                    <i class="fa fa-arrow-right"></i> Lienzo
                                                                </a>
                                                            @break

                                                            @case('AL')
                                                                <a class="btn btn-success sm-b"
                                                                    href="{{ route('alquimia-agent.contact', ['id' => $step->id]) }}">
                                                                    <i class="fa fa-arrow-right"></i> Agente AlquimIA
                                                                </a>
                                                            @break

                                                            @case('AT')
                                                                <a class="btn btn-success sm-b"
                                                                    href="{{ route('process-advisor-scheduling.contact', ['id' => $step->id]) }}">
                                                                    <i class="fa fa-arrow-right"></i> Agendamiento con Asesor
                                                                </a>
                                                            @break

                                                            @case('CV')
                                                                <a class="btn btn-success sm-b"
                                                                    href="{{ route('process-compliance-verification.contact', ['id' => $step->id]) }}">
                                                                    <i class="fa fa-arrow-right"></i> Compliance Verification
                                                                </a>
                                                            @break
                                                        @endswitch
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="alert alert-info">
                                                <strong>{{ $step->name }}</strong> estará disponible desde
                                                {{ \Carbon\Carbon::parse($step->available_from)->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
