<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-list"></i>&nbsp;Detalles del curso
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
                                    <li>Primero:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    @switch($first)
                                        @case(1)
                                            <p>sí</p>
                                        @break

                                    </td>
                                    @case(0)
                                        <p>no</p>
                                    @break

                                    @default
                                @endswitch
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Curso anterior:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    @if ($anterior)
                                        {{ $anterior }}
                                    @else
                                        Ninguno
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Siguiente curso:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    @if ($siguiente)
                                        {{ $siguiente }}
                                    @else
                                        Ninguno
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Duración (en semanas):</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $duration }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Fecha de inicio:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $start_date }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Fecha final:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $end_date }}</td>
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
                                    <li>Puntos requeridos:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $required_points }}</td>
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
                <button type="button" class="btn btn-default pull-right"
                    wire:click="cancel()">{{ __('voyager::generic.close') }}</button>
            </div>
        </div>
    </div>
</div>
