<div wire:ignore.self class="modal modal-success fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="edit-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Actualziar información de la actividad
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <label><strong>Fecha finalización actividad:</strong></label>
                        <input type="date" class="form-control" wire:model='dateCompleted'>
                        @error('dateCompleted')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12">
                        <label><strong>Hora finalización actividad:</strong></label>
                        <input type="time" class="form-control" wire:model='timeCompleted'>
                        @error('timeCompleted')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12">
                        <label><strong>Observaciones:</strong></label>
                        <textarea class="form-control" rows="4" wire:model='observationsCompleted'></textarea>
                        @error('observationsCompleted')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success pull-right" wire:click="update()">Actualizar</button>
                <button type="button" class="btn btn-default pull-right"
                    wire:click="cancel()"><i class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
