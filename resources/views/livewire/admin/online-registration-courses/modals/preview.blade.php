<div wire:ignore.self class="modal modal-info fade " tabindex="-1" data-backdrop="static" data-keyboard="false"
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
                @if ($onlineRegistrationCourse)
                    @if ($form)
                        @if (count($form->questions) > 0)
                            <div class="row no-margin-bottom">
                                <div class="col-lg-12">
                                    <div class="panel panel-bordered">
                                        <div class="panel-body">
                                            <h4>{{ $form->name }}</h4>
                                            <p>{{ $form->description }}</p>
                                        </div>
                                    </div>
                                </div>
                                @foreach ($form->questions as $question)
                                    <div class="col-md-12">
                                        <div class="panel panel-bordered">
                                            <div class="panel-body">
                                                <div class="row no-margin-bottom">
                                                    <div class="col-md-1">
                                                        <strong>{{ $loop->iteration . '. ' }}</strong>
                                                    </div>
                                                    <div class="col-md-11">
                                                        <p>{{ $question->text }}</p>
                                                        {!! nl2br($question->question) !!}
                                                        @if ($question->type == 'OM' || $question->type == 'OS')
                                                            @if ($question->options)
                                                                @foreach ($question->options as $option)
                                                                    <input
                                                                        type="{{ $question->type == 'OM' ? 'checkbox' : 'radio' }}"
                                                                        id="option_{{ $option->id }}"
                                                                        name="question_{{ $question->id }}{{ $question->type == 'OM' ? '[]' : '' }}"
                                                                        value="{{ $option->id }}">
                                                                    <label for="option_{{ $option->id }}"
                                                                        class="radio-option">{{ $option->text }}</label><br>
                                                                @endforeach
                                                            @else
                                                                <p>No hay opciones disponibles para esta pregunta.</p>
                                                            @endif
                                                        @elseif ($question->type == 'AD')
                                                            <input type="file" name="question_{{ $question->id }}"
                                                                accept="image/*">
                                                        @elseif ($question->type == 'AC')
                                                            <input type="text" class="form-control"
                                                                name="question_{{ $question->id }}">
                                                        @elseif ($question->type == 'AL')
                                                            <textarea class="form-control" name="question_{{ $question->id }}"></textarea>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>No hay preguntas disponibles para el formulario "{{ $form->name }}"</p>
                        @endif
                    @else
                        <p>No se encontró el formulario.</p>
                    @endif
                @else
                    <p>No se encontró el escenario.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" wire:click="cancel()"><i
                        class="fa fa-close"></i>&nbsp;{{ __('voyager::generic.close') }}</button>
            </div>
        </div>
    </div>
</div>
