<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="edit-modal-2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}" wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-cloud-upload"></i>
                    Archivos adjuntos
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="panel panel-bordered">
                            <div class="panel-heading" style="padding:10px">
                                <strong><h5>Archivos cargados</h5></strong>
                            </div>
                            <div class="panel-body">
                                <div class="row no-margin-bottom">
                                    <div class="col-lg-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="80%"><small>Archivo</small></th>
                                                    <th width="20%"><small>Acciones</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @if ($product!=[])
                                                @if ($product->files!='')
                                                    @foreach ($product->files as $file)
                                                        <tr>
                                                            <td>{{ $file->name }}</td>
                                                            <td>

                                                                <a class="btn btn-success sm-b"  href="{{ url('storage/'.substr($file->url,7)) }}" target="_blank"><i class="fa fa-cloud-download"></i></a>
                                                                <a href="javascript:void(0);" class="btn btn-danger sm-b"
                                                                    wire:click="deleteFile({{ $file->id }})"
                                                                    onclick="confirm('¿Estás seguro de eliminar el archivo?') || event.stopImmediatePropagation()">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="panel panel-bordered">
                            <div class="panel-heading" style="padding:10px">
                                <strong><h5>Cargar nuevo archivo</h5></strong>
                            </div>
                            <div class="panel-body">
                                <div class="row no-margin-bottom">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label><strong>Nombre del archivo:</strong></label>
                                            <input type="text" class="form-control" wire:model="nameFile">
                                            @error('nameFile')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label><strong>Seleccione el archivo:</strong></label>
                                            <input type="file" class="form-control" wire:model="file">
                                            @error('file')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button class="btn btn-success" wire:click='upload()'><i class="fa fa-cloud-upload"></i>&nbsp;Subir</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()">{{ __('voyager::generic.close') }}</button>
            </div>
        </div>
    </div>
</div>
