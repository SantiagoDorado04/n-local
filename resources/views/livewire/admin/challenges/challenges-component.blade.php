<div>

    @include('livewire.admin.challenges.modals.create')
    @include('livewire.admin.challenges.modals.edit')
    @include('livewire.admin.challenges.modals.delete')
    @include('livewire.admin.challenges.modals.show')

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
            <li>
                Retos - Entregables
            </li>
        </ol>
    @endsection

    @section('page_title', 'Retos - Entregables | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-cloud-upload"></i>&nbsp;Retos - Entregables
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
                                <label><strong>Buscar reto / entregable:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Retos / entregable">
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            @foreach ($challenges as $challenge)
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($challenge->title, 26) }}
                                                <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                    <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                        data-toggle="dropdown" title="Opciones"><i
                                                            class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-toggle="modal" data-target="#edit-modal"
                                                                wire:click="edit({{ $challenge->id }})"><i
                                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a>
                                                        </li>
                                                        <li><a data-toggle="modal" data-target="#delete-modal"
                                                                wire:click="delete({{ $challenge->id }})"><i
                                                                    class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </h5>
                                        </div>
                                        <button
                                            style="background-color: #fff; border:0px; margin:0px; padding:0px; width:100%"
                                            data-toggle="modal" data-target="#show-modal"
                                            wire:click="show({{ $challenge->id }})" title="Clic para ver mas detalles">
                                            <div class="panel-body" style="height:180px">
                                                <ul class="list-group list-group-flush" style="width: 100%;">
                                                    <li class="list-group-item">
                                                        <p
                                                            style="text-align: justify; text-justify: inter-word; margin:0px">
                                                            <strong>Reto / Entregable:
                                                            </strong>{{ Str::limit($challenge->title, 150) }}
                                                        </p>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <p
                                                            style="text-align: justify; text-justify: inter-word; margin:0px">
                                                            <strong>Instrucción:
                                                            </strong>{{ Str::limit($challenge->instructions, 150) }}
                                                        </p>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <p
                                                            style="text-align: justify; text-justify: inter-word; margin:0px">
                                                            <strong>Fecha de Entrega:
                                                            </strong>{{ $challenge->delivery_date }}
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </button>
                                        <div class="panel-footer">
                                            <div class="pull-right">
                                                <a class="btn btn-success sm-b"
                                                    href="{{ route('challenges.files', ['id' => $challenge->id]) }}"
                                                    title="Ver respuestas"><i
                                                        class="fa fa-cloud-upload"></i>&nbsp;Respuestas</a>
                                            </div>
                                            <div class="clearfix">
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
