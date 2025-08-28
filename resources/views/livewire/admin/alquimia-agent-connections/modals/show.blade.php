<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-list"></i>&nbsp;Detalles proceso
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
                                    <li>Tipo:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $type }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Status:</li>
                                </th>
                            </tr>
                            <tr>
                                @php
                                    if ($type) {
                                        $status = 'activo';
                                    } else {
                                        $status = 'inactivo';
                                    }

                                @endphp
                                <td>{{ $status }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Url:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $url }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Transformador:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $responseTransformer }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Cuerpo de la solicitud:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $requestBody }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i
                        class="fa fa-close"></i>&nbsp;{{ __('voyager::generic.close') }}</button>
            </div>
        </div>
    </div>
</div>
