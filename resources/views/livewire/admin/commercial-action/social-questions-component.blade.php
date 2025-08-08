<div>
    
    @include('livewire.admin.social-engineering.modals-config.create')
    @include('livewire.admin.social-engineering.modals-config.edit')
    @include('livewire.admin.social-engineering.modals-config.delete')
    
    @section('page_title', 'Preguntas Ingeniería Social | '.setting('admin.title'))

    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="fa fa-question"></i>&nbsp;Preguntas Ingeniería Social
        </h1>
        <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal">
            <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
        </button>
    </div>
    @stop

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
            <a href="{{ route('commercial.actions',['strategy'=>$strategy->id])}}">Acciones</a>
        </li>
        <li>
            Preguntas Ingeniería Social
        </li>
    </ol>
    @endsection

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin-bottom:0px">
                    <div class="panel-body" style="margin-bottom:0px">
                        <ul>
                            <li><strong>Terreno Comercial: </strong> {{ $land->name }}<br></li>
                            <li><strong>Estrategia Comercial: </strong> {{ $strategy->name }}<br></li>
                            <li><strong>Acción Comercial: </strong> {{ $action->name }}<br></li>
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
                            @foreach ($questions as $question)
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading {{ $question->visibility == '1' ? 'panel-heading-custom' : 'panel-heading-default-custom' }}">
                                        <h5 class="{{ $question->visibility == '1' ? 'panel-title-custom' : 'panel-title-default-custom' }}">
                                            Pregunta #{{ $loop->iteration }}
                                            <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                    data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                                <ul class="dropdown-menu">
                                                    <li><a data-toggle="modal" data-target="#edit-modal"
                                                            wire:click="edit({{ $question->id }})"><i
                                                                class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                    <li><a data-toggle="modal" data-target="#delete-modal"
                                                            wire:click="delete({{ $question->id }})"><i
                                                                class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </h5>
                                    </div>
                                    <div class="panel-body" style="margin-top:20px">
                                        {{ $question->question }}
                                    </div>
                                    <div class="panel-footer">
                                        
                                        <br>
                                        <span><strong>Visibilidad:</strong>
                                            {{ $question->visibility == '1' ? 'Visible' : 'Oculta' }}
                                        </span>
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
