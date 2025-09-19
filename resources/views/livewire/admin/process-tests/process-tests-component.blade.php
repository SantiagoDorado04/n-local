<div>
    @include('livewire.admin.process-tests.modals-questions.create')
    @include('livewire.admin.process-tests.modals-questions.edit')
    @include('livewire.admin.process-tests.modals-questions.delete')

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
            <li>Test del proceso: {{ $processTest->name }}
            </li>
        </ol>
    @endsection

    @section('page_title', 'Test de proceso | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-cloud-upload"></i>&nbsp;Test de proceso
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
                            <div class="col-md-12">
                                <button class="btn btn-success btn-add-new" data-toggle="modal"
                                    data-target="#create-modal">
                                    <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
                                </button>
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
                                                <strong>Pregunta: </strong>{{ $question->text }}
                                            </p>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="pull-right">
                                                <a class="btn btn-success sm-b"
                                                    href="{{ route('process-test-options', ['id' => $question->id]) }}">
                                                    <i class="fa fa-check-square-o"></i>&nbsp;Opciones de respuesta
                                                </a>
                                            </div>
                                            <div class="clearfix"></div>
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
