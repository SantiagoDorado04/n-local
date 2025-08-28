<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="edit-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-pencil-square"></i>
                    Editar conexion
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="is-required"><strong>Nombre:</strong></label>
                            <input type="text" class="form-control" wire:model="name"
                                placeholder="Nombre de la conexion">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="is-required"><strong>Descripción:</strong></label>
                            <textarea class="form-control" wire:model="description" rows="3" placeholder="Escriba aquí la descripción..."></textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="is-required"><strong>Tipo:</strong></label>
                            <input type="text" class="form-control" wire:model="type" placeholder="Tipo de conexión">
                            @error('type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class=""><strong>Estado: </strong></label>
                            <select class="form-control" wire:model="status">
                                <option value="">Seleccione el estado</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="is-required"><strong>URL:</strong></label>
                            <input type="url" class="form-control" wire:model="url" placeholder="https://...">
                            @error('url')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="is-required"><strong>API Key (dejar vacio para conservar la
                                    misma):</strong></label>
                            <input type="text" class="form-control" wire:model="apikey"
                                placeholder="Ingrese API Key">
                            @error('apikey')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="is-required"><strong>Transformador de respuesta:</strong></label>
                            <textarea class="form-control" wire:model="responseTransformer" rows="2"></textarea>
                            @error('responseTransformer')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="is-required"><strong>Cuerpo de la solicitud:</strong></label>
                            <textarea class="form-control" wire:model="requestBody" rows="3"></textarea>
                            @error('requestBody')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary pull-right" wire:click="update()"><i
                        class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i
                        class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
