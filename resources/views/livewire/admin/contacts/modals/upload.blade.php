<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="info-modal-2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Importar contactos
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label><strong>Seleccionar archivo:</strong></label>
                            <input type="file" class="form-control" wire:model='fileContacts' id="fileContacts">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ url('storage/plantilla-contactos.xlsx') }}"><i class="fa fa-cloud-download"></i>&nbsp;Descargar
                            Plantilla</a>
                    </div>
                </div>
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        @if ($failures!='')
                        <div class="alert alert-danger" role="alert">
                            <strong>Errores:</strong>
                            <ul>
                                @foreach ($failures as $failure)
                                    @foreach ($failure->errors() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary pull-right" wire:click="uploadContacts()">Importar</button>
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()">{{
                    __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
</div>