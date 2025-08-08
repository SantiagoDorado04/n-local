<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-list"></i>&nbsp;Detalles de la pregunta:
                </h5>
            </div>
            @php
                $questionType = $type;
                switch ($questionType) {
                    case 'AC':
                        $questionType = 'Texto corto';
                        break;
                    case 'AL':
                        $$questionType = 'Texto largo';
                        break;
                    case 'OS':
                        $questionType = 'Opcion simple';
                        break;
                    case 'OM':
                        $questionType = 'Opcion multiple';
                        break;
                    case 'AD':
                        $questionType = 'Adjunto';
                        break;
                    default:
                        $questionType = 'No definido';
                        break;
                }

            @endphp
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <table class="table table-striped">
                            <tr>
                                <th>
                                    <li>Texto:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $text }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Tipo:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $questionType }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Posicion:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $position }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Formulario:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $form->name }}</td>
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
