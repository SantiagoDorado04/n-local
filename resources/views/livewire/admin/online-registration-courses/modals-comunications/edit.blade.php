<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="edit-modal-2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Editar Comunicación
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label is-required">Nombre:</label>
                            <input type="text" class="form-control" name="name" wire:model="name"
                                autocomplete="off" aria-autocomplete="none">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label is-required">Acción:</label>
                            <select class="form-control" name="action" wire:model="action">
                                <option value="">Seleccione una acción</option>
                                <option value="CR">Registro a curso</option>
                                <option value="AC">Asignación de caracterización</option>
                                <option value="SA">Asistencia a sesión</option>
                                <option value="FC">Completado de contenido</option>
                                <option value="AR">Recordatorio de asistencia</option>
                            </select>
                            @error('action')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Canal:</label>
                            <select class="form-control" name="channel" wire:model="channel">
                                <option value="">Seleccione un canal</option>
                                @foreach ($ChannelCourse as $canal)
                                    <option value="{{ $canal->id }}">{{ $canal->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if (!empty($channelStructure))
                            <div class="form-group mt-3">
                                <label class="form-label">Estructura del canal:</label>

                                @foreach ($channelStructure as $campo => $valor)
                                    @if (is_array($valor))
                                        @foreach ($valor as $subcampo => $subvalor)
                                            <div class="mb-2">
                                                <label>{{ $campo }} - {{ $subcampo }}:</label>
                                                <input type="text" class="form-control"
                                                    wire:model.defer="channelStructure.{{ $campo }}.{{ $subcampo }}">
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="mb-2">
                                            <label>{{ $campo }}:</label>
                                            <input type="text" class="form-control"
                                                wire:model.defer="channelStructure.{{ $campo }}">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif


                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary pull-right" wire:click="update()">
                    <i class="fa fa-floppy-o"></i>&nbsp;Guardar
                </button>
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()">
                    <i class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}
                </button>
            </div>
        </div>
    </div>
</div>
