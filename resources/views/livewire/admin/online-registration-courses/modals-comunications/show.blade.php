<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-list"></i>&nbsp; Informacion del formulario
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <table class="table table-striped table-bordered">
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
                                    <li>Canal:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $channel }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Message:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $message }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Acción:</li>
                                </th>
                            </tr>

                            @if ($action == 'CR')
                                <td>Registro a curso</td>
                            @elseif ($action == 'AC')
                                <td> Asignación de caracterización</td>
                            @elseif ($action == 'SA')
                                <td>Asistencia a sesión</td>
                            @elseif ($action == 'FC')
                                <td>Completado de contenido</td>
                            @else
                                {{ $action }}
                            @endif

                            <tr>
                                <th>
                                    <li>Usuario creador del registro:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $user_created_at }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Ultimo usuario en modificar:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $user_updated_at ?? 'Sin modificación' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i
                        class="fa fa-close"></i>&nbsp;{{ __('voyager::generic.close') }}</button>
            </div>
        </div>
    </div>
</div>
