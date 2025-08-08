<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-list"></i>&nbsp;Detalles del reto y entregable
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <table class="table table-striped">
                            <tr>
                                <th>
                                    <li>Título:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $title }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Instrucción:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $instructions }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Fecha de entrega:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $delivery_date }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Puntos asignados:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $points }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Puntos requerdos:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $required_points }}</td>
                            </tr>
                            <tr>
                                <th><li>Mensaje de recordatorio:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $reminder_message }}</td>
                            </tr>
                            <tr>
                                <th><li>Fecha envío mensaje recordatorio:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $reminder_message_date }}</td>
                            </tr>
                            <tr>
                                <th><li>Medio envío mensaje recordatorio:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $reminder_message_mean }}</td>
                            </tr>
                            <tr>
                                <th><li>Mensaje de felicitacion:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $congratulation_message }}</td>
                            </tr>
                            <tr>
                                <th><li>Fecha de mensaje de felicitacion:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $congratulation_message_date }}</td>
                            </tr>
                            <tr>
                                <th><li>Medio de mensaje de felicitacion:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $congratulation_message_mean }}</td>
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
