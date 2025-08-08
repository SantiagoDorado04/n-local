<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}" wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-list"></i>&nbsp;Detalles terreno comercial
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <table class="table table-bordered">
                            <tr>
                                <td><strong>Nombre:</strong></td>
                                <td>{{ $name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Descripción:</strong></td>
                                <td>{{ $description }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nivel de desarrollo:</strong></td>
                                <td>{{ $development_level_id !='' ? App\DevelopmentLevel::find($development_level_id)->name : '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Clientes / beneficiarios actuales y proyecciones</strong></td>
                                <td>{{ $beneficiaries }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()">{{ __('voyager::generic.close') }}</button>
            </div>
        </div>
    </div>
</div>
