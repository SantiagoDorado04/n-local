<div>
    @include('livewire.admin.commercial-forms.modals-actions.delete')
    @include('livewire.admin.commercial-forms.modals-actions.info')
    @include('livewire.admin.commercial-forms.modals-actions.token')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('commercial.forms') }}">Formularios</a>
            </li>
            <li>Acciones</li>
        </ol>
    @endsection

    @section('page_title', ' Acciones Formularios | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-rocket"></i> Acciones Formulario
            </h1>
        </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin: 0px">
                    <div class="panel-body" style="margin: 0px">
                        <ul>
                            <li><strong>Formulario: </strong> {{ $form->name }}<br></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin: 0px">
                    <div class="panel-body" style="margin: 0px">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <h5>Relacionar formulario a acción comercial:</h5>
                            </div>
                            <div class="col-lg-4" wire:ignore>
                                <label><strong>Terreno comercial:</strong></label>
                                <select class="form-control" wire:model="landId" id="landId">
                                    <option value="">Seleccionar</option>
                                    @foreach ($lands as $land)
                                        <option value="{{ $land->id }}">{{ $land->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label><strong>Estrategia comercial:</strong></label>
                                <select class="form-control" wire:model="strategyId" id="strategyId">
                                    <option value="" selected>Seleccionar</option>
                                    @foreach ($strategies as $strategy)
                                        <option value="{{ $strategy->id }}">{{ $strategy->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label><strong>Acción comercial:</strong></label>
                                <select class="form-control" wire:model="actionId" id="actionId">
                                    <option value="" selected>Seleccionar</option>
                                    @foreach ($actions as $action)
                                        <option value="{{ $action->id }}">{{ $action->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12 text-center">
                                @if ($actionId != '')
                                    <button class="btn btn-success" wire:click="store()"><i class="fa fa-plus-square"></i>&nbsp;Agregar</button>
                                @endif
                            </div>
                        </div>
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
                            @foreach ($actionsForms as $actionForm)
                                <div class="col-md-12">
                                    <div class="panel panel-info">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ $actionForm->action_name }}
                                                <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                    <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                        data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-toggle="modal" data-target="#delete-modal"
                                                                wire:click="delete({{ $actionForm->action_form_id }})"><i
                                                                    class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </h5>
                                        </div>
                                        <div class="panel-body" style="margin-top:20px">
                                            <div class="row no-margin-bottom">
                                                <div class="col-lg-12">
                                                    {{ $actionForm->form_description }}
                                                </div>
                                                <div class="col-lg-12">
                                                    <ul>
                                                        <li><strong>Terreno Comercial: </strong>
                                                            {{ $actionForm->land_name }}<br></li>
                                                        <li><strong>Estrategia: </strong>
                                                            {{ $actionForm->strategy_name }}<br></li>
                                                        <li><strong>Acción: </strong>
                                                            {{ $actionForm->action_name }}<br></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="pull-right">
                                                <a class="btn btn-primary sm-b"
                                                    href="{{ route('commercial.form-contacts', ['action' => $actionForm->action_form_id]) }}"><i
                                                        class="fa fa-address-card"></i>&nbsp;Contactos</a>
                                                <button class="btn btn-success sm-b" data-toggle="modal"
                                                    data-target="#info-modal"
                                                    wire:click='getLink({{ $actionForm->action_form_id }})'>
                                                    <i class="fa fa-link"></i>
                                                    &nbsp;Enlace Registro
                                                </button>
                                                <button class="btn btn-primary sm-b" data-toggle="modal"
                                                    data-target="#info-modal-2"
                                                    wire:click='getToken({{ $actionForm->action_form_id }})'>
                                                    <i class="fa fa-link"></i>
                                                    &nbsp;Token Asignar
                                                </button>
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
