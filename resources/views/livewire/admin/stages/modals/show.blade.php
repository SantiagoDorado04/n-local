<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}" wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-list"></i>&nbsp;Detalles etapa
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th><li>Nombre:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $name }}</td>
                            </tr>
                            <tr>
                                <th><li>Descripción:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $description }}</td>
                            </tr>
                            <tr>
                                <th><li>Proceso:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $process->name }}</td>
                            </tr>
                            <tr>
                                <th><li>Terreno comercial:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $landId }}</td>
                            </tr>
                            <tr>
                                <th><li>Estrategia comercial:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $strategyId }}</td>
                            </tr>
                            <tr>
                                <th><li>Acción comercial:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $actionId }}</td>
                            </tr>
                            <tr>
                                <th><li>Embebebido formulario:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $embebed ? $embebed : 'No aplica' }}</td>
                            </tr>
                            <tr>
                                <th><li>Enlace formulario externo:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $link ? $link : 'No aplica' }}</td>
                            </tr>
                            <tr>
                                <th><li>Estado:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $active == 1 ? 'Activo' : 'Inactivo' }}</td>
                            </tr>
                            <tr>
                                <th><li>Video:</li></th>
                            </tr>
                            <tr>
                                <td>{!! $embebedVideo !!}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i class="fa fa-close" aria-hidden="true"></i>&nbsp;{{ __('voyager::generic.close') }}</button>
            </div>
        </div>
    </div>
</div>
