<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="edit-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}" wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-pencil-square"></i>
                    Editar etapa
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="is-required"><strong>Nombre: </strong></label>
                            <input type="text" class="form-control" wire:model="name" placeholder="Nombre de etapa">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Descripción: </strong></label>
                            <textarea class="form-control" wire:model="description" rows="4" placeholder="Escriba aquí la descripción..."></textarea>
                            @error('description')
                                <small class="text-danger">{{ $message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class=" "><strong>Enlace formulario de inscripción <small>(Si el formulario es externo)</small>: </strong></label>
                            <input type="text" class="form-control" wire:model="link" placeholder="Enlace formulario de inscripcion">
                            @error('link')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class=" "><strong>Embebido formulario de inscripción <small>(Si el formulario es externo)</small></strong>: </label>
                            <textarea class="form-control" wire:model="embebed" rows="4" placeholder="Escriba aquí el embebido..."></textarea>
                            @error('embebed')
                                <small class="text-danger">{{ $message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label><strong>Terreno comercial:</strong></label>
                            <select class="form-control" wire:model="landId" id="landId">
                                <option value="">Seleccionar</option>
                                @foreach ($lands as $land)
                                    <option value="{{ $land->id }}">{{ $land->name }}</option>
                                @endforeach
                            </select>
                            @error('landId')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror  
                        </div>
                        <div class="form-group">
                            <label><strong>Estrategia comercial:</strong></label>
                            <select class="form-control" wire:model="strategyId" id="strategyId">
                                <option value="" selected>Seleccionar</option>
                                @foreach ($strategies as $strategy)
                                    <option value="{{ $strategy->id }}">{{ $strategy->name }}</option>
                                @endforeach
                            </select>
                            @error('strategyId')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror  
                        </div>
                        <div class="form-group">
                            <label><strong>Acción comercial:</strong></label>
                            <select class="form-control" wire:model="actionId" id="actionId">
                                <option value="" selected>Seleccionar</option>
                                @foreach ($actions as $action)
                                    <option value="{{ $action->id }}">{{ $action->name }}</option>
                                @endforeach
                            </select>
                            @error('actionId')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror  
                        </div>
                        <div class="form-group">
                            <label><strong>Embebido video:</strong></label>
                            <textarea class="form-control" wire:model='embebedVideo'></textarea>
                            @error('embebedVideo')
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