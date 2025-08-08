<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="create-modal-2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Nuevo Postulado
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label is-required">NIT / Cédula:</label>
                            <div class="input-group" style="align-items:center">
                                <input type="text" class="form-control" name="nit" wire:model="nit" autocomplete="off" aria-autocomplete="none">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button" wire:click="searchNit">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </span>
                            </div>
                            @error('nit')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            @error('stage')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label is-required">Nombre de la empresa:</label>
                            <input type="text" class="form-control" name="name" wire:model="name"
                                autocomplete="off" aria-autocomplete="none">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label is-required">Teléfono:</label>
                            <input type="text" class="form-control" name="phone" wire:model="phone"
                                autocomplete="off" aria-autocomplete="none">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label is-required">Correo electrónico:</label>
                            <input type="text" class="form-control" name="email" wire:model="email"
                                autocomplete="off" aria-autocomplete="none">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">WhatsApp:</label>
                            <input type="text" class="form-control" name="whatsapp" wire:model="whatsapp"
                                autocomplete="off" aria-autocomplete="none">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Página web:</label>
                            <input type="text" class="form-control" name="website" wire:model="website"
                                autocomplete="off" aria-autocomplete="none">
                        </div>
                        <div class="form-group">
                            <label class="form-label is-required">Nombre de persona de
                                contacto:</label>
                            <input type="text" class="form-control" name="contact_person_name"
                                wire:model="contact_person_name" autocomplete="off" aria-autocomplete="none">
                            @error('contact_person_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary pull-right" wire:click="store()" @if($contactHasStage) disabled @endif>
                    <i class="fa fa-floppy-o"></i>&nbsp;Guardar
                </button>
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()">
                    <i class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}
                </button>
            </div>
        </div>
    </div>
</div>
