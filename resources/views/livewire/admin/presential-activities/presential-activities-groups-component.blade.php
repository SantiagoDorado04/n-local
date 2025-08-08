<div>
    @include('livewire.admin.presential-activities.modals-groups.show')
    @include('livewire.admin.presential-activities.modals-groups.create')
    @include('livewire.admin.presential-activities.modals-groups.edit')
    @include('livewire.admin.presential-activities.modals-groups.delete')

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
                <a href="{{ route('stages', ['id' => $presentialActivity->step->stage->process_id]) }}">Etapas</a>
            </li>
            <li>
                <a href="{{ route('steps', ['id' => $presentialActivity->step->stage->id]) }}">Pasos</a>
            </li>
            <li>
                <a href="{{ route('presential-activities', ['id' => $presentialActivity->step->id]) }}">Actividades
                    presenciales</a>
            </li>
            <li>
                Grupos actividades presenciales
            </li>
        </ol>
    @endsection

    @section('page_title', 'Grupos | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-news"></i> Grupos
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
                        <ul>
                            <li><strong>Proceso:</strong> {{ $presentialActivity->step->stage->process->name }}</li>
                            <li><strong>Etapa:</strong> {{$presentialActivity->step->stage->name }}</li>
                            <li><strong>Paso:</strong> {{ $presentialActivity->step->name }}</li>
                            <li><strong>Actividades presenciales:</strong> {{$presentialActivity->name }}</li>
                        </ul>
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
                            @foreach ($groups as $group)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="panel panel-info" style="height:240px !important">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($group->name, 26) }}
                                                <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                    <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                        data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-toggle="modal" data-target="#edit-modal"
                                                                wire:click="edit({{ $group->id }})"><i
                                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                        <li><a data-toggle="modal" data-target="#delete-modal"
                                                                wire:click="delete({{ $group->id }})"><i
                                                                    class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </h5>
                                        </div>

                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                            data-toggle="modal" data-target="#show-modal"
                                            wire:click="show({{ $group->id }})">
                                            <div class="panel-body" style="height:100px">
                                                <p
                                                    style="text-align: justify;
                                        text-justify: inter-word;">
                                                    <strong>Cupo:
                                                    </strong>{{ $group->quota }}
                                                </p>
                                                <p
                                                    style="text-align: justify;
                                        text-justify: inter-word;">
                                                    <strong>Fecha:
                                                    </strong>{{ $group->date }}
                                                </p>
                                            </div>
                                        </button>

                                        <div class="panel-footer">
                                            <div class="pull-right">
                                                <a href="{{ route('presential-activities-groups.participants', ['id' => $group->id]) }}"
                                                    class="btn btn-success sm-b"><i
                                                        class="fa fa-question"></i>&nbsp;Asistentes</a>
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
