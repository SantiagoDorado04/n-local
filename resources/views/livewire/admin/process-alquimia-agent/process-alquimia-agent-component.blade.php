<div>
    @include('livewire.admin.process-alquimia-agent.modals-questions.create')
    @include('livewire.admin.process-alquimia-agent.modals-questions.edit')
    @include('livewire.admin.process-alquimia-agent.modals-questions.delete')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('processes') }}">Procesos</a>
            </li>
            <li>
                <a href="{{ route('stages', ['id' => $step->stage->process_id]) }}">Etapas</a>
            </li>
            <li>
                <a href="{{ route('steps', ['id' => $step->stage_id]) }}">Pasos</a>
            </li>
            <li>Agente AlquimIA
            </li>
        </ol>
    @endsection

    @section('page_title', 'Agente AlquimIA | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-cloud-upload"></i>&nbsp;Agente AlquimIA
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
                                <li><strong>Proceso:</strong> {{ $step->stage->process->name }}</li>
                                <li><strong>Etapa:</strong> {{ $step->stage->name }}</li>
                                <li><strong>Paso:</strong> {{ $step->name }}</li>
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
                        <div class="row no-margin-bottom" style="margin-bottom:12px">
                            <div class="col-lg-12">
                                <label for=""><strong>Cargar Plantilla</strong></label>
                            </div>
                            <div class="col-lg-8">
                                <input type="file" class="form-control" wire:model="template">
                                @error('template')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-4">
                                <button class="btn  btn-success" wire:click="upload"><i class="fa fa-upload"
                                        aria-hidden="true"></i>&nbsp;Cargar</button>
                                @if ($agent->url_file != '')
                                    <button class="btn btn-primary" wire:click='downloadTemplate'><i
                                            class="fa fa-download" aria-hidden="true"></i>&nbsp;Descargar</button>
                                @endif
                            </div>
                        </div>
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
                        <div class="row no-margin-bottom" style="margin-bottom:12px">
                            <div class="col-md-12">
                                <button class="btn btn-success btn-add-new" data-toggle="modal"
                                    data-target="#create-modal">
                                    <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
                                </button>
                                <a class="btn btn-success"
                                    href="{{ route('process-alquimia-agent-list', ['id' => $this->agentId]) }}"><i
                                        class="voyager-puzzle"></i>&nbsp;Entregas</a>
                            </div>
                        </div>
                        <div class="row no-margin-bottom" style="margin-bottom:12px">
                            @foreach ($questions as $question)
                                <div class="col-lg-12 col-md-12 col-sm-12" data-id="{{ $question->id }}">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ $loop->iteration . '. ' . $question->text }}
                                                <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                    <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                        data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-toggle="modal" data-target="#edit-modal"
                                                                wire:click="edit({{ $question->id }})"><i
                                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a>
                                                        </li>
                                                        <li><a data-toggle="modal" data-target="#delete-modal"
                                                                wire:click="delete({{ $question->id }})"><i
                                                                    class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </h5>
                                        </div>
                                        <div class="panel-body" style="height:120px">
                                            <p style="text-align: justify; text-justify: inter-word;">
                                                <strong>Prompt: </strong>{{ $question->prompt }}
                                            </p>
                                            <p style="text-align: justify; text-justify: inter-word;">
                                                <strong>Guía: </strong>{{ $question->guide }}
                                            </p>
                                            <p style="text-align: justify; text-justify: inter-word;">
                                                <strong>Variable: </strong>{{ $convertToVariable($question->text) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
