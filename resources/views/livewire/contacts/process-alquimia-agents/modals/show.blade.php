<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="show-modal" role="dialog">
    <div wire:loading wire:target="generateWithAI">
        @include('partials.loader')
    </div>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-list"></i>&nbsp;Generar texto con IA
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <textarea class="form-control" wire:model.defer="generatedText" rows="20"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                    wire:click="cancel()">{{ __('voyager::generic.close') }}</button>
                <button type="button" class="btn btn-success" wire:click="storeGeneratedText">Aceptar</button>
            </div>
        </div>
    </div>
</div>
