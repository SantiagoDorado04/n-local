<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="create-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Nuevo agendamiento
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="is-required"><strong>Título: </strong></label>
                            <input type="text" class="form-control" wire:model="meetTitle">
                            @error('meetTitle')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="is-required"><strong>Contacto: </strong></label>
                            <select class="form-control" wire:model="contactId" id="contactId" wire:ignore>
                                <option value="">Seleccionar</option>
                                @foreach ($contacts as $contact)
                                    <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                                @endforeach
                            </select>
                            @error('contactId')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label class="is-required"><strong>Fecha de la reunión: </strong></label>
                            <input type="date" class="form-control" wire:model="meetDate">
                            @error('meetDate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="is-required"><strong>Hora de la reunión: </strong></label>
                            <input type="time" class="form-control" wire:model="meetTime">
                            @error('meetTime')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="row no-margin-bottom">
                                <div class="col-lg-12">
                                    <label class="is-required"><strong>Duración: </strong></label>
                                </div>
                                <div class="col-lg-6">
                                    <small><strong>Minutos: </strong></small>
                                    <input type="number" class="form-control" min="0" wire:model='durationM'>
                                </div>
                                <div class="col-lg-6">
                                    <small><strong>Horas: </strong></small>
                                    <input type="number" class="form-control" min="0" wire:model='durationH'>
                                </div>
                                <div class="col-lg-12">
                                    @error('duration')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary pull-right" wire:click="store()"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                <button type="button" class="btn btn-default pull-right"
                    wire:click="cancel()"><i class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
