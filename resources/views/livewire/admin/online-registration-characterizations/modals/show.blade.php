<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-list"></i>&nbsp;Detalles del formulario
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <table class="table table-striped">
                            <tr>
                                <th>
                                    <li>Nombre:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $name }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Descripción:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $description }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>tipo:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $type == 'S' ? 'Especifico' : 'General' }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Usuario creador del registro:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $user_created_at }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Ultimo usuario en modificar:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $user_updated_at ?? 'Sin modificación' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right"
                    wire:click="cancel()">{{ __('voyager::generic.close') }}</button>
            </div>
        </div>
    </div>
</div>
