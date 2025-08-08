<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="create-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Nuevo pregunta formulario widget
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="is-required"><strong>Texto de pregunta: </strong></label>
                            <textarea class="form-control" wire:model="question"></textarea>
                            @error('question')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Tipo de pregunta:</strong></label>
                            <div class="form-group">
                                <label class="radio-inline">
                                    <input wire:model="type" value="pa" type="radio">
                                    Pregunta abierta</label>
                                <label class="radio-inline">
                                    <input wire:model="type" value="po" type="radio">
                                    Pregunta opción simple</label>
                            </div>
                            @error('type')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Visibilidad:</strong></label>
                            <div class="form-group">
                                <label class="radio-inline">
                                    <input wire:model="visibility" value="1" type="radio">
                                    Visible</label>
                                <label class="radio-inline">
                                    <input wire:model="visibility" value="0" type="radio">
                                    Oculta</label>
                            </div>
                            @error('visibility')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary pull-right" wire:click="store()"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()">{{
                    __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
</div>