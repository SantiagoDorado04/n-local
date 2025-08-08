<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="edit-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-pencil-square"></i>
                    Editar curso
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="is-required"><strong>Nombre: </strong></label>
                            <input type="text" class="form-control" wire:model="name" placeholder="Nombre del curso">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Descripción: </strong></label>
                            <textarea class="form-control" wire:model="description" rows="10" placeholder="Escriba aquí la descripción..."></textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Primero: </strong></label>
                            <br>
                            <div class="form-check">
                                <input class="form-check-input" wire:model="first" type="radio" value="1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Sí
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" wire:model="first" type="radio" value="0">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    No
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class=""><strong>Curso Anterior: </strong></label>
                            <select id="previous_course" class="form-control" wire:model="previous_course">
                                <option value="null">Seleccionar</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select><br>
                        </div>
                        <div class="form-group">
                            <label class=""><strong>Próximo Curso: </strong></label>
                            <select id="next_course" class="form-control" wire:model="next_course">
                                <option value="null">Seleccionar</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select><br>
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Duración (en semanas): </strong></label>
                            <input type="number" class="form-control" wire:model="duration" placeholder="Duración">
                            @error('duration')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Fecha de Inicio: </strong></label>
                            <input type="date" class="form-control" wire:model="start_date"
                                placeholder="Fecha de Inicio">
                            @error('start_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Fecha final: </strong></label>
                            <input type="date" class="form-control" wire:model="end_date" placeholder="Fecha final:">
                            @error('end_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Puntos asignados: </strong></label>
                            <input type="number" class="form-control" wire:model="points" placeholder="Puntos:">
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
                            <input type="textarea" class="form-control" wire:model="reminder_message"
                                placeholder="Mensaje recordatorio">
                            @error('reminder_message')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class=""><strong>Fecha Mensaje recordatorio: </strong></label>
                            <input type="date" class="form-control" wire:model="reminder_message_date"
                                placeholder="Fecha Mensaje recordatorio">
                            @error('reminder_message_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class=""><strong>Medio Mensaje recordatorio: </strong></label>
                            <select class="form-control" wire:model="reminder_message_mean"
                                placeholder="Medio Mensaje recordatorio">
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
                            <input type=" textarea" class="form-control" wire:model="congratulation_message"
                                placeholder="Mensaje felicitacion">
                            @error('congratulation_message')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class=""><strong>Fecha Mensaje felicitacion: </strong></label>
                            <input type="date" class="form-control" wire:model="congratulation_message_date"
                                placeholder="Fecha Mensaje felicitacion">
                            @error('congratulation_message_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class=""><strong>Medio Mensaje felicitación: </strong></label>
                            <select class="form-control" wire:model="congratulation_message_mean"
                                placeholder="Medio Mensaje felicitación">
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
                <button class="btn btn-primary pull-right" wire:click="update()"><i
                        class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i
                        class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
