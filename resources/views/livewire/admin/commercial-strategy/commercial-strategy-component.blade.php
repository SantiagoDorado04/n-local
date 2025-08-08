<div>
    @include('livewire.admin.commercial-strategy.modals.create')
    @include('livewire.admin.commercial-strategy.modals.edit')
    @include('livewire.admin.commercial-strategy.modals.delete')
    @include('livewire.admin.commercial-strategy.modals.show')

    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard')}}"><i class="voyager-boat"></i> {{ __('voyager::generic.dashboard')
                }}</a>
        </li>
        <li>
            <a href="{{ route('commercial.lands')}}">Terrenos</a>
        </li>
        <li>
            Estrategias
        </li>
    </ol>
    @endsection

    @section('page_title', 'Estrategias Comerciales | '.setting('admin.title'))

    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-puzzle"></i>&nbsp;<b>Definición de estrategia - </b>Estrategias Comerciales
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
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content browse container-fluid" >
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <label><strong>Buscar estrategia comercial:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName" placeholder="Estrategia comercial">
                                <hr>
                            </div>
                            @foreach ($strategies as $strategy)
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="panel panel-info">
                                    <div class="panel-heading panel-heading-custom">
                                        <h5 class="panel-title-custom">
                                            {{ Str::limit($strategy->name, 26) }}
                                            <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                    data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                                <ul class="dropdown-menu">
                                                    <li><a data-toggle="modal" data-target="#edit-modal"
                                                            wire:click="edit({{ $strategy->id }})"><i
                                                                class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                    <li><a data-toggle="modal" data-target="#delete-modal"
                                                            wire:click="delete({{ $strategy->id }})"><i
                                                                class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a></li>
                                                </ul>
                                            </div>
                                        </h5>
                                    </div>
                                    <button style="background-color: #fff; border:0px; margin:0px; padding:0px" data-toggle="modal" data-target="#show-modal"
                                    wire:click="show({{ $strategy->id }})">
                                    <div class="panel-body" style="height:120px">
                                        <p style="  text-align: justify;
                                        text-justify: inter-word;">{{ Str::limit($strategy->description, 150) }}</p>
                                    </div>
                                    </button>
                                    <div class="panel-footer">
                                        <div class="pull-right">
                                            <a class="btn btn-success"
                                                href="{{ route('commercial.actions',['strategy'=>$strategy->id]) }}">
                                                <i class="voyager-rocket"></i> Acciones
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