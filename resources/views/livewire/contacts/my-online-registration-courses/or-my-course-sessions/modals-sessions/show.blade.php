<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-file-text-o"></i>&nbsp;Informacion de la sesion
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <table class="table table-striped">
                            <tr>
                                <th>
                                    <li>Descripción :</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $description }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Curso :</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $course }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Fecha de inicio :</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $start_date }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Fecha fin :</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $end_date }}</td>
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
