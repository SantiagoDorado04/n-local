<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-list"></i>&nbsp;Detalles opciones
                </h5>
            </div>
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
                                    <li>Valor:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $value }}</td>
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
                                    <li>Puntos:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $points }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Pregunta:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $question->text }}</td>
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
