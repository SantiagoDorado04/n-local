<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="edit-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-pencil-square"></i>
                    Editar Lección
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="is-required"><strong>Título: </strong></label>
                            <input type="text" class="form-control" wire:model="title"
                                placeholder="Título de la lección">
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Descripción: </strong></label>
                            <textarea class="form-control" wire:model="description" rows="10" placeholder="Escriba aquí la descripción..."></textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label><strong>Embebido video:</strong></label>
                            <input type="text" class="form-control" wire:model="video" placeholder="URL del video">
                            @error('video')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label><strong>Archivo (Imágenes: .jpg, .jpeg, .png, .gif, PDFs: .pdf): </strong></label>
                            <input type="file" class="form-control" wire:model="file"
                                accept=".jpg,.jpeg,.png,.gif,.pdf">
                            @error('file')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            @if ($currentFile)
                                <div class="mb-2">
                                    <a class="btn btn-primary sm-b" href="{{ $currentFile }}"
                                        target="_blank">Descargar</a>
                                    <button type="button" class="btn btn-danger sm-b"
                                        wire:click="removeFile()">Eliminar</button>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Orden: </strong></label>
                            <input type="number" class="form-control" wire:model="order" placeholder="Orden">
                            @error('order')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label><strong>Duración Horas: </strong></label>
                            <input type="number" class="form-control" wire:model="hours">
                            @error('hours')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label><strong>Duración Minutos: </strong></label>
                            <input type="number" class="form-control" wire:model="minutes">
                            @error('minutes')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label><strong>Duración Segundos: </strong></label>
                            <input type="number" class="form-control" wire:model="seconds">
                            @error('seconds')
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
