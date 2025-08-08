<div>
    <div wire:loading wire:target="generateDeepSeekText">
        @include('partials.loader')
    </div>
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('processes.contact') }}">Procesos</a>
            </li>
            <li>
                <a href="{{ route('steps.contact', ['id' => $canva->step->stage_id]) }}">Pasos</a>
            </li>
            <li>
                Formulario
            </li>
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
                <div class="panel panel-bordered" style="margin-bottom:0px">
                    <div class="panel-body" style="margin-bottom:0px">
                        <small>
                            <ul>
                                <li><strong>Proceso:</strong> {{ $canva->step->stage->process->name }}</li>
                                <li><strong>Etapa:</strong> {{ $canva->step->stage->name }}</li>
                                <li><strong>Paso:</strong> {{ $canva->step->name }}</li>
                            </ul>
                        </small>
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
                            <div class="col-md-12">
                                <h6><i>** Diligenciar el siguiente formulario para descargar el canvas</i></h6>
                            </div>
                            <form wire:submit.prevent="saveAnswers">
                                @foreach ($questions as $question)
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="question-{{ $question->id }}">
                                                <strong>{{ $question->text }}: </strong>
                                            </label>
                                            <textarea id="question-{{ $question->id }}" class="form-control" wire:model.defer="answers.{{ $question->id }}"
                                                rows="3"></textarea>

                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-right text-end">
                                        <button type="button" class="btn btn-warning sm-b "
                                            wire:click="generateDeepSeekText('{{ $question->text }}', {{ $question->id }})">
                                            <i class="voyager-lightbulb"></i>Generar Texto con IA
                                        </button>
                                    </div>
                                @endforeach
                                <div class="col-lg-12 text-center">
                                    @if (!$stageActive)
                                        <p><strong>La etapa en la que te encuentras ya no esta activa o ha
                                                finalizado.</strong>
                                        </p>
                                    @else
                                        <button type="submit" class="btn btn-success sm-b">
                                            Guardar Respuestas
                                        </button>
                                    @endif
                                </div>
                            </form>
                        </div>
                        @if ($answers != '')
                            <div class="row no-margin-bottom">
                                <div class="col-lg-12 text-center">
                                    <button wire:click="downloadTemplate"
                                        class="btn btn-primary sm-b">Descargar</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
