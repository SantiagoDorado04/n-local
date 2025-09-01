<div>
    @include('livewire.contacts.process-alquimia-agents.modals.show')
    @include('livewire.contacts.process-alquimia-agents.modals.delete')
    {{-- <div wire:loading wire:target="generateWithAI">
        @include('partials.loader')
    </div> --}}
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
                <a href="{{ route('steps.contact', ['id' => $processAlquimiaAgent->step->stage->process_id]) }}">Etapas</a>
            </li>
            <li>
                <a href="{{ route('steps.contact', ['id' => $processAlquimiaAgent->step->stage_id]) }}">Pasos</a>
            </li>
            <li>
                Formulario
            </li>
        </ol>
    @endsection

    @section('page_title', 'Agente AlquimIA | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-news"></i> {{ $processAlquimiaAgent->name }}
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
                                <li><strong>Proceso:</strong> {{ $processAlquimiaAgent->step->stage->process->name }}
                                </li>
                                <li><strong>Etapa:</strong> {{ $processAlquimiaAgent->step->stage->name }}</li>
                                <li><strong>Paso:</strong> {{ $processAlquimiaAgent->step->name }}</li>
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
                                <h6><i>** Diligenciar el siguiente formulario para descargar el lienzo IA</i></h6>
                                <br>
                                <h6><strong>Descripción: </strong> {{ $processAlquimiaAgent->description }}</h6>
                                <h6><strong>Guía de IA: </strong> si usted encuentra un campo como <code><em>[$saludo] =
                                            saluda
                                            aqui</em></code>,
                                    complete el campo con la respuesta correspondiente para generar el texto con IA.
                                </h6>
                            </div>
                            <form wire:submit.prevent="saveAnswers">
                                @foreach ($questions as $question)x
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="question-{{ $question->id }}">
                                                <strong>{{ $question->text }}: </strong>
                                            </label>
                                            <textarea id="question-{{ $question->id }}" class="form-control" wire:model="answers.{{ $question->id }}"
                                                rows="8"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-right text-end">
                                        {{-- <button type="button" class="btn btn-warning sm-b" data-toggle="modal"
                                            data-target="#show-modal"
                                            wire:click="generateWithAI({{ $question->id }}, @js($answers[$question->id] ?? ''))">
                                            <i class="voyager-lightbulb"></i> Generar Texto con IA
                                        </button> --}}
                                        <button type="button" class="btn btn-warning sm-b" data-toggle="modal"
                                            data-target="#show-modal" wire:click="openChatModal({{ $question->id }})">
                                            <i class="voyager-lightbulb"></i> Generar Texto con IA
                                        </button>

                                        <button type="button" class="btn btn-danger sm-b" data-toggle="modal"
                                            data-target="#delete-modal"
                                            wire:click="resetAnswerToGuide({{ $question->id }})">
                                            <i class="voyager-trash"></i> Limpiar
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('scrollChatToBottom', function() {
                const el = document.getElementById('chatWindow');
                if (el) el.scrollTop = el.scrollHeight;
            });
        });
    </script>

</div>
