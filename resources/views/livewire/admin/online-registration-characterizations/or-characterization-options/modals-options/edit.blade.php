<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="edit-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    editar Opcion
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="is-required"><strong>Texto: </strong></label>
                            <input type="text" class="form-control" wire:model="text" placeholder="Texto">
                            @error('text')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Valor: </strong></label>
                            <input type="text" class="form-control" wire:model="value" placeholder="Valor">
                            @error('value')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label><strong>¿Es condicional?</strong></label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="conditionalToggle"
                                    wire:model="conditional">
                                <label class="custom-control-label" for="conditionalToggle">
                                    {{ $conditional ? 'Sí' : 'No' }}
                                </label>
                            </div>
                            @error('conditional')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Mostrar el select solo si conditional es true -->
                        @if ($conditional)
                            <div class="form-group">
                                <label class="is-required"><strong>Seleccionar caracterización:</strong></label>
                                <select class="form-control" wire:model="selected_characterization">
                                    <option value="">Seleccione una caracterización</option>
                                    @foreach ($characterizations as $characterization)
                                        <option value="{{ $characterization->id }}">{{ $characterization->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('selected_characterization')
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
