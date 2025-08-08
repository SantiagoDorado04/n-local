<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="edit-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-edit"></i>
                    Editar documento
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="is-required"><strong>Nombre:</strong></label>
                            <input type="text" class="form-control" wire:model="name"
                                placeholder="Nombre del documento">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="is-required"><strong>Tipo:</strong></label>
                            <select class="form-control" wire:model="type">
                                <option value="">Seleccionar</option>
                                <option value="I">Entrada</option>
                                <option value="O">Salida</option>
                            </select>
                            @error('type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        @if ($type === 'I')
                            <div class="form-group">
                                <label class="is-required"><strong>Requerido:</strong></label><br>
                                <div class="form-check">
                                    <input class="form-check-input" wire:model="required" type="radio" value="1">
                                    Sí
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" wire:model="required" type="radio" value="0">
                                    No
                                </div>
                                @error('required')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @endif


                        <div class="form-group">
                            <label><strong>Archivo actual:</strong></label><br>
                            @if ($currentFile)
                                <a href="{{ Storage::url($currentFile) }}" target="_blank">Ver archivo</a>
                            @else
                                <p>No hay archivo</p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label><strong>Cambiar archivo (opcional):</strong></label>
                            <input type="file" class="form-control" wire:model="file"
                                accept=".doc,.docx,.jpg,.jpeg,.png,.gif,.pdf">
                            @error('file')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label><strong>Embebido video:</strong></label>
                            <textarea class="form-control" wire:model="video_embebed"></textarea>
                            @error('video_embebed')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary pull-right" wire:click="update()">
                    <i class="fa fa-refresh"></i>&nbsp;Actualizar
                </button>
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()">
                    <i class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}
                </button>
            </div>
        </div>
    </div>
</div>
