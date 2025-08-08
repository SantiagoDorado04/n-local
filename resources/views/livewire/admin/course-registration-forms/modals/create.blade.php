<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="create-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Nuevo formulario de control de registro
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="is-required"><strong>Nombre formulario de control de registro:
                                </strong></label>
                            <input type="text" class="form-control" wire:model="name"
                                placeholder="Nombre de la etapa">
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

                        <div class="form-group" wire:ignore>
                            <label><strong>Terreno comercial:</strong></label>
                            <select class="form-control" wire:model="land_id" id="land_d">
                                <option value="">Seleccionar</option>
                                @foreach ($lands as $land)
                                    <option value="{{ $land->id }}">{{ $land->name }}</option>
                                @endforeach
                            </select>
                            @error('land_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label><strong>Estrategia comercial:</strong></label>
                            <select class="form-control" wire:model="strategy_id" id="strategy_id">
                                <option value="" selected>Seleccionar</option>
                                @foreach ($strategies as $strategy)
                                    <option value="{{ $strategy->id }}">{{ $strategy->name }}</option>
                                @endforeach
                            </select>
                            @error('strategy_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label><strong>Acción comercial:</strong></label>
                            <select class="form-control" wire:model="action_id" id="action_id">
                                <option value="" selected>Seleccionar</option>
                                @foreach ($actions as $action)
                                    <option value="{{ $action->id }}">{{ $action->name }}</option>
                                @endforeach
                            </select>
                            @error('action_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label><strong>Embebido video:</strong></label>
                            <textarea class="form-control" wire:model='embebed_video'></textarea>
                            @error('embebed_video')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Activo: </strong></label>
                            <br>
                            <div class="form-check">
                                <input class="form-check-input" wire:model="active" type="radio" value="1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Sí
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" wire:model="active" type="radio" value="0">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    No
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><strong>Cargar archivo (Imágenes: .jpg, .jpeg, .png, .gif, PDFs: .pdf):</strong></label>
                            <input type="file" class="form-control" wire:model="file" accept=".jpg,.jpeg,.png,.gif,.pdf">
                            @error('file')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Mensaje de recordaorio: </strong></label>
                            <textarea class="form-control" wire:model="reminder_message" rows="4" placeholder="Escriba aquí el mensaje..."></textarea>
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
