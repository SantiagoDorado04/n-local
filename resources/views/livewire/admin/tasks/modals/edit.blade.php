<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="edit-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Editar tarea
                </h5>
            </div>
            @if ($event != '')
                <div class="modal-body">
                    <div class="row no-margin-bottom">
                        <div class="col-lg-12">
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
                                <label class="is-required"><strong>Tarea: </strong></label>
                                <select class="form-control" wire:model="taskId" id="taskId" wire:ignore>
                                    <option value="">Seleccionar</option>
                                    @foreach ($taskTypes as $task)
                                        <option value="{{ $task->id }}">{{ $task->title }}</option>
                                    @endforeach
                                </select>
                                @error('taskId')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            @if ($taskDescription != '')
                                <div class="form-group">
                                    <label><strong>Descripción de la actividad:</strong></label>
                                    <textarea class="form-control" readonly style="background-color: #fff" rows="6">{{ $taskDescription }}</textarea>
                                </div>
                            @endif

                            <div class="form-group">
                                <label><strong>Observaciones:</strong></label>
                                <textarea class="form-control" rows="6" wire:model='taskObservations'></textarea>
                                @error('taskObservations')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label class="is-required"><strong>Fecha de la actividad: </strong></label>
                                <input type="date" class="form-control" wire:model="taskDate">
                                @error('taskDate')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="is-required"><strong>Hora de la actividad: </strong></label>
                                <input type="time" class="form-control" wire:model="taskTime">
                                @error('taskTime')
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
                                        <input type="number" class="form-control" min="0"
                                            wire:model='durationM'>
                                    </div>
                                    <div class="col-lg-6">
                                        <small><strong>Horas: </strong></small>
                                        <input type="number" class="form-control" min="0"
                                            wire:model='durationH'>
                                    </div>
                                    <div class="col-lg-12">
                                        @error('duration')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="is-required"><strong>Responsable de la actividad: </strong></label>
                                <select class="form-control" wire:model="agentId" id="agentId" wire:ignore>
                                    <option value="">Seleccionar</option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                    @endforeach
                                </select>
                                @error('agentId')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary pull-right" wire:click="update()"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                    <button type="button" class="btn btn-default pull-right"
                        wire:click="cancel()"><i class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
                </div>
            @endif
        </div>
    </div>
</div>
