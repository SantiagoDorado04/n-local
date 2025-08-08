<div wire:ignore.self class="modal modal-success fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}" wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-pencil-square"></i>&nbsp;Detalles FAQ
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <table class="table table-bordered">
                            <tr>
                                <th class="text-center">Información Faq</th>
                            </tr>
                            <tr>
                                <th>Título</th>
                            </tr>
                            <tr>
                                <td><p>{{ $faq->title ?? '' }}</p></td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                            </tr>
                            <tr>
                                <td>{{ $faq->slug ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Descripción pregunta</th>
                            </tr>
                            <tr>
                                <td><p>{!! $faq->description_question ?? '' !!}</p></td>
                            </tr>
                            <tr>
                                <th>Categoría</th>
                            </tr>
                            <tr>
                                <td>{{ $faq->category->title ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Adjunto pregunta</th>
                            </tr>
                            <tr>
                                <td>
                                    @if ($faq->attached_question ?? '')
                                    <a href="{{ url('storage/'.substr($faq->attached_question ,7)) }}" class="btn btn-success sm-b" download style="text-decoration:none">
                                        <i class="fa fa-cloud-download"></i>&nbsp;Descargar
                                    </a>
                                @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Fecha de registro</th>
                            </tr>
                            <tr>
                                <td>{{ $faq->date_question ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Usuario quien hizo la pregunta</th>
                            </tr>
                            <tr>
                                <td>{{ $faq->questionUser->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Estado</th>
                            </tr>
                            <tr>
                                <td>{{ $faq->state ?? '' }}</td>
                            </tr>
                            <tr>
                                <th class="text-center">Detalles Respuesta</th>
                            </tr>
                            <tr>
                                <th>Descripción respuesta</th>
                            </tr>
                            <tr>
                                <td><p>{!! $faq->description_response ?? '' !!}</p></td>
                            </tr>
                            <tr>
                                <th>Adjunto respuesta</th>
                            </tr>
                            <tr>
                                <td>
                                    @if ($faq->attached_response ?? '')
                                    <a href="{{ url('storage/'.substr($faq->attached_response ,7)) }}" class="btn btn-success sm-b" download style="text-decoration:none">
                                        <i class="fa fa-cloud-download"></i>&nbsp;Descargar
                                    </a>
                                @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Fecha de respuesta</th>
                            </tr>
                            <tr>
                                <td>{{ $faq->date_response ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Usuario quien hizo la respuesta</th>
                            </tr>
                            <tr>
                                <td>{{ $faq->responseUser->name ?? '' }}</td>
                            </tr>
                        </table>
                        
                        
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i class="fa fa-ban"></i>
                    &nbsp;{{ __('voyager::generic.close') }}
                </button>
            </div>
        </div>
    </div>
</div>