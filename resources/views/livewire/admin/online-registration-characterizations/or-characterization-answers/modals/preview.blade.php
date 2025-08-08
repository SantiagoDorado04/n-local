<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="info-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-eye"></i>
                    Visualización del formulario
                </h5>
            </div>
            <div class="modal-body">
                @if ($preview && $preview->isNotEmpty())
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Pregunta </th>
                                <th>Respuesta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($preview as $item)
                                <tr>
                                    <td>{{ $item->question->text }}</td>
                                    <td>{{ $item->answer_text }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <p class="text-center">No hay respuestas disponibles.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" wire:click="cancel()"><i
                        class="fa fa-close"></i>&nbsp;{{ __('voyager::generic.close') }}</button>
            </div>
        </div>
    </div>
</div>
