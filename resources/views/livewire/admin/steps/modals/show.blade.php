<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-list"></i>&nbsp;Detalles del paso
                </h5>
            </div>
            @php
                $stepType = $step_type;
                switch ($stepType) {
                    case 'F':
                        $stepType = 'Formulario';
                        break;
                    case 'M':
                        $stepType = 'Mentoria';
                        break;
                    case 'CD':
                        $stepType = 'Retos - Entregables';
                        break;
                    case 'FAA':
                        $stepType = 'Actividades presenciales';
                        break;
                    case 'LMS':
                        $stepType = 'Aprendizaje';
                        break;
                    case 'LZ':
                        $stepType = 'Liezo';
                        break;
                    case 'VE':
                        $stepType = 'Video Entrevista';
                        break;
                    default:
                        $stepType = 'No definido';
                        break;
                }

            @endphp
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
                                    <li>Tipo de paso:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $stepType }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Orden:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $order }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Disponible desde:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $available_from }}</td>
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
