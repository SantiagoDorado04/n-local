<div>
    @include('livewire.admin.social-engineering.modals-config.create')
    @include('livewire.admin.social-engineering.modals-config.edit')
    @include('livewire.admin.social-engineering.modals-config.delete')
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>Preguntas Ingeniería Social</li>
        </ol>
    @endsection

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
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin: 0px">
                    <div class="panel-body" style="margin: 0px">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-6">
                                <label><strong>Buscar pregunta:</strong></label>
                                <input type="text" class="form-control" wire:model="searchQuestion"
                                    placeholder="Texto de la pregunta">
                            </div>
                            <div class="col-lg-3">
                                <label><strong>Visibilidad:</strong></label>
                                <select class="form-control" wire:model="searchVisibility">
                                    <option value="">Seleccionar</option>
                                    <option value="1">Visibles</option>
                                    <option value="0">Ocultas</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label><strong>Tipo de pregunta:</strong></label>
                                <select class="form-control" wire:model="searchType">
                                    <option value="">Seleccionar</option>
                                    <option value="g">Generales</option>
                                    <option value="a">Acción Comercial</option>
                                </select>
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            @if ($searchType == 'a')
                                <div class="col-lg-4" wire:ignore>
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            @foreach ($questions as $question)
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div
                                            class="panel-heading {{ $question->visibility == '1' ? 'panel-heading-custom' : 'panel-heading-default-custom' }}">
                                            <h5
                                                class="{{ $question->visibility == '1' ? 'panel-title-custom' : 'panel-title-default-custom' }}">
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
                                            <span><strong>Visibilidad:</strong>
                                                {{ $question->visibility == '1' ? 'Visible' : 'Oculta' }}
                                            </span>
                                            <br>
                                            @if ($question->commercial_action_id != '')
                                                <span><strong>Acción Comercial:</strong>
                                                    {{ $question->action_name }}
                                                </span>
                                                <br>
                                                <span><strong>Estrategia Comercial:</strong>
                                                    {{ $question->strategy_name }}
                                                </span>
                                                <br>
                                                <span><strong>Terreno Comercial:</strong>
                                                    {{ $question->land_name }}
                                                </span>
                                            @endif
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
