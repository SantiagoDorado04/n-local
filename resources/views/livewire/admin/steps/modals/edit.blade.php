<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="edit-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-pencil-square"></i>
                    Editar paso
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="is-required"><strong>Nombre: </strong></label>
                            <input type="text" class="form-control" wire:model="name" placeholder="Nombre del paso">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="is-required"><strong>Descripción: </strong></label>
                            <textarea class="form-control" wire:model="description" rows="4" placeholder="Escriba aquí la descripción..."></textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Disponible desde: </strong></label>
                            <input type="datetime-local" class="form-control" wire:model="available_from"
                                placeholder="Disponible desde...:">
                            @error('available_from')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                            <label class="is-required"><strong>Orden: </strong></label>
                            <input type="number" class="form-control" wire:model="order" placeholder="Orden">
                            @error('order')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> --}}
                        <div class="form-group">
                            <label class="is-required"><strong>Tipo de paso: </strong></label>
                            <select class="form-control" wire:model="step_type" aria-label="Default select example">
                                <option value="">Seleccionar</option>
                                <option value="F">Formulario</option>
                                <option value="M">Mentoria</option>
                                <option value="CD">Retos - Entregables</option>
                                <option value="FAA">Actividades Presenciales</option>
                                <option value="LMS">Aprendizaje LMS</option>
                                <option value="LZ">Lienzo</option>
                                <option value="VE">Video Entrevista</option>
                                <option value="AL">Agente AlquimIA</option>
                                <option value="AT">Agendamiento Trafft</option>
                                <option value="PT">Test</option>
                                <option value="CV">Validacion de cumplimiento</option>
                            </select>
                            @error('step_type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        @if ($step_type === 'AL')
                            <div class="form-group">
                                <label class="is-required"><strong>Conexión Alquimia:</strong></label>
                                <select class="form-control" wire:model="selectedAlquimiaConnection">
                                    <option value="">-- Seleccione conexión --</option>
                                    @foreach ($alquimiaAgentConnections as $connection)
                                        <option value="{{ $connection->id }}">
                                            {{ $connection->name ?? ($connection->description ?? 'Sin nombre') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('selectedAlquimiaConnection')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @endif
                        @if ($step_type === 'AT')

                            <div class="form-group">
                                <label class="is-required"><strong>Embed de Trafft: </strong></label>
                                <textarea class="form-control" wire:model="schedulingEmbed" rows="4" placeholder="Escriba aquí el embed..."></textarea>
                                @error('schedulingEmbed')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label><strong>Selecciona los pasos requeridos:</strong></label>
                                <div class="checkbox-list"
                                    style="max-height: 200px; overflow-y:auto; border:1px solid #ccc; padding:10px; border-radius:5px;">
                                    @foreach ($filteredRequiredSteps as $step)
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                wire:model="selectedRequiredSteps" value="{{ $step->id }}"
                                                id="req-step-{{ $step->id }}">
                                            <label class="form-check-label" for="req-step-{{ $step->id }}">
                                                {{ $step->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('selectedRequiredSteps')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @endif
                        @if ($step_type === 'CV')
                            <div class="form-group">
                                <label class="is-required"><strong>Embed de Compliance Verification: </strong></label>
                                <textarea class="form-control" wire:model="complianceEmbed" rows="4" placeholder="Escriba aquí el embed..."></textarea>
                                @error('complianceEmbed')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label><strong>Selecciona los pasos requeridos:</strong></label>
                                <div class="checkbox-list"
                                    style="max-height: 200px; overflow-y:auto; border:1px solid #ccc; padding:10px; border-radius:5px;">
                                    @foreach ($filteredRequiredSteps as $step)
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                wire:model="selectedRequiredSteps" value="{{ $step->id }}"
                                                id="req-step-cv-{{ $step->id }}">
                                            <label class="form-check-label" for="req-step-cv-{{ $step->id }}">
                                                {{ $step->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('selectedRequiredSteps')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @endif
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
