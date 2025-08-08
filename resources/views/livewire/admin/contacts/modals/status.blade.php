<div wire:ignore.self class="modal modal-success fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="info-modal-6" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}" wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-trash"></i>&nbsp;¿Está seguro de asignar el rol empresa ?
                </h5>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success pull-right" wire:click="updateRol()">Si, confirmar!</button>
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
</div>