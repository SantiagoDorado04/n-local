<div>
    @include('livewire.admin.commercial-forms.modals-forms.create')
    @include('livewire.admin.commercial-forms.modals-forms.edit')
    @include('livewire.admin.commercial-forms.modals-forms.delete')
    @include('livewire.admin.commercial-forms.modals-forms.show')

    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li>
            Formularios
        </li>
    </ol>
    @endsection

    @section('page_title', 'Formularios Widgets | '.setting('admin.title'))

    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            @if ($val==1)
            <i class="voyager-news"></i> Caracterización de empresas
            @else
            <i class="voyager-news"></i> Formularios Widgets 
            @endif
            
        </h1>
        <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal">
            <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
        </button>
    </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <label><strong>Buscar formulario:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName" placeholder="Formulario widget">
                                <hr>
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            
                        </div>
                        <div class="row no-margin-bottom">
                            @foreach ($forms as $form)
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="panel panel-info" style="height:240px !important">
                                    <div class="panel-heading panel-heading-custom">
                                        <h5 class="panel-title-custom">
                                            {{ Str::limit($form->name, 26) }}
                                            <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                    data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                                <ul class="dropdown-menu">
                                                    <li><a data-toggle="modal" data-target="#edit-modal"
                                                            wire:click="edit({{ $form->id }})"><i
                                                                class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                    <li><a data-toggle="modal" data-target="#delete-modal"
                                                            wire:click="delete({{ $form->id }})"><i
                                                                class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </h5>
                                    </div>
                                    
                                    <button style="background-color: #fff; border:0px; margin:0px; padding:0px" data-toggle="modal" data-target="#show-modal"
                                    wire:click="show({{ $form->id }})">
                                    <div class="panel-body" style="height:100px">
                                        <p style="text-align: justify;
                                        text-justify: inter-word;">{{ Str::limit($form->description, 150) }}</p>
                                    </div>
                                    </button>
                                    <div class="panel-footer">
                                        <div class="pull-right">
                                            <a href="{{ route('commercial.form-preview', ['form' => $form->id]) }}"
                                                class="btn btn-warning sm-b" target="_blank"><i class="fa fa-wpforms"></i>&nbsp;Demo</a>
                                            <a href="{{ route('commercial.form-action', ['form' => $form->id]) }}"
                                                class="btn btn-primary sm-b"><i class="fa fa-rocket"></i>&nbsp;Acciones</a>
                                            <a href="{{ route('commercial.questions', ['form' => $form->id]) }}"
                                                class="btn btn-success sm-b"><i class="fa fa-question"></i>&nbsp;Preguntas</a>
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
                            <div class="col-lg-6 text-right">
                                {{ $forms->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>