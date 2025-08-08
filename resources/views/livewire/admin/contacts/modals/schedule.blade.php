<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="info-modal-3" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Asignar agente de contacto
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                    <div class="form-group">
                        <label><strong>Seleccionar agente de contacto:</strong></label>
                        <select class="form-control" wire:model="userId" id="userId" wire:ignore>
                            <option value="">Seleccionar</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('userId')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label><strong>Fecha cuando se debe contactar:</strong></label>
                        <input type="date" class="form-control" wire:model="dateToContact">
                        @error('dateToContact')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label><strong>Hora cuando se debe contactar:</strong></label>
                        <input type="time" class="form-control" wire:model="timeToContact">
                        @error('timeToContact')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label><strong>Observaciones para el agente:</strong></label>
                        <textarea class="form-control" wire:model="observationsContact" rows="8"></textarea>
                        @error('oobservationsContact')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label><strong>Contacto prioritario:</strong></label>
                        <div class="form-group">
                            <label class="radio-inline">
                                <input wire:model="priority" value="1" type="radio">
                                Si</label>
                            <label class="radio-inline">
                                <input wire:model="priority" value="0" type="radio">
                                No</label>
                        </div>
                        @error('priority')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary pull-right" wire:click="storeSchedule()"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()">{{
                    __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
</div>