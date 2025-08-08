<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="edit-modal-3" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>&nbsp;Responder soporte
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12 text-center">
                        <h5>Información de la respuesta</h5>
                    </div>

                    <div class="col-lg-12">
                        <label class="is-required"><strong>Descripción respuesta:</strong></label>
                        <div wire:ignore>
                            <textarea class="form-control" rows="4" wire:model="body_response" id="content4"></textarea>
                        </div>
                        @error('body_response')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-lg-12">
                        <label class=""><strong>Adjunto respuesta:</strong></label>
                        <input type="file" class="form-control" wire:model="response_attached">
                        @error('response_attached')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary pull-right" wire:click="updatResponse()"><i
                        class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i class="fa fa-ban"></i>
                    &nbsp;{{ __('voyager::generic.close') }}
                </button>
            </div>
        </div>
    </div>
</div>