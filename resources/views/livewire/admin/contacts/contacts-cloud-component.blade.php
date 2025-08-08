<div>
    @php
    $dias = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado'];
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre',
    'Noviembre', 'Diciembre'];
    @endphp
    @include('livewire.admin.contacts.modals.create')
    @include('livewire.admin.contacts.modals.info')
    @include('livewire.admin.contacts.modals.upload')
    @include('livewire.admin.contacts.modals.schedule')
    @include('livewire.admin.contacts.modals.schedule-edit')
    @include('livewire.admin.contacts.modals.schedule-info')
    @include('livewire.admin.contacts.modals.status')
    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li>Contactos</li>
    </ol>
    @endsection

    @section('page_title', 'Contactos | '.setting('admin.title'))

    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-company"></i> Contactos
        </h1>
    </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin: 0px">
                    <div class="panel-body" style="margin: 0px">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-3">
                                <label><strong>Buscar empresa:</strong></label>
                                <input type="text" class="form-control" wire:model='searchName'
                                    placeholder="Nombre de la empresa">
                            </div>
                            <div class="col-lg-3" wire:ignore>
                                <label><strong>Terreno comercial:</strong></label>
                                <select class="form-control" wire:model="landId" id="landId">
                                    <option value="">Seleccionar</option>
                                    @foreach ($lands as $land)
                                    <option value="{{ $land->id }}">{{ $land->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label><strong>Estrategia comercial:</strong></label>
                                <select class="form-control" wire:model="strategyId" id="strategyId">
                                    <option value="" selected>Seleccionar</option>
                                    @foreach ($strategies as $strategy)
                                    <option value="{{ $strategy->id }}">{{ $strategy->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label><strong>Acción comercial:</strong></label>
                                <select class="form-control" wire:model="actionId" id="actionId">
                                    <option value="" selected>Seleccionar</option>
                                    @foreach ($actions as $action)
                                    <option value="{{ $action->id }}">{{ $action->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-lg-3">
                                <label><strong>Medio de almacenamiento:</strong></label>
                                <select class="form-control" wire:model=searchStorage>
                                    <option value="">Seleccionar</option>
                                    <option value="form">Formulario</option>
                                    <option value="manual">Manual</option>
                                    <option value="excel">Excel</option>
                                    <option value="api">API</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label><strong>Oportunidad de contacto:</strong></label>
                                <select class="form-control" wire:model="searchRate">
                                    <option value="">Seleccionar</option>
                                    <option value="5" style="color:#ffc700">★★★★★</option>
                                    <option value="4" style="color:#ffc700">★★★★</option>
                                    <option value="3" style="color:#ffc700">★★★</option>
                                    <option value="2" style="color:#ffc700">★★</option>
                                    <option value="1" style="color:#ffc700">★</option>
                                    <option value="sin calificar">Sin calificar</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label><strong>Fecha de registro (Desde):</strong></label>
                                <input type="datetime-local" class="form-control" wire:model="searchStart">
                            </div>
                            <div class="col-lg-3">
                                <label><strong>Fecha de registro (Hasta):</strong></label>
                                <input type="datetime-local" class="form-control" wire:model="searchEnd">
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
                            <div class="col-md-12">
                                <button class="btn btn-success sm-b" wire:click='export'><i
                                        class="fa fa-file-excel-o"></i>&nbsp;Exportar</button>
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="actions dt-not-orderable thwidth" wire:click="sortBy('id')">
                                                    <small>{{ __('voyager::generic.actions') }}</small>
                                                </th>
                                                <th class="thwidth"><small>ID</small></th>
                                                <th><small>Estado</small></th>
                                                <th class="thwidth"><small>NIT</small></th>
                                                <th class="thwidth"><small>Empresa</small></th>
                                                <th class="thwidth"><small>Correo elelctrónico</small></th>
                                                <th class="thwidth"><small>Teléfono</small></th>
                                                <th class="thwidth"><small>WhatsApp</small></th>
                                                <th class="thwidth"><small>Persona de contacto</small></th>
                                                <th class="thwidth"><small>Página Web</small></th>
                                                <th class="thwidth"><small>Acción comercial</small></th>
                                                <th class="thwidth"><small>Estrategia comercía</small></th>
                                                <th class="thwidth"><small>Terreno comercial</small></th>
                                                <th class="thwidth"><small>Formulario</small></th>
                                                <th class="thwidth"><small>Oportunidad de contacto</small></th>
                                                <th class="thwidth"><small>Medio almacenamiento</small></th>
                                                <th class="thwidth"><small>Fecha de registro</small></th>
                                                <th class="thwidth"><small>Agente asignado</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($contacts) > 0)
                                            @foreach ($contacts as $contact)
                                            <tr>
                                                <td class="fitwidth">
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary dropdown-toggle  sm-b" type="button" data-toggle="dropdown">
                                                            <i class="fa fa-cogs"></i> Acciones <span class="caret"></span>
                                                        </button>
                                                        
                                                        <ul class="dropdown-menu">
                                                            <!-- Detalles -->
                                                            <li>
                                                                <a href="{{ route('companies.detail', ['id'=> $contact->id]) }}" style="text-decoration: none;">
                                                                    <span style="cursor: pointer;">
                                                                        <i class="fa fa-info" style="top:0px"></i>&nbsp;&nbsp;Detalles
                                                                    </span>
                                                                </a>
                                                            </li>
                                                            <!-- Productos y servicios -->
                                                            <li>
                                                                <a href="{{ route('companies.products-services', ['id'=> $contact->id]) }}" style="text-decoration: none;">
                                                                    <span style="cursor: pointer;">
                                                                        <i class="fa fa-list-alt"></i>&nbsp;&nbsp;Productos y servicios
                                                                    </span>
                                                                </a>
                                                            </li>
                                                            <!-- Formularios asignados -->
                                                            <li>
                                                                <a href="{{ route('companies.assigned-forms', ['id'=> $contact->id]) }}" style="text-decoration: none;">
                                                                    <span style="cursor: pointer;">
                                                                        <i class="fa fa-file"></i>&nbsp;&nbsp;Formularios asignados
                                                                    </span>
                                                                </a>
                                                            </li>
                                                            <!-- Modelos de negocio -->
                                                            <li>
                                                                <a href="{{ route('companies.business-models', ['id'=> $contact->id]) }}" style="text-decoration: none;">
                                                                    <span style="cursor: pointer;">
                                                                        <i class="fa fa-bar-chart"></i>&nbsp;&nbsp;Modelos de negocio
                                                                    </span>
                                                                </a>
                                                            </li>
                                                            <!-- Calificar -->
                                                            <li>
                                                                <a href="#" wire:click="saveRate({{ $contact->id }})" data-toggle="modal" data-target="#info-modal" style="text-decoration: none;">
                                                                    <i class="fa fa-star-o"></i>&nbsp;&nbsp;Calificar
                                                                </a>
                                                            </li>
                                                            <!-- Editar/Schedule -->
                                                            <li>
                                                                @if ($contact->schedule_id!='')
                                                                    @if ($contact->schedule_status!='completed')
                                                                        <a href="#" wire:click="editSchedule({{ $contact->schedule_id }})" data-toggle="modal" data-target="#info-modal-4" style="text-decoration: none;">
                                                                            <i class="fa fa-phone"></i>&nbsp;&nbsp;Editar Horario
                                                                        </a>
                                                                    @else
                                                                        <a href="#" wire:click="infoSchedule({{ $contact->schedule_id }})" data-toggle="modal" data-target="#info-modal-5" style="text-decoration: none;">
                                                                            <i class="fa fa-phone"></i>&nbsp;&nbsp;Información del Horario
                                                                        </a>
                                                                    @endif
                                                                @else
                                                                    <a href="#" wire:click="saveSchedule({{ $contact->id }})" data-toggle="modal" data-target="#info-modal-3" style="text-decoration: none;">
                                                                        <i class="fa fa-phone"></i>&nbsp;&nbsp;Agendar
                                                                    </a>
                                                                @endif
                                                            </li>
                                                            <!-- Form -->
                                                            <li>
                                                                <a href="{{ route('commercial.contacts-cloud.form',['id'=>$contact->id]) }}" data-toggle="tooltip" data-placement="top"  style="text-decoration: none;">
                                                                    <i class="fa fa-wpforms"></i>&nbsp;&nbsp;Asignar Formulario
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    {{-- <!-- Range-->
                                                    <button
                                                        class="btn {{ $contact->rate == 'sin calificar' ? 'btn-success' : 'btn-primary' }} sm-b"
                                                        wire:click="saveRate({{ $contact->id }})"
                                                        data-toggle="modal" data-target="#info-modal">
                                                        <i class="fa fa-star-o"></i>
                                                    </button>
                                                    <!-- Contact-->
                                                    @if ($contact->schedule_id!='')
                                                        @if ($contact->schedule_status!='completed')
                                                        <button class="btn btn-warning sm-b"
                                                            wire:click="editSchedule({{ $contact->schedule_id }})"
                                                            data-toggle="modal" data-target="#info-modal-4"><i
                                                                class="fa fa-phone"></i></button>
                                                        @else
                                                        <button class="btn btn-info sm-b"
                                                            wire:click="infoSchedule({{ $contact->schedule_id }})"
                                                            data-toggle="modal" data-target="#info-modal-5"><i
                                                                class="fa fa-phone"></i></button>
                                                        @endif
                                                    @else
                                                    <button class="btn btn-success sm-b"
                                                        wire:click="saveSchedule({{ $contact->id }})"
                                                        data-toggle="modal" data-target="#info-modal-3"><i
                                                            class="fa fa-phone"></i></button>
                                                    @endif
                                                    <!-- Form -->
                                                    <a href="{{ route('commercial.contacts-cloud.form',['id'=>$contact->id]) }}"
                                                        class="btn btn-primary sm-b"
                                                        data-toggle="tooltip" data-placement="top" title="Formularios asignados">
                                                    <i class="fa fa-wpforms"></i>
                                                    </a> --}}
                                                </td>
                                                <td class="fitwidth">{{ $contact->id }}</td>
                                                <td>
                                                    @if ($contact && $contact->user && $contact->user->role)
                                                        @if ($contact->user->role->name == 'company')
                                                            <span class="label label-success">
                                                                Empresa
                                                            </span>
                                                        @elseif ($contact->user->role->name == 'guest')
                                                            <a href="#" style="text-decoration: none" data-toggle="modal" data-target="#info-modal-6" wire:click="editRol({{ $contact->id }})">
                                                                <span class="label label-primary">
                                                                    Invitado
                                                                </span>
                                                            </a>
                                                        @endif
                                                    @endif

                                                </td>
                                                <td class="fitwidth">{{ $contact->nit }}</td>
                                                <td class="fitwidth">{{ $contact->name }}</td>
                                                <td class="fitwidth">{{ $contact->email }}</td>
                                                <td class="fitwidth">{{ $contact->phone }}</td>
                                                <td class="fitwidth">{{ $contact->whatsapp }}</td>
                                                <td class="fitwidth">{{ $contact->contact_person_name }}</td>
                                                <td class="fitwidth">{{ $contact->website }}</td>
                                                <td class="fitwidth">{{ $contact->commercial_action_name }}</td>
                                                <td class="fitwidth">{{ $contact->commercial_strategy_name }}</td>
                                                <td class="fitwidth">{{ $contact->commercial_land_name }}</td>
                                                <td class="fitwidth">{{ $contact->commercial_form_name }}</td>
                                                <td class="fitwidth">
                                                    @if ($contact->rate != 'sin calificar')
                                                    <h4 style="color:#ffc700">
                                                        @for ($i = 1; $i <= $contact->rate; $i++)
                                                            ★
                                                            @endfor
                                                    </h4>
                                                    @else
                                                    Sin Calificar
                                                    @endif
                                                </td>
                                                <td class="fitwidth">
                                                    @switch($contact->storage)
                                                    @case('form')
                                                    Formulario
                                                    @break

                                                    @case('manual')
                                                    Manual
                                                    @break

                                                    @case('excel')
                                                    Excel
                                                    @break

                                                    @case('api')
                                                    API
                                                    @break

                                                    @default
                                                    @endswitch
                                                </td>
                                                <td class="fitwidth">{{ $contact->created_at }}</td>
                                                <td class="fitwidth">
                                                    @if ($contact->schedule_id != '')
                                                    {{ \App\Models\User::find($contact->schedule_user)->name }}
                                                    @else
                                                    Sin asignar
                                                    @endif

                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <th class="text-center" colspan="11">No se encontraron
                                                    resultados</th>
                                            </tr>
                                            @endif()
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-lg-6" style="padding-top:22px">
                                <span>{!! $paginationText !!}</span>
                            </div>
                            <div class="col-lg-6 text-right">
                                {{ $contacts->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('javascript')
<script>
    var fileInput = document.getElementById("fileContacts");
    fileInput.addEventListener("click", function() {
        Livewire.emit('resetFailures');
    });

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
            jQuery("#userId").select2({
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
            jQuery("#userId").on('change', function(e) {
                var data = $('#userId').select2("val");
                @this.set('userId', data);
            });
        }

        initSelect2();

        window.livewire.on('select2', () => {
            initSelect2();
        });
</script>
@endpush
