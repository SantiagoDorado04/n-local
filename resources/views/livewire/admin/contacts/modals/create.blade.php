<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="create-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Nuevo Contacto
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <label class="is-required"><strong>NIT:</strong></label>
                                <input type="text" class="form-control" wire:model="nit">
                                @error('nit')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <label class="is-required"><strong>Nombre de la empresa:</strong></label>
                                <input type="text" class="form-control" wire:model="name">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-12">
                                <label class="is-required"><strong>Teléfono:</strong></label>
                                <input type="phone" class="form-control" wire:model="phone">
                                @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <label class="is-required"><strong>Número de WhatsApp:</strong></label>
                                <input type="phone" class="form-control" wire:model="whatsapp">
                                @error('whatsapp')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-12">
                                <label class="is-required"><strong>Correo electrónico:</strong></label>
                                <input type="email" class="form-control" wire:model="email">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <label class="is-required"><strong>Nombre de persona de contacto:</strong></label>
                                <input type="text" class="form-control" wire:model="contact_person_name"
                                >
                                @error('contact_person_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-12">
                                <label class="is-required"><strong>Página Web:</strong></label>
                                <input type="url" class="form-control" wire:model="website">
                                @error('website')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

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