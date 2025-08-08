<div>
    @include('livewire.admin.commercial-action.modals.create')
    @include('livewire.admin.commercial-action.modals.edit')
    @include('livewire.admin.commercial-action.modals.delete')
    @include('livewire.admin.commercial-action.modals.show')

    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard')}}"><i class="voyager-boat"></i> {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li>
            <a href="{{ route('commercial.lands')}}">Terrenos</a>
        </li>
        <li>
            <a href="{{ route('commercial.strategies',['land'=>$land->id])}}">Estrategias</a>
        </li>
        <li>
            Acciones
        </li>
    </ol>
    @endsection

    @section('page_title', 'Acciones Comerciales | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-rocket"></i>&nbsp;<b>Estimulación de la demanda - </b>Acciones Comerciales
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
                            <li><strong>Terreno Comercial: </strong> {{ $land->name }}<br></li>
                            <li><strong>Estrategia: </strong> {{ $strategy->name }}<br></li>
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
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <label><strong>Buscar acción comercial:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName" placeholder="Acción comercial">
                                <hr>
                            </div>
                            @foreach ($actions as $action)
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="panel panel-info">
                                    <div class="panel-heading panel-heading-custom">
                                        <h5 class="panel-title-custom">
                                            {{ Str::limit($action->name, 26) }}
                                            <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                <button class="btn btn-link dropdown-toggle" style="color:#fff" data-toggle="dropdown"><i
                                                        class="fa fa-ellipsis-v"></i></button>
                                                <ul class="dropdown-menu">
                                                    <li><a data-toggle="modal" data-target="#edit-modal" wire:click="edit({{ $action->id }})"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                    <li><a  data-toggle="modal" data-target="#delete-modal" wire:click="delete({{ $action->id }})"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a></li>
                                                </ul>
                                            </div>
                                        </h5>
                                    </div>
                                    <button style="background-color: #fff; border:0px; margin:0px; padding:0px" data-toggle="modal" data-target="#show-modal"
                                    wire:click="show({{ $action->id }})">
                                    <div class="panel-body" style="height:120px">
                                        <p style="  text-align: justify;
                                        text-justify: inter-word;">{{ Str::limit($action->description, 150) }}</p>
                                    </div>
                                    </button>
                                    <div class="panel-footer">
                                        <div class="pull-right">
                                            <a class="btn btn-primary" href="{{ route('commercial.actions.messages', ['action' => $action->id]) }}">
                                                <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;Plantillas Mensajes
                                            </a>
                                            <a class="btn btn-success" href="{{ route('commercial.actions.questions', ['action' => $action->id]) }}">
                                                <i class="fa fa-question" aria-hidden="true"></i>&nbsp;Preguntas Ingeniería Social
                                            </a>
                                            
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
