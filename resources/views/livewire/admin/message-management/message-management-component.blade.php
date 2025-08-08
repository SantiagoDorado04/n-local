<div>
    @include('livewire.admin.message-management.modals.show')
    @include('livewire.admin.message-management.modals.create')
    @include('livewire.admin.message-management.modals.edit')
    @include('livewire.admin.message-management.modals.delete')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>Gest. Mensajes</li>
        </ol>
    @endsection

    @section('page_title', 'Gest. Mensajes | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-envelope"></i>&nbsp;Gestión de mensajes de valor para contacto
            </h1>
            <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal">
                <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
            </button>
        </div>
    @stop
    @if ($action != '')
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
    @endif

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <label><strong>Buscar mensaje:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Título del mensaje">
                            </div>
                            @if ($action == '')
                            <div class="col-lg-4">
                                <label><strong>Tipo:</strong></label>
                                <select class="form-control" wire:model='searchType'>
                                    <option value="">Seleccionar</option>
                                    <option value="g">Generales</option>
                                    <option value="a">Acción comercial</option>
                                </select>
                            </div>
                            
                            @if ($searchType == 'a')
                                <div class="col-lg-4" {{-- wire:ignore --}}>
                                    <label><strong>Terreno comercial:</strong></label>
                                    <br>
                                    <select class="form-control" wire:model="landId" id="landId">
                                        <option value="">Seleccionar</option>
                                        @foreach ($lands as $land)
                                            <option value="{{ $land->id }}">{{ $land->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label><strong>Estrategia comercial:</strong></label>
                                    <br>
                                    <select class="form-control" wire:model="strategyId" id="strategyId">
                                        <option value="" selected>Seleccionar</option>
                                        @foreach ($strategies as $strategy)
                                            <option value="{{ $strategy->id }}">{{ $strategy->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label><strong>Acción comercial:</strong></label>
                                    <br>
                                    <select class="form-control" wire:model="actionId" id="actionId">
                                        <option value="" selected>Seleccionar</option>
                                        @foreach ($actions as $action)
                                            <option value="{{ $action->id }}">{{ $action->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            @endif
                        </div>
                        <div class="row no-margin-bottom">
                            @foreach ($messages as $message)
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($message->title, 55) }}
                                                <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                    <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                        data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-toggle="modal" data-target="#edit-modal"
                                                                wire:click="edit({{ $message->id }})"><i
                                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                        <li><a data-toggle="modal" data-target="#delete-modal"
                                                                wire:click="delete({{ $message->id }})"><i
                                                                    class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </h5>
                                        </div>
                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                            data-toggle="modal" data-target="#show-modal"
                                            wire:click="show({{ $message->id }})">
                                            <div class="panel-body" style="height:150px">
                                                <p
                                                    style="text-align: justify;
                                        text-justify: inter-word;">
                                                    {{ Str::limit($message->message, 240) }}
                                                    <br>
                                                    <br>
                                                    @if ($message->commercial_action_name != '')
                                                        <b>Acción Comercial: </b>{{ $message->commercial_action_name }}
                                                    @endif
                                                </p>
                                            </div>
                                        </button>
                                        <div class="panel-footer">
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
@push('javascript')
    <script>
        window.initSelect2 = () => {
            jQuery("#landId").select2({
                theme: "bootstrap"
            });

            jQuery("#strategyId").select2({
                theme: "bootstrap"
            });

            jQuery("#actionId").select2({
                theme: "bootstrap"
            });

            jQuery("#landId").on('change', function(e) {
                var data = $('#landId').select2("val");
                @this.set('landId', data);
            });

            jQuery("#strategyId").on('change', function(e) {
                var data = $('#strategyId').select2("val");
                @this.set('strategyId', data);
            });

            jQuery("#actionId").on('change', function(e) {
                var data = $('#actionId').select2("val");
                @this.set('actionId', data);
            });
        }

        initSelect2();

        window.livewire.on('select2', () => {
            initSelect2();
        });
    </script>
@endpush
