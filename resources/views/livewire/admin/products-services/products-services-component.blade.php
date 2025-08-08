<div>
    @include('livewire.admin.products-services.modals.create')
    @include('livewire.admin.products-services.modals.edit')
    @include('livewire.admin.products-services.modals.delete')
    @include('livewire.admin.products-services.modals.show')


    @include('livewire.admin.products-services.modals-files.edit')
    @include('livewire.admin.products-services.modals-files.delete')

    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard')}}"><i class="voyager-boat"></i> {{ __('voyager::generic.dashboard')
                }}</a>
        </li>
        <li>Productos y servicios</li>
    </ol>
    @endsection

    @section('Productos y servicios', 'Terrenos Comerciales | '.setting('admin.title'))

    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="fa fa-briefcase"></i>&nbsp;Productos y servicios
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
                                <label><strong>Buscar producto / servicio:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName" placeholder="Producto / Servicio">
                                <hr>
                            </div>
                            @foreach ($products as $product)
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading panel-heading-custom">
                                        <h5 class="panel-title-custom">
                                            {{ Str::limit($product->name, 26) }}
                                            <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                    data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                                <ul class="dropdown-menu">
                                                    <li><a data-toggle="modal" data-target="#edit-modal"
                                                            wire:click="edit({{ $product->id }})"><i
                                                                class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                    <li><a data-toggle="modal" data-target="#delete-modal"
                                                            wire:click="delete({{ $product->id }})"><i
                                                                class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a></li>
                                                </ul>
                                            </div>
                                        </h5>
                                    </div>
                                    <button style="background-color: #fff; border:0px; margin:0px; padding:0px" data-toggle="modal" data-target="#show-modal"
                                    wire:click="show({{ $product->id }})">
                                    <div class="panel-body text-left">
                                        <li><strong>Descripción:</strong></li>
                                        <span>&ensp;{{ $product->description }}</span>
                                        <li><strong>Clientes / beneficiarios actuales y proyecciones:</strong></li>
                                        <p style="  text-align: justify;
                                        text-justify: inter-word;">{{ Str::limit($product->beneficiaries, 150) }}</p>
                                        <li><strong>Nivel de desarrollo:</strong></li>
                                        &ensp;{{ $product->developmentLevel->name }}
                                    </div>
                                    </button>
                                    <div class="panel-footer">
                                        <div class="pull-right">
                                            <button class="btn btn-primary"  data-toggle="modal" data-target="#edit-modal-2" wire:click='files({{ $product->id }})'><i class="fa fa-cloud-upload"></i>&nbsp;Adjuntos</button>
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
