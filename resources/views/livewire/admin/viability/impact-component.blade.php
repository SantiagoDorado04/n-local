<div>

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li><a href="{{ route('contacts.viability') }}">Viabilidad</a></li>
            <li>Impacto</li>
        </ol>
    @endsection

    @section('page_title', 'Impacto | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-bolt"></i>Impacto - {{ $project->title }}
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
                                <div class="panel panel-bordered">
                                    <div class="panel-body">
                                        <div class="row no-margin-bottom">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="is-required"><strong>Impacto:</strong></label>
                                                    <br>
                                                    <button class="btn btn-success sm-b" wire:click="addImpact"><i
                                                            class="fa fa-plus-square"></i>&nbsp;Agregar impacto</button>
                                                    <br>
                                                    @error('impacts')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th><small>Impacto</small></th>
                                                                <th><small>{{ date('Y') }}</small>
                                                                </th>
                                                                <th><small>{{ date('Y', strtotime('+1 year')) }}</small></th>
                                                                <th><small>Medición</small></th>
                                                                <th><small>Acciones</small></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($impacts as $index => $impact)
                                                                <tr>
                                                                    {{--  <th><small>(Ton CO2) Emisiones evitadas</small></th>  --}}
                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                        wire:model="impacts.{{ $index }}.impact">
                                                                        @error('impacts.' . $index . '.impact')
                                                                            <small
                                                                                class="text-danger">{{ $message }}</small>
                                                                        @enderror
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                            wire:model="impacts.{{ $index }}.last_year">
                                                                        @error('impacts.' . $index . '.last_year')
                                                                            <small
                                                                                class="text-danger">{{ $message }}</small>
                                                                        @enderrorility
                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                            wire:model="impacts.{{ $index }}.current_year">
                                                                        @error('impacts.' . $index . '.current_year')
                                                                            <small
                                                                                class="text-danger">{{ $message }}</small>
                                                                        @enderror
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                            wire:model="impacts.{{ $index }}.measurement">
                                                                        @error('impacts.' . $index . '.measurement')
                                                                            <small
                                                                                class="text-danger">{{ $message }}</small>
                                                                        @enderror
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-danger sm-b"
                                                                            wire:click="removeImpact({{ $index }})">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="is-required"><strong>Técnica recolección de
                                                            datos:</strong></label>
                                                    <br>
                                                    <small>
                                                        Indique la metodología utilizada para la recolección de los
                                                        datos y la evaluación de impacto.
                                                    </small>
                                                    <textarea class="form-control" rows="8" wire:model="data_collection"></textarea>
                                                    @error('data_collection')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12 text-center">
                                                <button class="btn btn-success" wire:click="update()"><i
                                                        class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="panel panel-bordered">
                                    <div class="panel-body">
                                        <div class="row no-margin-bottom">
                                            <div class="col-md-12">
                                                <div class="panel panel-bordered">
                                                    <div class="panel-heading" style="padding-left:20px">
                                                        <h5>Archivos adjuntos</h5>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="row no-margin-bottom">
                                                            <div class="col-lg-12">
                                                                En esta sección carge los archivos como:
                                                                <ul>
                                                                    <li>Certificado de existencia representacion legal
                                                                    </li>
                                                                    <li>Estados financieros</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="row no-margin-bottom">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="is-required"><strong>Nombre del
                                                                            adjunto:</strong></label>
                                                                    <input type="text" class="form-control"
                                                                        wire:model="attachment_name">
                                                                    @error('attachment_name')
                                                                        <span
                                                                            class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label class="is-required"><strong>Seleccione la
                                                                            evidencia:</strong></label>
                                                                    <input type="file" id="exampleInputFile"
                                                                        wire:model="attachment"
                                                                        accept="application/pdf">
                                                                    @error('attachment')
                                                                        <span
                                                                            class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4" style="padding-top:22px">
                                                                <button class="btn btn-success" wire:click="upload()"><i
                                                                        class="fa fa-upload"></i>&nbsp;Subir</button>
                                                            </div>
                                                        </div>
                                                        <div class="row no-margin-bottom">
                                                            <div class="col-lg-12">

                                                                @if ($attachments != [])
                                                                    <table class="table table-bordered">
                                                                        @foreach ($attachments as $attachment)
                                                                            <tr>
                                                                                <td width="60%">
                                                                                    {{ $attachment->name }}
                                                                                </td>
                                                                                <td width="20%"
                                                                                    class="no-sort no-click bread-actions">
                                                                                    <a class="btn btn-success sm-b"
                                                                                        href="{{ url('storage/' . substr($attachment->url, 7)) }}" target="_blank"
                                                                                        style="text-decoration:none;">
                                                                                        <i
                                                                                            class="fa fa-download"></i>&nbsp;Descargar
                                                                                    </a>
                                                                                    <button class="btn btn-danger sm-b"
                                                                                        data-toggle="modal"
                                                                                        data-target="#delete-modal"
                                                                                        wire:click="delete({{ $attachment->id }})">
                                                                                        <i class="fa fa-trash"></i>
                                                                                        &nbsp;Eliminar
                                                                                    </button>

                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </table>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
