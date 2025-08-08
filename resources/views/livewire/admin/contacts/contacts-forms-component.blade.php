<div>

    @include('livewire.admin.contacts.modals-assign.info')
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('commercial.contacts-cloud') }}">Empresas</a>
            </li>
            <li>
                Formularios Asignados
            </li>
        </ol>
    @endsection

    @section('page_title', 'Formularios asignados | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-wpforms"></i>&nbsp;Formularios asignados
            </h1>
        </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-10">
                                <div class="form-group">
                                    <label><strong>Token formulario:</strong></label>
                                    <input type="text" class="form-control" wire:model="token"
                                        wire:keydown.enter="validateToken()">
                                    @error('token')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-2" style="padding-top:22px">
                                <div class="form-group">
                                    <button class="btn btn-primary" wire:click="validateToken()"><i
                                            class="fa fa-check-square"></i>&nbsp;Validar</button>
                                </div>
                            </div>
                        </div>
                        @if ($form != [])
                            <div class="row no-margin-bottom">
                                <div class="col-md-12">
                                    <div class="panel panel-bordered">
                                        <div class="panel-body">
                                            <div class="row no-margin-bottom">
                                                <div class="col-lg-3">
                                                    <li><strong>Formulario:</strong> {{ $form->commercialForm->name }}
                                                    </li>
                                                </div>
                                                <div class="col-lg-3">
                                                    <li><strong>Acción:</strong> {{ $form->commercialAction->name }}
                                                    </li>
                                                </div>
                                                <div class="col-lg-3">
                                                    <li><strong>Estrategia:</strong>
                                                        {{ $form->commercialAction->commercialStrategy->name }}</li>
                                                </div>
                                                <div class="col-lg-3">
                                                    <li><strong>Terreno Comercial:</strong>
                                                        {{ $form->commercialAction->commercialStrategy->commercialLand->name }}
                                                    </li>
                                                </div>
                                            </div>
                                            <div class="row no-margin-bottom">
                                                <div class="col-lg-12 text-center">
                                                    <button class="btn btn-warning sm-b" data-toggle="modal"
                                                        data-target="#info-modal"><i
                                                            class="fa fa-wpforms"></i>&nbsp;Formulario</button>
                                                    <button class="btn btn-success sm-b" wire:click="assign()"><i
                                                            class="fa fa-check-square"></i>&nbsp;Asignar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row no-margin-bottom">
                            @foreach ($contact->assignedForms as $form)
                                <div class="col-lg-4">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($form->commercialFormAction->commercialForm->name, 26) }}
                                                <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                    <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                        data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-toggle="modal" data-target="#edit-modal"
                                                                wire:click="edit({{ $form->id }})"><i
                                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                        <li><a data-toggle="modal" data-target="#delete-modal"
                                                                wire:click="delete({{ $form->id }})"><i
                                                                    class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a></li>
                                                    </ul>
                                                </div>
                                            </h5>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row no-margin-bottom">
                                                <div div class="col-lg-12" style="padding:20px">
                                                    <li><strong>Formulario:</strong>
                                                        {{ $form->commercialFormAction->commercialForm->name }}</li>
                                                    <li><strong>Acción:</strong>
                                                        {{ $form->commercialFormAction->commercialAction->name }}</li>
                                                    <li><strong>Estrategia:</strong>
                                                        {{ $form->commercialFormAction->commercialAction->commercialStrategy->name }}
                                                    </li>
                                                    <li><strong>Terreno Comercial:</strong>
                                                        {{ $form->commercialFormAction->commercialAction->commercialStrategy->commercialLand->name }}
                                                    </li>
                                                </div>
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
