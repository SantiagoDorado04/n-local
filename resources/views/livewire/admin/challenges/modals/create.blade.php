<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="create-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Nuevo Reto y entregable
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="is-required"><strong>Título: </strong></label>
                            <input type="varchar" class="form-control" wire:model="title"
                                placeholder="Titulo del reto y entregable">
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Instrucción: </strong></label>
                            <textarea class="form-control" wire:model="instructions" rows="10" placeholder="Escriba aquí la instrucción..."></textarea>
                            @error('instructions')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Fecha de entrega: </strong></label>
                            <input type="datetime-local" class="form-control" wire:model="delivery_date"
                                placeholder="Fecha de entrega:">
                            @error('delivery_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Puntos asignados: </strong></label>
                            <input class="form-control" type="number" wire:model="points">
                            @error('points')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label><strong>Puntos requeridos: </strong></label>
                            <input class="form-control" type="number" wire:model="required_points">
                            @error('required_points')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class=""><strong>Mensaje recordatorio: </strong></label>
                            <textarea class="form-control" wire:model="reminder_message" rows="5" placeholder="Escriba aquí el mensaje de recordatorio..."></textarea>
                            @error('reminder_message')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class=""><strong>Fecha envío mensaje recordatorio: </strong></label>
                            <input class="form-control" type="date" wire:model="reminder_message_date">
                            @error('reminder_message_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class=""><strong>Medio envío mensaje recordatorio: </strong></label>
                            <select class="form-control" wire:model="reminder_message_mean">
                                <option value="">Seleccionar</option>
                                <option value="email">Email</option>
                                <option value="whatsapp">Whatsapp</option>
                                <option value="sms">SMS</option>
                            </select>
                            @error('reminder_message_mean')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class=""><strong>Mensaje de felicitación: </strong></label>
                            <textarea class="form-control" wire:model="congratulation_message" rows="5" placeholder="Escriba aquí el mensaje de felicitación..."></textarea>
                            @error('congratulation_message')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class=""><strong>Fecha envío mensaje de felicitación: </strong></label>
                            <input class="form-control" type="date" wire:model="congratulation_message_date">
                            @error('congratulation_message_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class=""><strong>Medio  envío mensaje de felicitación: </strong></label>
                            <select class="form-control" wire:model="congratulation_message_mean">
                                <option value="">Seleccionar</option>
                                <option value="email">Email</option>
                                <option value="whatsapp">Whatsapp</option>
                                <option value="sms">SMS</option>
                            </select>
                            @error('congratulation_message_mean')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary pull-right" wire:click="store()"><i
                        class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i
                        class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
