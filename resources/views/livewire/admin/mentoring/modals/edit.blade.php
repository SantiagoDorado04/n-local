<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="edit-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}" wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-pencil-square"></i>
                    Editar Mentor
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="is-required"><strong>Mentor: </strong></label>
                            <select class="form-control" wire:model="mentor_id">
                                        <option value="">Seleccionar</option>
                                        @foreach ($mentorsList as $mentor)
                                        <option value="{{ $mentor->id }}">{{ $mentor->nit . ' ' . $mentor->name }}</option>
                                        @endforeach
                                    </select>
                            @error('mentor_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Duración de la sesión (minutos): </strong></label>
                            <input type="number" class="form-control" wire:model="session_duration" placeholder="Duración de la sesión">
                            @error('session_duration')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Puntos asignados: </strong></label>
                            <input type="number" class="form-control" wire:model="points" placeholder="Puntos">
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
                            <input type="textarea" class="form-control" wire:model="reminder_message" placeholder="Mensaje recordatorio">
                            @error('reminder_message')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class=""><strong>Fecha Mensaje recordatorio: </strong></label>
                            <input type="date" class="form-control" wire:model="reminder_message_date" placeholder="Fecha Mensaje recordatorio">
                            @error('reminder_message_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class=""><strong>Medio Mensaje recordatorio: </strong></label>
                            <select class="form-control" wire:model="reminder_message_mean" placeholder="Medio Mensaje recordatorio">
                                <option value="">Seleccione el medio del mensaje recordatorio</option>
                                <option value="email">Email</option>
                                <option value="whatsapp">Whatsapp</option>
                                <option value="sms">SMS</option>
                            </select>
                            @error('reminder_message_mean')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class=""><strong>Mensaje felicitacion: </strong></label>
                            <input type=" textarea" class="form-control" wire:model="congratulation_message" placeholder="Mensaje felicitacion">
                            @error('congratulation_message')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class=""><strong>Fecha Mensaje felicitacion: </strong></label>
                            <input type="date" class="form-control" wire:model="congratulation_message_date" placeholder="Fecha Mensaje felicitacion">
                            @error('congratulation_message_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class=""><strong>Medio Mensaje felicitación: </strong></label>
                            <select class="form-control" wire:model="congratulation_message_mean" placeholder="Medio Mensaje felicitación">
                                <option value="">Seleccione el medio del mensaje felicitación</option>
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
                <button class="btn btn-primary pull-right" wire:click="update()"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
