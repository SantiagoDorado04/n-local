<div>

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li><a href="{{ route('contacts.viability') }}">Viabilidad</a></li>
            <li>Escala</li>
        </ol>
    @endsection

    @section('page_title', 'Escala | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-bar-chart"></i>Escala - {{ $project->title }}
            </h1>
        </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="is-required"><strong>Regulaciones:</strong></label>
                                    <small>
                                        Indique las normas que regulan actualmente su actividad, y/o que pueden favorecer su implementación.
                                    </small>
                                    <textarea class="form-control" rows="8" wire:model="regulations"></textarea>
                                    @error('regulations')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="is-required"><strong>Mercado:</strong></label>
                                    <br>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Mercado</th>
                                                <th><small>Territorio</small></th>
                                                <th><small>USD</small></th>
                                                <th><small>(#) Usuarios</small></th>
                                                <th><small>Segmento</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>TAM</td>
                                                <td>
                                                    <select class="form-control" wire:model="tamTerritory">
                                                        <option value="">Seleccionar</option>
                                                        <option value="Paises">Paises</option>
                                                        <option value="Departamentos">Departamentos</option>
                                                        <option value="Ciudades">Ciudades</option>
                                                    </select>
                                                    @error('tamTerritory')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" wire:model="tamUsd">
                                                    @error('tamUsd')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <select class="form-control" wire:model="tamUsers">
                                                        <option value="">Seleccionar</option>
                                                        <option value="Clientes">Clientes</option>
                                                        <option value="Beneficiarios">Beneficiarios</option>
                                                    </select>
                                                    @error('tamUsers')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <select class="form-control" wire:model="tamSegment">
                                                        <option value="">Seleccionar</option>
                                                        <option value="B2B">B2B</option>
                                                        <option value="B2C">B2C</option>
                                                        <option value="B2G">B2G</option>
                                                    </select>
                                                    @error('tamSegment')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>SAM</td>
                                                <td>
                                                    <select class="form-control" wire:model="samTerritory">
                                                        <option value="">Seleccionar</option>
                                                        <option value="Paises">Paises</option>
                                                        <option value="Departamentos">Departamentos</option>
                                                        <option value="Ciudades">Ciudades</option>
                                                    </select>
                                                    @error('samTerritory')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" wire:model="samUsd">
                                                    @error('samUsd')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <select class="form-control" wire:model="samUsers">
                                                        <option value="">Seleccionar</option>
                                                        <option value="Clientes">Clientes</option>
                                                        <option value="Beneficiarios">Beneficiarios</option>
                                                    </select>
                                                    @error('samUsers')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <select class="form-control" wire:model="samSegment">
                                                        <option value="">Seleccionar</option>
                                                        <option value="B2B">B2B</option>
                                                        <option value="B2C">B2C</option>
                                                        <option value="B2G">B2G</option>
                                                    </select>
                                                    @error('samSegment')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>SOM</td>
                                                <td>
                                                    <select class="form-control" wire:model="somTerritory">
                                                        <option value="">Seleccionar</option>
                                                        <option value="Paises">Paises</option>
                                                        <option value="Departamentos">Departamentos</option>
                                                        <option value="Ciudades">Ciudades</option>
                                                    </select>
                                                    @error('somTerritory')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" wire:model="somUsd">
                                                    @error('somUsd')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <select class="form-control" wire:model="somUsers">
                                                        <option value="">Seleccionar</option>
                                                        <option value="Clientes">Clientes</option>
                                                        <option value="Beneficiarios">Beneficiarios</option>
                                                    </select>
                                                    @error('somUsers')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <select class="form-control" wire:model="somSegment">
                                                        <option value="">Seleccionar</option>
                                                        <option value="B2B">B2B</option>
                                                        <option value="B2C">B2C</option>
                                                        <option value="B2G">B2G</option>
                                                    </select>
                                                    @error('somSegment')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="is-required"><strong>Tracción:</strong></label>
                                    <br>
                                    <button class="btn btn-success sm-b" wire:click="addKpi"><i class="fa fa-plus-square"></i>&nbsp;Agregar KPI</button>
                                    <br>
                                    @error('kpis')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><small>Indicadores KPI</small></th>
                                                <th><small>{{ date('Y', strtotime('-1 year')) }}</small></th>
                                                <th><small>{{ date('Y') }}</small></th>
                                                <th><small>Medición</small></th>
                                                <th><small>Acciones</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($kpis as $index => $kpi)
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" wire:model="kpis.{{ $index }}.indicator">
                                                    @error('kpis.'.$index.'.indicator')
                                                    <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" wire:model="kpis.{{ $index }}.last_year">
                                                    @error('kpis.'.$index.'.last_year')
                                                    <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" wire:model="kpis.{{ $index }}.current_year">
                                                    @error('kpis.'.$index.'.current_year')
                                                    <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" wire:model="kpis.{{ $index }}.measurement">
                                                    @error('kpis.'.$index.'.measurement')
                                                    <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger sm-b" wire:click="removeKpi({{ $index }})">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <button class="btn btn-success" wire:click="update()"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
