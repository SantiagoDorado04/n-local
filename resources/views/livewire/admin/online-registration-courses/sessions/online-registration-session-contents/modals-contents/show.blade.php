<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-list"></i>&nbsp;Detalles sesion
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>
                                    <li>Titulo:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $title }}</td>
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
                                    <li>Orden:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $step }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Tipo:</li>
                                </th>
                            </tr>
                            @if ($type == 'L')
                                <tr>
                                    <td>Lección</td>
                                </tr>
                            @elseif ($type == 'S')
                                <tr>
                                    <td>Slide</td>
                                </tr>
                            @elseif ($type == 'V')
                                <tr>
                                    <td>Video</td>
                                </tr>
                            @elseif ($type == 'T')
                                <tr>
                                    <td>Test</td>
                                </tr>
                            @else
                                <tr>
                                    <td>No pertenece a ningun tipo</td>
                                </tr>
                            @endif
                            <tr>
                                <th>
                                    <li>Curso:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $onlineRegistrationCourse->name }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Usuario creador del registro:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $user_created_at ?? 'Sin creador' }}</td>
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
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i class="fa fa-close"
                        aria-hidden="true"></i>&nbsp;{{ __('voyager::generic.close') }}</button>
            </div>
        </div>
    </div>
</div>
