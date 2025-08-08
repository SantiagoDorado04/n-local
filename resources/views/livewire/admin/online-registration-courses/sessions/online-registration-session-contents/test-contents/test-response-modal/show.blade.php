<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-list"></i>&nbsp;Respuestas del test
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <table class="table table-striped table-bordered text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Pregunta</th>
                                    <th>Respuesta</th>
                                    <th>Es correcta</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $index => $question)
                                    <tr>
                                        <!-- Mostrar la pregunta -->
                                        <td>{{ $question->text }}</td>

                                        <!-- Mostrar la respuesta asociada -->
                                        <td>
                                            @if (isset($responseText[$index]))
                                                {{ $responseText[$index] }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>

                                        <!-- Mostrar si es correcta -->
                                        <td>
                                            @if (isset($responses[$index]))
                                                @if ($responses[$index]->is_correct)
                                                    <span class="">Correcto</span>
                                                @else
                                                    <span class="">Incorrecto</span>
                                                @endif
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
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
