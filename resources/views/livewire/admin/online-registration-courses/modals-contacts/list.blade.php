<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"  role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}" wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Lista de procesos
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <!-- <div class="form-group">
                            <label class="is-required"><strong>Nombre: </strong></label>
                            <input type="text" class="form-control" wire:model="name" placeholder="Nombre del proceso">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Descripción: </strong></label>
                            <textarea class="form-control" wire:model="description" rows="10" placeholder="Escriba aquí la descripción..."></textarea>
                            @error('description')
                                <small class="text-danger">{{ $message}}</small>
                            @enderror
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button class="btn btn-primary pull-right" wire:click="store()"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button> -->
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
