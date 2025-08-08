<div>

    @include('livewire.admin.self-management.modals-metodologies.create')
    @include('livewire.admin.self-management.modals-metodologies.edit')
    @include('livewire.admin.self-management.modals-metodologies.delete')
    @include('livewire.admin.self-management.modals-metodologies.show')


    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard')}}"><i class="voyager-boat"></i> {{ __('voyager::generic.dashboard')
                }}</a>
        </li>
        <li><a href="{{ route('self-management') }}">Pathway Autogestión</a></li>
        <li class="active">
            <a href="{{ route('projects',['announcement'=>$announcement->id])}}"> Proyectos</a>
        </li>
        <li class="active">
            <a href="{{ route('problems',['project'=>$project->id])}}"> Problemas</a>
        </li>
        <li><a href="{{ route('solutions',['problem'=>$problem->id]) }}">Soluciones</a></li>
        <li>Metodologías</li>
    </ol>
    @endsection

    @section('page_title', 'Metodología | '.setting('admin.title'))

    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-company"></i>&nbsp;<b>Proyecto '{{ $project->title ?? '' }}' - </b> Metodologías
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
                            <li><strong>Proyecto: </strong> {{ $project->title }}<br></li>
                            <li><strong>Problema: </strong> {{ $problem->title }}<br></li>
                            <li><strong>Solucion: </strong> {{ $solution->title }}<br></li>
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
                                <label><strong>Buscar metodología:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName" placeholder="Metodología">
                                <hr>
                            </div>
                            @foreach ($metodologies as $metodology)
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading panel-heading-custom">
                                        <h5 class="panel-title-custom">
                                            {{ Str::limit($metodology->title, 26) }}
                                            <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                    data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                                <ul class="dropdown-menu">
                                                    <li><a data-toggle="modal" data-target="#edit-modal"
                                                            wire:click="edit({{ $metodology->id }})"><i
                                                                class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                    <li><a data-toggle="modal" data-target="#delete-modal"
                                                            wire:click="delete({{ $metodology->id }})"><i
                                                                class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a></li>
                                                </ul>
                                            </div>
                                        </h5>
                                    </div>
                                    <button style="background-color: #fff; border:0px; margin:0px; padding:0px" data-toggle="modal" data-target="#show-modal"
                                    wire:click="show({{ $metodology->id }})">
                                    <div class="panel-body" style="height:120px">
                                        <p style="  text-align: justify;
                                        text-justify: inter-word;">{{ Str::limit($metodology->description, 150) }}</p>
                                    </div>
                                    </button>
                                    <div class="panel-footer">
                                        <div class="pull-right">
                                            <a class="btn btn-success"
                                                href="{{ route('indicators',['metodology'=>$metodology->id]) }}"><i
                                                    class="voyager-puzzle"></i> Indicadores</a>
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
