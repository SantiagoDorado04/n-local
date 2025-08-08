
<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
id="show-modal" role="dialog">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
            <h5 class="modal-title">
                <i class="fa fa-plus-square"></i>
                Información contacto
            </h5>
        </div>
        <div class="modal-body">
            <div class="row no-margin-bottom">
                <div class="col-lg-12">
                    <table class="table table-striped">
                        @if ($schedule != '')
                        <tr>
                            <th>- Estado</th>
                        </tr>
                        <tr>
                            <td>
                                @switch($schedule->status)
                                    @case('completed')
                                        Completado
                                        @break
                                    @case('assigned')
                                        Asignado
                                        @break
                                    @default
                                        
                                @endswitch
                            </td>
                        </tr>
                        <tr>
                            <th>- Agente asignado</th>
                        </tr>
                        <tr>
                            <td>{{ \App\Models\User::find($schedule->user_id)->name }}</td>
                        </tr>
                        <tr>
                            <th>- Fecha de asignación</th>
                        </tr>
                        <tr>
                            <td>
                                @php
                                echo $dias[date('w', strtotime($schedule->assignment_date))] . ', ' . date('d',
                                strtotime($schedule->assignment_date)) . ' ' . $meses[date('n',
                                strtotime($schedule->assignment_date)) - 1] . ' ' . date('Y',
                                strtotime($schedule->assignment_date)) .' - '. date('h:i A',
                                strtotime($schedule->assignment_date));
                                @endphp
                            </td>
                        </tr>
                        <tr>
                            <th>- Asignado por</th>
                        </tr>
                        <tr>
                            <td>{{ \App\Models\User::find($schedule->assigned_by)->name }}</td>
                        </tr>
                        <tr>
                            <th>- Observaciones asignación</th>
                        </tr>
                        <tr>
                            <td>@if ($schedule->observations_contact!='')
                                {{ $schedule->observations_contact }}
                            @else
                                Sin observaciones
                            @endif</td>
                        </tr>
                        <tr>
                            <th>- Fecha y hora cuando se debíó contactar</th>
                        </tr>
                        <tr>
                            <td>
                                @php
                                echo $dias[date('w', strtotime($schedule->date_to_contact))] . ', ' . date('d',
                                strtotime($schedule->date_to_contact)) . ' ' . $meses[date('n',
                                strtotime($schedule->date_to_contact)) - 1] . ' ' . date('Y',
                                strtotime($schedule->date_to_contact)) .' - '. date('h:i A',
                                strtotime($schedule->time_to_contact));
                                @endphp
                            </td>
                        </tr>

                        <tr>
                            <th>- Fecha y hora cuando se contactó</th>
                        </tr>
                        <tr>
                            <td>
                                @php
                                echo $dias[date('w', strtotime($schedule->date_contact))] . ', ' . date('d',
                                strtotime($schedule->date_contact)) . ' ' . $meses[date('n',
                                strtotime($schedule->date_contact)) - 1] . ' ' . date('Y',
                                strtotime($schedule->date_contact)) .' - '. date('h:i A',
                                strtotime($schedule->time_contact));
                                @endphp
                            </td>
                        </tr>
                        <tr>
                            <th>- Observaciones de contacto</th>
                        </tr>
                        <tr>
                            <td>@if ($schedule->observations_user!='')
                                {{ $schedule->observations_user }}
                            @else
                                Sin observaciones
                            @endif</td>
                        </tr>
                        @endif
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