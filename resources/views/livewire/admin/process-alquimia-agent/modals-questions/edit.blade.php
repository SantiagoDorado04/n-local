<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="edit-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-pencil-square"></i>
                    Editar pregunta
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="is-required"><strong>Texto: </strong></label>
                            <input type="text" class="form-control" wire:model="text"
                                placeholder="Texto de la pregunta">
                            @error('text')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Prompt: </strong></label>
                            <textarea class="form-control" wire:model="prompt" rows="4" placeholder="Escriba aquí el prompt..."></textarea>
                            @error('prompt')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="text-muted">
                                Use la sintaxis <code>[$variable]</code> para definir variables que luego podrá usar en
                                el prompt.
                                Ejemplo de prompt: <em>Hola $nombreEmpresa con nit $nit</em>
                            </small>
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Guía: </strong></label>
                            <textarea class="form-control" wire:model="guide" rows="4"
                                placeholder="[$nombreEmpresa] = Escriba aquí el nombre de su empresa
[$nit] = Escriba aquí el nit de su empresa"></textarea>
                            @error('guide')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="text-muted">
                                Use la sintaxis <code>[$variable]</code> para definir variables que luego podrá usar en
                                el prompt.
                                Ejemplo de prompt: <em>Hola $nombreEmpresa con nit $nit</em>
                            </small>
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
