<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="edit-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-pencil-square"></i>
                    Editar formulario
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="is-required"><strong>Título</strong></label>
                            <input type="text" class="form-control" wire:model="title"
                                placeholder="Título de la apreciación">
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="is-required"><strong>Apreciación</strong></label>
                            <textarea class="form-control" rows="4" wire:model="appreciation" placeholder="Texto de la apreciación..."></textarea>
                            @error('appreciation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="is-required"><strong>Puntos de inicio</strong></label>
                            <input type="number" class="form-control" wire:model="start_points">
                            @error('start_points')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="is-required"><strong>Puntos de fin</strong></label>
                            <input type="number" class="form-control" wire:model="end_points">
                            @error('end_points')
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
