<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="show-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Información de la actividad
                </h5>
            </div>
            @if ($event != '')
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                       
                            <table class="table table-bordered">
                                <tr>
                                    <td colspan="3" class="text-center"><strong>Información de la actividad</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th rowspan="7" style="border: 1px solid #ddd;"><small>Informacion de
                                            contacto</small></th>
                                <tr>
                                    <th><small>Nombre:</small></th>
                                    <td>{{ $event->contact_name }}</td>
                                </tr>
                                <tr>
                                    <th><small>NIT:</small></th>
                                    <td>{{ $event->nit }}</td>
                                </tr>
                                <tr>
                                    <th><small>Teléfono:</small></th>
                                    <td>{{ $event->phone }}</td>
                                </tr>
                                <tr>
                                    <th><small>Correo electrónico:</small></th>
                                    <td>{{ $event->email }}</td>
                                </tr>
                                <tr>
                                    <th><small>WhatsApp:</small></th>
                                    <td>{{ $event->whatsapp }}</td>
                                </tr>
                                <tr>
                                    <th><small>Nombre persona de contacto:</small></th>
                                    <td>{{ $event->contact_person_name }}</td>
                                </tr>
                                </tr>
                                <tr>
                                    <th><small>Responsable de la actividad:</small></th>
                                    <td colspan="2">{{ $event->agent_name }}</td>
                                </tr>
                                <tr>
                                    <th><small>Actividad:</small></th>
                                    <td colspan="2">{{ $event->task_title }}</td>
                                </tr>
                                <tr>
                                    <th><small>Descripción:</small></th>
                                    <td colspan="2">{{ $event->task_description }}</td>
                                </tr>
                                <tr>
                                    <th><small>Observaciones adicionales:</small></th>
                                    <td colspan="2">{{ $event->task_observations }}</td>
                                </tr>
                                <tr>
                                    <th><small>Fecha de la actividad:</small></th>
                                    <td colspan="2">
                                        @php
                                            echo $dias[date('w', strtotime($event->task_date_start))] . ', ' . date('d', strtotime($event->task_date_start)) . ' ' . $meses[date('n', strtotime($event->task_date_start)) - 1] . ' ' . date('Y', strtotime($event->task_date_start));
                                        @endphp
                                    </td>
                                </tr>
                                <tr>
                                    <th width="30%"><small>Hora de la actividad:</small></th>
                                    <td colspan="2">{{ date('h:i A', strtotime($event->task_time_start)) }}</td>
                                </tr>
                                <tr>
                                    <th width="30%"><small>Duración:</small></th>
                                    <td colspan="2">{{ $event->duration . ' minutos' }} </td>
                                </tr>
                                @if ($event->status == 'completed')
                                <tr>
                                    <td colspan="3" class="text-center"><strong>Resultado de la actividad</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th><small>Fecha finalización actividad:</small></th>
                                    <td colspan="2">
                                        @php
                                            echo $dias[date('w', strtotime($event->task_date_completed))] . ', ' . date('d', strtotime($event->task_date_completed)) . ' ' . $meses[date('n', strtotime($event->task_date_completed)) - 1] . ' ' . date('Y', strtotime($event->task_date_completed));
                                        @endphp
                                    </td>
                                </tr>
                                <tr>
                                    <th width="30%"><small>Hora finalización actividad:</small></th>
                                    <td colspan="2">{{ date('h:i A', strtotime($event->task_time_completed)) }}</td>
                                </tr>
                                <tr>
                                    <th width="30%"><small>Observaciones:</small></th>
                                    <td colspan="2">{{ $event->task_observations_completed }}</td>
                                </tr>
                                @endif
                            </table>
                       
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                @if ($event->status == 'assigned')
                    <button class="btn btn-success pull-right" wire:click="editEvent()">Actualizar</button>
                @endif
                <button type="button" class="btn btn-default pull-right"
                    wire:click="cancel()"><i class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
            </div>
            @endif
        </div>
    </div>
</div>
