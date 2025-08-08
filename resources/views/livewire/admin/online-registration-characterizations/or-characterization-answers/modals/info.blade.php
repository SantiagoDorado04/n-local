<div wire:ignore.self class="modal modal-primary fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="info-modal-2" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-news"></i>&nbsp;Diligenciar caracterización - {{ $form->name }}
                </h5>
            </div>

            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <small>
                                    <ul>
                                        <li><strong>Curso:</strong> {{ $form->session->onlineRegistrationCourse->name }}
                                        </li>
                                        <li><strong>Sesión:</strong> {{ $form->session->name }}</li>
                                        <li><strong>Caracterización:</strong> {{ $form->name }}</li>
                                    </ul>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($questionsInfo && $questionsInfo->isNotEmpty())
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Preguntas </th>
                            </tr>
                        </thead>
                    </table>

                    <tbody>
                        <form wire:submit.prevent="saveResponses">
                            @foreach ($questionsInfo as $question)
                                <div class="row no-margin-bottom">
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
                                                        @if ($question->type == 'OM')
                                                            <div>
                                                                @foreach ($question->options as $option)
                                                                    <input type="checkbox"
                                                                        wire:model="answers.question_{{ $question->id }}.{{ $loop->index }}"
                                                                        value="{{ $option->id }}"
                                                                        id="option_{{ $option->id }}">
                                                                    <label
                                                                        for="option_{{ $option->id }}">{{ $option->text }}</label><br>
                                                                @endforeach

                                                            </div>
                                                        @elseif ($question->type == 'OS')
                                                            <div>
                                                                @foreach ($question->options as $option)
                                                                    <input type="radio"
                                                                        name="question_{{ $question->id }}"
                                                                        wire:model.defer="answers.question_{{ $question->id }}"
                                                                        value="{{ $option->id }}">
                                                                    <label
                                                                        for="option_{{ $option->id }}">{{ $option->text }}</label>
                                                                    <br>
                                                                @endforeach
                                                            </div>
                                                        @elseif ($question->type == 'AC')
                                                            <input type="text"
                                                                wire:model.defer="answers.question_{{ $question->id }}"
                                                                class="form-control">
                                                        @elseif ($question->type == 'AL')
                                                            <textarea wire:model.defer="answers.question_{{ $question->id }}" class="form-control" rows="4"></textarea>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <button type="submit" class="btn btn-primary">Guardar Respuestas</button>
                        </form>
                    @else
                        <br>
                        <h2 class="text-muted text-center">Aún no hay preguntas disponibles</h2>
                @endif

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()">
                    <i class="fa fa-close"></i>&nbsp;{{ __('voyager::generic.close') }}
                </button>
            </div>
        </div>
    </div>
</div>
