<div wire:ignore.self class="modal modal-primary fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="show-modal-2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}" wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-eye"></i>&nbsp;Detalles Respuesta
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <table class="table table-bordered">
                            <tr>
                                <th class="text-center">Información Respuesta</th>
                            </tr>
                            <tr>
                                <th>Descripción</th>
                            </tr>
                            <tr>
                                <td>{!! $response->body_response ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>Adjunto</th>
                            </tr>
                            <tr>
                                <td>
                                    @if ($response->response_attached ?? '')
                                    <a href="{{ url('storage/'.substr($support->response_attached,7)) }}" class="btn btn-success sm-b" download style="text-decoration:none">
                                        <i class="fa fa-cloud-download"></i>&nbsp;Descargar
                                    </a>
                                    @else
                                        No se han cargado archivos
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Fecha de respuesta</th>
                            </tr>
                            <tr>
                                <td>{{ $response->date_response ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Quién respondió</th>
                            </tr>
                            <tr>
                                <td>{{ $response->responseUser->name ?? '' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>