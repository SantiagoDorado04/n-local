<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="create-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Nueva Actividad presencial
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="is-required"><strong>Nombre: </strong></label>
                            <input type="text" class="form-control" wire:model="name" placeholder="Nombre de la actividad">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="is-required"><strong>Fecha: </strong></label>
                            <input type="date" class="form-control" wire:model="date" placeholder="Introduzca la fecha...">
                            @error('date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="is-required"><strong>Hora: </strong></label>
                            <input type="time" class="form-control" wire:model="hour" placeholder="Introduzca la hora...">
                            @error('hour')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        @if ($event_type === 'presential')
                            <div class="form-group">
                                <label class="is-required"><strong>Ubicacion: </strong></label>
                                <input type="text" class="form-control" wire:model="location" placeholder="Introduzca la ubicacion...">
                                @error('location')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @else
                            <div class="form-group">
                                <label><strong>Ubicacion: </strong></label>
                                <input type="text" class="form-control" wire:model="location" placeholder="Introduzca la ubicacion...">
                            </div>
                        @endif

                        <div class="form-group">
                            <label class="is-required"><strong>Facilitador: </strong></label>
                            <input type="text" class="form-control" wire:model="facilitator" placeholder="Introduzca el facilitador">
                            @error('facilitator')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="is-required"><strong>Duración (minutos): </strong></label>
                            <input type="number" class="form-control" wire:model="duration" placeholder="Duración">
                            @error('duration')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="is-required"><strong>Link de registro: </strong></label>
                            <input type="text" class="form-control" wire:model="registration_link" placeholder="Introduzca el link de registro...">
                            @error('registration_link')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="is-required"><strong>Tipo de actividad: </strong></label>
                            <select class="form-control" wire:model="event_type" aria-label="Default select example">
                                <option value="">Seleccionar</option>
                                <option value="presential">Presencial</option>
                                <option value="virtual">Virtual</option>
                            </select>
                            @error('event_type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        @if ($event_type === 'virtual')
                            <div class="form-group">
                                <label class="is-required"><strong>Enlace virtual:</strong></label>
                                <input type="text" class="form-control" wire:model="virtual_link" placeholder="Enlace virtual">
                                @error('virtual_link')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @else
                            <div class="form-group">
                                <label><strong>Enlace virtual:</strong></label>
                                <input type="text" class="form-control" wire:model="virtual_link" placeholder="Enlace virtual">
                            </div>
                        @endif
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
                            <label class=""><strong>Fecha limite de cancelacion: </strong></label>
                            <input type="date" class="form-control" wire:model="cancellation_deadline" placeholder="Introduzca la fecha maxima de cancelacion...">
                            @error('cancellation_deadline')
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
