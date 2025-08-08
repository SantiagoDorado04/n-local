<div wire:ignore.self class="modal modal-success fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="edit-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}" wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-check"></i>
                    Actualizar estado del contacto
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label><strong>Fecha cuando se debe contactar:</strong></label>
                            <span>{{ $schedule !='' ? $schedule->date_to_contact :'' }}</span>
                        </div>
                        <div class="form-group">
                            <label><strong>Hora cuando se debe contactar:</strong></label>
                            <span>{{ $schedule !='' ? $schedule->time_to_contact :'' }}</span>
                        </div>
                        <div class="form-group">
                            <label><strong>Observaciones de asignación:</strong></label>
                            <span>{{ $schedule !='' ? $schedule->observations_contact :'' }}</span>
                        </div>
                        <hr>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label><strong>Estado:</strong></label>
                            <select class="form-control" wire:model="status">
                                <option name="">Seleccionar</option>
                                <option value="inprogress">En curso</option>
                                <option value="slope">Pendiente reintentar</option>
                                <option value="completed">Completado</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label><strong>Fecha cuando se contactó:</strong></label>
                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}"  wire:model='date_contact'>
                        </div>
                        
                        <div class="form-group">
                            <label><strong>Hora cuando se contactó:</strong></label>
                            <input type="time" class="form-control" wire:model='time_contact'>
                        </div>
                        <div class="form-group">
                            <label><strong>Observaciones:</strong></label>
                            <textarea class="form-control" rows="8"  wire:model='observations'></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success pull-right" wire:click='update()'>Si, Confirmar!</button>
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
</div>