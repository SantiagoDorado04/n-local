<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}" wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-list"></i>&nbsp;Detalles del mentor
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <table class="table table-striped">
                            <tr>
                                <th><li>Mentor:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $name }}</td>
                            </tr>
                            <tr>
                                <th><li>Email:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $email }}</td>
                            </tr>
                            <tr>
                                <th><li>Teléfono:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $phone }}</td>
                            </tr>
                            <tr>
                                <th><li>Duración de sesión:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $session_duration }}</td>
                            </tr>
                            <tr>
                                <th><li>Puntos asignados:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $points }}</td>
                            </tr>
                            <tr>
                                <th><li>Puntos requeridos:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $required_points }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Fecha limite de cancelacion:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $cancellation_deadline }}</td>
                            </tr>
                            <tr>
                                <th><li>Mensaje recordatorio:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $reminder_message }}</td>
                            </tr>
                            <tr>
                                <th><li>Fecha Mensaje recordatorio:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $reminder_message_date }}</td>
                            </tr>
                            <tr>
                                <th><li>Medio Mensaje recordatorio:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $reminder_message_mean }}</td>
                            </tr>
                            <tr>
                                <th><li>Mensaje felicitacion:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $congratulation_message }}</td>
                            </tr>
                            <tr>
                                <th><li>Fecha Mensaje felicitacion:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $congratulation_message_date }}</td>
                            </tr>
                            <tr>
                                <th><li>Medio Mensaje felicitacion:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $congratulation_message_mean }}</td>
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
