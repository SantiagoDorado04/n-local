<div>
    @include('livewire.admin.information-forms.modals-questions.show')
    @include('livewire.admin.information-forms.modals-questions.create')
    @include('livewire.admin.information-forms.modals-questions.edit')
    @include('livewire.admin.information-forms.modals-questions.delete')


    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>

            @if ($form->stage_id == '')
                <li>
                    <a href="{{ route('processes') }}">Procesos</a>
                </li>
                <li>
                    <a href="{{ route('stages', ['id' => $form->step->stage->process_id]) }}">Etapas</a>
                </li>
                <li>
                    <a href="{{ route('steps', ['id' => $form->step->stage->id]) }}">Pasos</a>
                </li>
                <li>
                    <a href="{{ route('information-forms', ['id' => $form->step_id]) }}">Formularios</a>
                </li>
            @else
                <li>
                    <a href="{{ route('processes') }}">Procesos</a>
                </li>
                <li>
                    <a href="{{ route('stages', ['id' => $form->stage->process_id]) }}">Etapas</a>
                </li>
            @endif
            <li>
                Preguntas
            </li>
        </ol>
    @endsection

    @section('page_title', 'Preguntas | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            @if ($form->stage && $form->stage->embebed != '')
                <h1 class="page-title">
                    <i class="fa fa-question-circle"></i>&nbsp;Formulario de inscripción
                </h1>
            @else
                <h1 class="page-title">
                    <i class="fa fa-question-circle"></i>&nbsp;Preguntas
                    {{ $form->stage != '' ? ' - Formulario de inscripción' : '' }}
                </h1>
                <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal">
                    <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
                </button>
            @endif
        </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin-bottom:0px">
                    <div class="panel-body" style="margin-bottom:0px">
                        <small>
                            <ul>
                                @if ($form->stage_id == '')
                                    <li><strong>Proceso:</strong> {{ $form->step->stage->process->name }}</li>
                                    <li><strong>Etapa:</strong> {{ $form->step->stage->name }}</li>
                                    <li><strong>Paso:</strong> {{ $form->step->name }}</li>
                                    <li><strong>Formulario:</strong> {{ $form->name }}</li>
                                @else
                                    <li><strong>Proceso:</strong> {{ $form->stage->process->name }}</li>
                                    <li><strong>Etapa:</strong> {{ $form->stage->name }}</li>
                                @endif
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
                        @if ($form->stage && $form->stage->embebed != '')
                            <div class="embed-responsive embed-responsive-16by9">
                                {!! $form->stage->embebed !!}
                            </div>
                        @else
                            <div class="row no-margin-bottom" style="margin-bottom:12px">
                                <div class="col-lg-12">
                                    <label><strong>Buscar pregunta:</strong></label>
                                    <input type="text" class="form-control" wire:model="searchName"
                                        placeholder="Pregunta">
                                </div>
                            </div>
                            <div class="row no-margin-bottom" style="margin-bottom:12px">
                                <div class="col-lg-12">
                                    <i><small>* Arrastra la pregunta para cambiar su posición en el formulario.</small></i>
                                </div>
                            </div>
                            <div class="row no-margin-bottom" id="sortable-list">
                                @foreach ($questions as $question)
                                    <div class="col-lg-12 col-md-12 col-sm-12" data-id="{{ $question->id }}">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading panel-heading-custom">
                                                <h5 class="panel-title-custom">
                                                    {{ $loop->iteration.'. '. $question->text }}
                                                    <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                        <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                            data-toggle="dropdown"><i
                                                                class="fa fa-ellipsis-v"></i></button>
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
                                            <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                                data-toggle="modal" data-target="#show-modal"
                                                wire:click="show({{ $question->id }})">
                                                @php
                                                    $questionType = $question->type;
                                                    switch ($questionType) {
                                                        case 'AC':
                                                            $questionType = 'Texto corto';
                                                            break;
                                                        case 'AL':
                                                            $questionType = 'Texto largo';
                                                            break;
                                                        case 'OS':
                                                            $questionType = 'Opcion simple';
                                                            break;
                                                        case 'OM':
                                                            $questionType = 'Opcion multiple';
                                                            break;
                                                        case 'AD':
                                                            $questionType = 'Adjunto';
                                                            break;
                                                        default:
                                                            $questionType = 'No definido';
                                                            break;
                                                    }
                                                @endphp
                                                <div class="panel-body" style="height:120px">
                                                    <p style="text-align: justify; text-justify: inter-word;">
                                                        <strong>Pregunta: </strong>{{ $question->text }}
                                                    </p>
                                                    <p style="text-align: justify; text-justify: inter-word;">
                                                        <strong>Tipo: </strong>{{ $questionType }}
                                                    </p>
                                                </div>
                                            </button>
                                            @if ($question->type == 'OS' || $question->type == 'OM')
                                                <div class="panel-footer">
                                                    <div class="pull-right">
                                                        <a class="btn btn-success sm-b"
                                                            href="{{ route('information-forms-options', ['id' => $question->id]) }}">
                                                            <i class="fa fa-check-square-o"></i>&nbsp;Opciones Respuesta
                                                        </a>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="row no-margin-bottom">
                                <div class="col-lg-6" style="padding-top:22px">
                                    <span>{!! $paginationText !!}</span>
                                </div>
                                <div class="col-lg-6 text-right">
                                    {{ $questions->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('livewire:load', function() {
        var el = document.getElementById('sortable-list');
        var sortable = Sortable.create(el, {
            onEnd: function(evt) {
                var orderedIds = Array.from(el.children).map(child => child.dataset.id);
                @this.call('updateQuestionOrder', orderedIds);
            }
        });
    });
</script>
