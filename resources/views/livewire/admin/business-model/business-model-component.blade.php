<div>

    @include('livewire.admin.business-model.modals.create')
    @include('livewire.admin.business-model.modals.edit')
    @include('livewire.admin.business-model.modals.delete')
    @include('livewire.admin.business-model.modals.show')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>Modelos de negocio</li>
        </ol>
    @endsection

    @section('Modelos de negocio', 'Terrenos Comerciales | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-sitemap"></i>&nbsp;Modelos de negocio
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
                                <label><strong>Buscar modelo de negocio:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Modelo de negocio">
                                <hr>
                            </div>
                            @foreach ($models as $model)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($model->name, 26) }}
                                                <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                    <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                        data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-toggle="modal" data-target="#edit-modal"
                                                                wire:click="edit({{ $model->id }})"><i
                                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                        <li><a data-toggle="modal" data-target="#delete-modal"
                                                                wire:click="delete({{ $model->id }})"><i
                                                                    class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </h5>
                                        </div>
                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                            data-toggle="modal" data-target="#show-modal"
                                            wire:click="show({{ $model->id }})">
                                            <div class="panel-body text-left" style="height:420px; padding-top:0px">
                                                <di class="row no-margin-bottom">
                                                    <div class="col-lg-12">
                                                        <li><strong>Descripción:</strong></li>
                                                        <span>&ensp;{{ $model->description }}</span>
                                                        <hr style="margin:8px; padding:0px">
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <li><strong>Fuente de ingresos:</strong></li>
                                                        <p style=" text-align: justify; text-justify: inter-word;">
                                                            {{ Str::limit($model->source_income, 150) }}
                                                        </p>
                                                        <hr style="margin:8px; padding:0px">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <li><strong>B2B:</strong></li>
                                                        &ensp;{{ $model->b2b . ' %' }}
                                                        <hr style="margin:8px; padding:0px">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <li><strong>B2C:</strong></li>
                                                        &ensp;{{ $model->b2c . ' %' }}
                                                        <hr style="margin:8px; padding:0px">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <li><strong>B2G:</strong></li>
                                                        &ensp;{{ $model->b2g . ' %' }}
                                                        <hr style="margin:8px; padding:0px">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <li><strong>Ingresos mensuales:</strong></li>
                                                        &ensp;{{ $model->income }}
                                                        <hr style="margin:8px; padding:0px">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <li><strong>Gastos mensuales:</strong></li>
                                                        &ensp;{{ $model->bills }}
                                                        <hr style="margin:8px; padding:0px">
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <li><strong>Plan de negocios:</strong></li>
                                                        @if ($model->business_plan != '')
                                                            &ensp;<a class="btn btn-success sm-b"
                                                                href="{{ url('storage/' . substr($model->business_plan, 7)) }}"
                                                                target="_blank"><i
                                                                    class="fa fa-cloud-download"></i>&nbsp;Descargar</a>
                                                        @else
                                                            &ensp;No se ha cargado
                                                        @endif
                                                    </div>
                                                </di>
                                            </div>
                                        </button>
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
