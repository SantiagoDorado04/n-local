<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-list"></i>&nbsp;Detalles curso
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
                                    <li>Descripción:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $description }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Control de registro:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $onlineRegistrationCategory->onlineRegistration->name }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Activo:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $active == true ? 'Si' : 'No' }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Video:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{!! $embebed_video !!}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Arte o poster :</li>
                                </th>
                            </tr>
                            <td>
                                @if ($logo_file)
                                    @if (Str::endsWith($logo_file, ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ Storage::url($logo_file) }}" alt="Imagen adjunta" class="img-fluid"
                                            style="max-width: 100px; max-height: 100px;">
                                    @else
                                        <a href="{{ Storage::url($logo_file) }}" target="_blank">Ver archivo</a>
                                    @endif
                                @else
                                    <span>No se ha subido un archivo</span>
                                @endif

                            </td>
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
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i class="fa fa-close"
                        aria-hidden="true"></i>&nbsp;{{ __('voyager::generic.close') }}</button>
            </div>
        </div>
    </div>
</div>
