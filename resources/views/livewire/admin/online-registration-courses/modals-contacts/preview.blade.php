<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="info-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-list"></i>&nbsp;Preguntas y respuestas
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        @if ($onlineRegistrationCourse)
                            @if ($preview && $preview->isNotEmpty())
                                <div class="row no-margin-bottom">
                                    <div class="col-lg-12">
                                        <div class="panel panel-bordered">
                                            <div class="panel-body">
                                                <h4>{{ $preview->first()->question->form->name ?? 'Formulario' }}</h4>
                                                <p>{{ $preview->first()->question->form->description ?? '' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    @foreach ($preview as $answer)
                                        @if ($answer->question)
                                            <div class="col-md-12">
                                                <div class="panel panel-bordered">
                                                    <div class="panel-body">
                                                        <div class="row no-margin-bottom">
                                                            <div class="col-md-1">
                                                                <strong>{{ $loop->iteration }}</strong>
                                                            </div>
                                                            <div class="col-md-11">
                                                                <p>{{ $answer->question->text }}</p>

                                                                @if (in_array($answer->question->type, ['OM', 'OS']) && $answer->question->options)
                                                                    @foreach ($answer->question->options as $option)
                                                                        <label for="option_{{ $option->id }}"
                                                                            class="radio-option">
                                                                            {{ $option->text }} ({{ $option->value }})
                                                                        </label><br>
                                                                    @endforeach
                                                                @endif

                                                                {{-- Mostrar respuesta del usuario --}}
                                                                @php
                                                                    $userAnswer = $answer->question->answers->where(
                                                                        'contact_id',
                                                                        $contactId,
                                                                    )->first();
                                                                    //dd($contactId);
                                                                @endphp

                                                                <div class="answer">
                                                                    <strong>Respuesta:</strong>
                                                                    @if ($userAnswer)
                                                                        @if (in_array($answer->question->type, ['OM', 'OS']))
                                                                            @php
                                                                                $answerValues = explode(
                                                                                    ',',
                                                                                    $userAnswer->answer,
                                                                                );
                                                                                $optionTexts = $answer->question->options
                                                                                    ->whereIn('id', $answerValues)
                                                                                    ->pluck('text')
                                                                                    ->toArray();
                                                                            @endphp
                                                                            <p>{{ implode(', ', $optionTexts) }}</p>
                                                                        @else
                                                                            <p>{{ $userAnswer->answer }}</p>
                                                                        @endif
                                                                    @else
                                                                        <p>No se respondió esta pregunta.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <p>No hay preguntas disponibles para el formulario.</p>
                            @endif
                        @else
                            <p>No se encontró el escenario.</p>
                        @endif

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
