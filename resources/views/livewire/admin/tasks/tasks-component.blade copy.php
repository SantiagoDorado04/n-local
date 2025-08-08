<div>
    @section('page_title', 'Reg. de Tareas | '.setting('admin.title'))

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>Reg. de Tareas</li>
        </ol>
    @endsection

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-tasks"></i> Registro de tareas
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
                                <button class="btn btn-success" wire:click='export'><i
                                        class="fa fa-file-excel-o"></i>&nbsp;Exportar</button>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#info-modal-2"><i
                                        class="fa fa-file-excel-o"></i>&nbsp;Importar</button>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="actions dt-not-orderable thwidth">
                                                    <small>{{ __('voyager::generic.actions') }}</small>
                                                </th>
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
                                                <th class="thwidth"><small>Fecha de registro</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if (count($contacts) > 0)
                                                @foreach ($contacts as $contact)
                                                    <tr>
                                                        <td class="fitwidth">
                                                        </td>
                                                        <td class="fitwidth">{{ $contact->nit }}</td>
                                                        <td class="fitwidth">{{ $contact->name }}</td>
                                                        <td class="fitwidth">{{ $contact->email }}</td>
                                                        <td class="fitwidth">{{ $contact->phone }}</td>
                                                        <td class="fitwidth">{{ $contact->whatsapp }}</td>
                                                        <td class="fitwidth">{{ $contact->contact_person_name }}</td>
                                                        <td class="fitwidth">{{ $contact->website }}</td>
                                                        <td class="fitwidth">{{ $contact->commercial_action_name }}
                                                        </td>
                                                        <td class="fitwidth">{{ $contact->commercial_strategy_name }}
                                                        </td>
                                                        <td class="fitwidth">{{ $contact->commercial_land_name }}</td>
                                                        <td class="fitwidth">{{ $contact->commercial_form_name }}</td>
                                                        <td class="fitwidth">{{ $contact->created_at }}</td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
