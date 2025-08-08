<div>

    @include('livewire.admin.announcements.modals-forms.delete')

    <style>
    .select2-container--default .select2-results>.select2-results__options{
        max-height: 500px !important;
    }
    </style>
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('announcements') }}">Convocatorias</a>
            </li>
            <li>Formularios </li>
        </ol>
    @endsection

    @section('page_title', ' Formularios Convocatorias | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-news"></i> Formularios Convocatorias
            </h1>
        </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin: 0px">
                    <div class="panel-body" style="margin: 0px">
                        <ul>
                            <li><strong>Convocatoria: </strong> {{ $announcement->name }}<br></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin: 0px">
                    <div class="panel-body" style="margin: 0px">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <h5>Agregar formulario:</h5>
                            </div>
                            <div class="col-lg-6" wire:ignore>
                                <label><strong>Formulario:</strong></label>
                                <select class="form-control" wire:model="formId" id="formId">
                                    <option value="" selected>Seleccionar</option>
                                    @foreach ($forms as $form)
                                        <option value="{{ $form->id }}">{{ $form->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4" style="margin-top:18px">
                                @if ($formId != '')
                                    <button class="btn btn-success" wire:click="store()">Agregar</button>
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
                            @foreach ($announcementsForms as $announcementForm)
                            <div class="col-md-12">
                                <div class="panel panel-info">
                                    <div class="panel-heading panel-heading-custom">
                                        <h5 class="panel-title-custom">
                                            {{ $announcementForm->form_name }}
                                            <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                <button class="btn btn-link dropdown-toggle" style="color:#fff" data-toggle="dropdown"><i
                                                        class="fa fa-ellipsis-v"></i></button>
                                                <ul class="dropdown-menu">
                                                    <li><a  data-toggle="modal" data-target="#delete-modal" wire:click="delete({{ $announcementForm->announcement_form_id }})"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a></li>
                                                </ul>
                                            </div>
                                        </h5>
                                    </div>
                                    <div class="panel-body" style="margin-top:20px">
                                        <div class="row no-margin-bottom">
                                            <div class="col-lg-12">
                                                {{ $announcementForm->form_description }}
                                            </div>
                                            <div class="col-lg-12">
                                                <ul>
                                                    <li><strong>Terreno Comercial: </strong> {{ $announcementForm->land_name }}<br></li>
                                                    <li><strong>Estrategia: </strong> {{ $announcementForm->strategy_name }}<br></li>
                                                    <li><strong>Acción: </strong> {{ $announcementForm->action_name }}<br></li>
                                                </ul>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="pull-right">
                                            <a class="btn btn-success" href="{{ route('announcement.form-options',['form'=>$announcementForm->announcement_form_id]) }}">
                                                <i class="voyager-news"></i>
                                                &nbsp;Configurar respuestas
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

            jQuery("#formId").select2({
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

            jQuery("#formId").on('change', function(e) {
                var data = $('#formId').select2("val");
                @this.set('formId', data);
            });
        }
        
        initSelect2();
        window.livewire.on('select2', () => {
            initSelect2();
        });
    </script>
@endpush
