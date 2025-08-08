<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="create-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Nuevo modelo de negocio
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="is-required"><strong>Nombre: </strong></label>
                            <input type="text" class="form-control" wire:model="name" placeholder="Nombre del modelo de negocio">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="is-required"><strong>Descripción: </strong></label>
                            <textarea class="form-control" wire:model="description" rows="4" placeholder="Escriba aquí la descripción..."></textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label><strong>Porcentaje por tipo de clientes: </strong></label>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="is-required"><strong>% B2B:</strong></label>
                            <input type="number" class="form-control" wire:model="b2b">
                            @error('b2b')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="is-required"><strong>% B2C:</strong></label>
                            <input type="number" class="form-control" wire:model="b2c">
                            @error('b2c')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="is-required"><strong>% B2G:</strong></label>
                            <input type="number" class="form-control" wire:model="b2g">
                            @error('b2g')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <small class="text-danger">{{ $errorSum }}</small>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="is-required"><strong>Descripcion fuente de ingresos:</strong></label>
                            <textarea class="form-control" rows="8" wire:model="source_income"></textarea>
                            @error('source_income')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <labe class="is-required"><strong>Ingresos mensuales:</strong></labe>
                            <input type="number" class="form-control" wire:model="income">
                            @error('income')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="is-required"><strong>Gastos mensuales:</strong></label>
                            <input type="number" class="form-control" wire:model="bills">
                            @error('bills')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label><strong>Modelo de Negocio/Bussiness Plan:</strong></label>
                            <input type="file" class="form-control" wire:model="business_plan">
                            @error('business_plan')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary pull-right" wire:click="store()"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                <button type="button" class="btn btn-default pull-right"
                    wire:click="cancel()"><i class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
