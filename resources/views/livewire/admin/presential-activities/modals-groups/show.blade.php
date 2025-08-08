<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-list"></i>&nbsp;Detalles del grupo
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
                                    <li>Fecha:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $date }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Hora:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $hour }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Cupo:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $quota }}</td>
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
