<div>
    @include('livewire.admin.steps.modals.show')
    @include('livewire.admin.steps.modals.create')
    @include('livewire.admin.steps.modals.edit')
    @include('livewire.admin.steps.modals.delete')
    @include('livewire.admin.steps.modals.import')

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
                <a href="{{ route('stages', ['id' => $stage->process_id]) }}">Etapas</a>
            </li>
            <li>
                Pasos
            </li>
        </ol>
    @endsection

    @section('page_title', 'Pasos | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-road" aria-hidden="true"></i>Pasos
            </h1>
            <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal">
                <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
            </button>
            <button class="btn btn-primary btn-add-new" data-toggle="modal" data-target="#create-modal-2">
                <i class="fa fa-plus-square"></i> <span>Importar paso</span>
            </button>
        </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin-bottom:0px">
                    <div class="panel-body" style="margin-bottom:0px">
                        <small>
                            <ul>
                                <li><strong>Proceso: </strong> {{ $stage->process->name }}<br></li>
                                <li><strong>Etapa: </strong> {{ $stage->name }}<br></li>
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
                                <label><strong>Buscar paso:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Nombre del paso">
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            <div id="sortable-list" class="d-flex flex-nowrap overflow-auto">
                                @foreach ($steps as $step)
                                    <div class="col-lg-4 col-md-6 col-sm-12 sortable-item"
                                        data-id="{{ $step->id }}">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading panel-heading-custom">
                                                <h5 class="panel-title-custom">
                                                    {{ $step->order . '. ' . Str::limit($step->name, 23) }}
                                                    <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                        <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                            data-toggle="dropdown"><i
                                                                class="fa fa-ellipsis-v"></i></button>
                                                        <ul class="dropdown-menu">
                                                            <li><a data-toggle="modal" data-target="#edit-modal"
                                                                    wire:click="edit({{ $step->id }})"><i
                                                                        class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a>
                                                            </li>
                                                            <li><a data-toggle="modal" data-target="#delete-modal"
                                                                    wire:click="delete({{ $step->id }})"><i
                                                                        class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </h5>
                                            </div>
                                            <button
                                                style="background-color: #fff; border:0px; margin:0px; padding:0px; width:100%"
                                                data-toggle="modal" data-target="#show-modal"
                                                wire:click="show({{ $step->id }})"
                                                title="Clic para ver más detalles...">
                                                @php
                                                    $stepType = $step->step_type;
                                                    switch ($stepType) {
                                                        case 'F':
                                                            $stepType = 'Formulario';
                                                            break;
                                                        case 'M':
                                                            $stepType = 'Mentoría';
                                                            break;
                                                        case 'CD':
                                                            $stepType = 'Retos - Entregables';
                                                            break;
                                                        case 'FAA':
                                                            $stepType = 'Actividades presenciales';
                                                            break;
                                                        case 'LMS':
                                                            $stepType = 'Aprendizaje';
                                                            break;
                                                        case 'LZ':
                                                            $stepType = 'Lienzo';
                                                            break;
                                                        case 'VE':
                                                            $stepType = 'Video Entrevista';
                                                            break;
                                                        case 'AL':
                                                            $stepType = 'Agente AlquimIA';
                                                            break;
                                                        case 'AL':
                                                            $stepType = 'Agente AlquimIA';
                                                            break;
                                                        case 'CV':
                                                            $stepType = 'Verificacion de cumplimiento';
                                                            break;
                                                        default:
                                                            $stepType = 'No definido';
                                                            break;
                                                    }
                                                @endphp
                                                <div class="panel-body" style="height:180px">
                                                    <ul class="list-group list-group-flush" style="width: 100%;">
                                                        <li class="list-group-item">
                                                            <p
                                                                style="text-align: justify; text-justify: inter-word; margin:0px">
                                                                <strong>Nombre: </strong>
                                                                {{ Str::limit($step->name, 40) }}
                                                            </p>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <p
                                                                style="text-align: justify; text-justify: inter-word; margin:0px">
                                                                <strong>Tipo: </strong>
                                                                {{ Str::limit($stepType, 40) }}
                                                            </p>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <p
                                                                style="text-align: justify; text-justify: inter-word; margin:0px">
                                                                <strong>Descripcion: </strong>
                                                                {{ Str::limit($step->description, 40) }}
                                                            </p>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <p
                                                                style="text-align: justify; text-justify: inter-word; margin:0px">
                                                                <strong>Disponible desde: </strong>
                                                                {{ Str::limit($step->available_from) }}
                                                            </p>
                                                        </li>
                                                        {{-- <li class="list-group-item">
                                                            <p
                                                                style="text-align: justify; text-justify: inter-word; margin:0px">
                                                                <strong>Orden: </strong>
                                                                {{ Str::limit($step->order, 40) }}
                                                            </p>
                                                        </li> --}}
                                                    </ul>
                                                </div>
                                            </button>

                                            <div class="panel-footer">
                                                <div class="pull-right">
                                                    @switch($step->step_type)
                                                        @case('F')
                                                            <a class="btn btn-success sm-b"
                                                                href="{{ route('information-forms', ['id' => $step->id]) }}"><i
                                                                    class="fa fa-clipboard"></i>&nbsp;Formulario</a>
                                                        @break

                                                        @case('LMS')
                                                            <a class="btn btn-success sm-b"
                                                                href="{{ route('courses', ['id' => $step->id]) }}"><i
                                                                    class="fa fa-file-video-o"></i>&nbsp;Cursos</a>
                                                        @break

                                                        @case('FAA')
                                                            <a class="btn btn-success sm-b"
                                                                href="{{ route('presential-activities', ['id' => $step->id]) }}"><i
                                                                    class="fa fa-handshake-o"></i>&nbsp;Actividades
                                                                presenciales</a>
                                                        @break

                                                        @case('CD')
                                                            <a class="btn btn-success sm-b"
                                                                href="{{ route('challenges', ['id' => $step->id]) }}"><i
                                                                    class="voyager-puzzle"></i>&nbsp;Retos / Entregables</a>
                                                        @break

                                                        @case('M')
                                                            <a class="btn btn-success sm-b"
                                                                href="{{ route('mentoring', ['id' => $step->id]) }}"><i
                                                                    class="voyager-puzzle"></i>&nbsp;Mentores</a>
                                                        @break

                                                        @case('LZ')
                                                            <a class="btn btn-success sm-b"
                                                                href="{{ route('canvas', ['id' => $step->id]) }}"><i
                                                                    class="voyager-puzzle"></i>&nbsp;Lienzo</a>
                                                        @break

                                                        @case('AL')
                                                            <a class="btn btn-success sm-b"
                                                                href="{{ route('process-alquimia-agent', ['id' => $step->id]) }}"><i
                                                                    class="voyager-puzzle"></i>&nbsp;Agente AlquimIA</a>
                                                        @break

                                                        @case('CV')
                                                            <a class="btn btn-success sm-b"
                                                                href="{{ route('process-compliance-verification', ['id' => $step->id]) }}"><i
                                                                    class="voyager-boat"></i>&nbsp;Verificacion de
                                                                cumplimiento</a>
                                                        @break

                                                        @case('PT')
                                                            <a class="btn btn-success sm-b"
                                                                href="{{ route('process-test-appreciations', ['id' => $step->id]) }}"><i
                                                                    class="voyager-puzzle"></i>&nbsp;Apreciaciones del Test</a>
                                                            <a class="btn btn-success sm-b"
                                                                href="{{ route('process-test-categories', ['id' => $step->id]) }}"><i
                                                                    class="voyager-puzzle"></i>&nbsp;Categorias</a>
                                                            <a class="btn btn-success sm-b"
                                                                href="{{ route('process-test-answers', ['id' => $step->id]) }}"><i
                                                                    class="voyager-puzzle"></i>&nbsp;Respuestas</a>
                                                            <a class="btn btn-success sm-b"
                                                                href="{{ route('process-test', ['id' => $step->id]) }}"><i
                                                                    class="voyager-puzzle"></i>&nbsp;Preguntas</a>
                                                        @break

                                                        @case('AT')
                                                            <h5>Agendamiento de Asesoría</h5>
                                                        @break

                                                        @case('VE')
                                                            @if ($step->interview)
                                                                <a class="btn btn-primary sm-b"
                                                                    href="{{ route('video-interviews.answers', ['guid' => $step->interview->interview]) }}">
                                                                    <i class="fa fa-handshake-o"></i>&nbsp;Entrevistas
                                                                </a>
                                                                <a class="btn btn-success sm-b"
                                                                    href="{{ route('video-interviews.update', ['guid' => $step->interview->interview]) }}">
                                                                    <i class="fa fa-handshake-o"></i>&nbsp;Video Entrevista
                                                                </a>
                                                            @else
                                                                <a class="btn btn-success sm-b"
                                                                    href="{{ route('video-interviews', ['id' => $step->id]) }}">
                                                                    <i class="fa fa-handshake-o"></i>&nbsp;Video Entrevista
                                                                </a>
                                                            @endif
                                                        @break

                                                        @default
                                                    @endswitch
                                                </div>
                                                <div class="clearfix">
                                                </div>
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
</div>

<script>
    document.addEventListener('livewire:load', function() {
        var el = document.getElementById('sortable-list');
        var sortable = Sortable.create(el, {
            animation: 150,
            onEnd: function( /**Event*/ evt) {
                var order = sortable.toArray();
                @this.call('updateOrder', order);
            }
        });
    });
</script>

<style>
    #sortable-list {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
    }

    .sortable-item {
        flex: 0 0 auto;
        width: 30%;
        margin-right: 10px;
    }
</style>
