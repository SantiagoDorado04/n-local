<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="create-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Nueva Pregunta
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="is-required"><strong>Texto: </strong></label>
                            <input type="text" class="form-control" wire:model="text"
                                placeholder="Texto de la pregunta">
                            @error('text')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="is-required"><strong>Prompt: </strong></label>
                            <textarea class="form-control" wire:model="prompt" rows="4" placeholder="Escriba aquí el prompt..."></textarea>
                            @error('prompt')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="text-muted">
                                Use la sintaxis <code>[$variable]</code> para definir variables que luego podrá usar en
                                el prompt.
                                Ejemplo de prompt: <em>Hola $nombreEmpresa con nit $nit</em>
                            </small>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label for="guideBuilder"><strong>Guía (preguntas)</strong></label>

                            <div class="d-flex mb-3">
                                <input type="text" wire:model.defer="newGuideText" class="form-control mr-2"
                                    placeholder="Ej: nombre de la persona">
                                <button type="button" wire:click="addGuideField"
                                    class="btn btn-primary">Agregar</button>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Variable</th>
                                        <th>Texto de la pregunta</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable-guide">
                                    @foreach ($guideFields as $variable => $text)
                                        <tr data-id="{{ $variable }}">
                                            <td>[${{ $variable }}]</td>
                                            <td>{{ $text }}</td>
                                            <td class="d-flex gap-1">
                                                <button type="button"
                                                    wire:click="removeGuideField('{{ $variable }}')"
                                                    class="btn btn-danger btn-sm">Eliminar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Vista previa del JSON -->
                            {{-- <div class="mt-3">
                                <label><strong>Vista previa JSON:</strong></label>
                                <pre class="bg-light p-2 border rounded" style="max-height: 250px; overflow:auto;">
{{ $guide }}
        </pre>
                            </div> --}}
                        </div>
                        <br>
                        <br>
                        <div class="form-group mt-4">
                            <label for="contexts"><strong>Contextos (preguntas relacionadas)</strong></label>

                            <div class="d-flex mb-3">
                                <select wire:model="questionToAdd" class="form-control mr-2">
                                    <option value="">-- Selecciona una pregunta --</option>
                                    @foreach ($questions as $q)
                                        @if ($q->id != $questionId)
                                            <option value="{{ $q->id }}">{{ $q->text }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="button" wire:click="addQuestionToList"
                                    class="btn btn-primary">Agregar</button>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Texto</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($selectedQuestions as $qId)
                                        @php
                                            $qData = $questions->firstWhere('id', $qId);
                                        @endphp
                                        @if ($qData)
                                            <tr>
                                                <td>{{ $qData->id }}</td>
                                                <td>{{ $qData->text }}</td>
                                                <td>
                                                    <button type="button"
                                                        wire:click="removeQuestionFromList({{ $qData->id }})"
                                                        class="btn btn-danger btn-sm">Eliminar</button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Vista previa JSON -->
                            {{-- <div class="mt-3">
                                <label><strong>Vista previa JSON (contexts):</strong></label>
                                <pre class="bg-light p-2 border rounded" style="max-height: 250px; overflow:auto;">
{{ $questionsJson }}
        </pre>
                            </div> --}}
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary pull-right" wire:click="store()"><i
                        class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i
                        class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
