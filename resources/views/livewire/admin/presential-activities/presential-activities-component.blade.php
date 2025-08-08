<div>
    @include('livewire.admin.presential-activities.modals.show')
    @include('livewire.admin.presential-activities.modals.create')
    @include('livewire.admin.presential-activities.modals.edit')
    @include('livewire.admin.presential-activities.modals.delete')

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
                <a href="{{ route('steps', ['id' => $step->stage->id]) }}">Pasos</a>
            </li>
            <li>
                Actividades presenciales
            </li>
        </ol>
    @endsection

    @section('page_title', 'Actividades presenciales | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-handshake-o"></i> Actividades Presenciales
            </h1>
            <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal">
                <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
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
                                <label><strong>Buscar Actividad presencial:</strong></label>
                                <input type="text" class="form-control mb-2" wire:model="searchName"
                                    placeholder="Actividad presencial">
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            @foreach ($presentialActivities as $presentialActivity)
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($presentialActivity->name, 26) }}
                                                <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                    <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                        data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-toggle="modal" data-target="#edit-modal"
                                                                wire:click="edit({{ $presentialActivity->id }})"><i
                                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                        <li><a data-toggle="modal" data-target="#delete-modal"
                                                                wire:click="delete({{ $presentialActivity->id }})"><i
                                                                    class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </h5>
                                        </div>

                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px; width:100%"
                                            data-toggle="modal" data-target="#show-modal"
                                            wire:click="show({{ $presentialActivity->id }})">
                                            <div class="panel-body" style="height:190px">
                                                <ul class="list-group list-group-flush" style="width: 100%;">
                                                    <li class="list-group-item">
                                                        <p style="text-align: justify; text-justify: inter-word;">
                                                        <strong>Actividad: </strong>
                                                        {{ $presentialActivity->name }}
                                                        </p>
                                                    </li>
                                            
                                                    <li class="list-group-item">
                                                        <p style="text-align: justify; text-justify: inter-word;">
                                                        <strong>Facilitador: </strong>
                                                        {{ $presentialActivity->facilitator }}
                                                        </p>
                                                    </li>

                                                    @php
                                                        $eventType = $presentialActivity->event_type;
                                                        switch ($eventType) {
                                                            case 'presential':
                                                                $eventType = 'Presencial';
                                                                break;
                                                            case 'virtual':
                                                                $eventType = 'Virtual';
                                                                break;
                                                            default:
                                                                $eventType = 'No definido';
                                                                break;
                                                        }
                                                    @endphp

                                                    <li class="list-group-item">
                                                        <p style="text-align: justify; text-justify: inter-word;">
                                                        <strong>Tipo de actividad: </strong>
                                                        {{ $eventType }}
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </button>

                                        <div class="panel-footer" style="height: 60px">
                                            <div class="pull-right">
                                                <a href="{{ route('presential-activities-groups', ['id' => $presentialActivity->id]) }}"
                                                    class="btn btn-success sm-b"><i
                                                        class="fa fa-users"></i>&nbsp;Grupos</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-lg-6" style="padding-top:22px">
                                <span>{!! $paginationText !!}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
