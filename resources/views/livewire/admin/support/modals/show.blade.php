<div wire:ignore.self class="modal modal-success fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}" wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-pencil-square"></i>&nbsp;Detalles Soporte
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <table class="table table-bordered">
                            <tr>
                                <th class="text-center">Información Soporte</th>
                            </tr>
                            <tr>
                                <th>Asunto</th>
                            </tr>
                            <tr>
                                <td>{{ $support->subject ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                            </tr>
                            <tr>
                                <td>{{ $support->slug ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Descripción</th>
                            </tr>
                            <tr>
                                <td>{!! $support->body ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>Categoría</th>
                            </tr>
                            <tr>
                                <td>{{ $support->category->title ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Adjunto</th>
                            </tr>
                            <tr>
                                <td>
                                    @if ($support->support_attached ?? '')
                                    <a href="{{ url('storage/'.substr($support->support_attached,7)) }}" class="btn btn-success sm-b" download style="text-decoration:none">
                                        <i class="fa fa-cloud-download"></i>&nbsp;Descargar
                                    </a>
                                    @else
                                        No se han cargado archivos
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Nivel</th>
                            </tr>
                            <tr>
                                <td>{{ $support->level_support ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Estado</th>
                            </tr>
                            <tr>
                                <td>{{ $support->state_support ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Fecha de registro</th>
                            </tr>
                            <tr>
                                <td>{{ $support->date_support ?? '' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>