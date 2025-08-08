<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="info-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Nuevo formulario widget
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <div class="row no-margin-bottom">
                                    <div class="col-md-12">
                                        <h5 class="text-center">{{ $form->name }}</h5>
                                    </div>
                                    <div class="col-md-12">
                                        <p>{{ $form->description }}</p>
                                    </div>
                                    @if ($result != [])
                                    @foreach ($questions as $question)
                                    <div class="col-md-12">
                                        <div class="panel panel-bordered">
                                            <div class="panel-body">
                                                <div class="row no-margin-bottom">
                                                    <div class="col-md-1">
                                                        <strong>{{ $loop->iteration . '. ' }}</strong>
                                                    </div>
                                                    <div class="col-md-11">
                                                        {!! nl2br($question->question) !!}
                                                        @if ($question->type == 'po')
                                                        <br>
                                                        <br>
                                                        @foreach ($options as $option)
                                                        @php
                                                        $find = false;
                                                        @endphp
                                                        @if ($option->commercial_form_question_id == $question->id)
                                                        <input type="radio" @if ($option->value ==
                                                        $result[0]->{'question_' . $question->id})

                                                        @php
                                                        $find=true;
                                                        @endphp
                                                        checked @endif>
                                                        <label for="html">
                                                            <span @if ($find==true)
                                                                style="background-color:rgb(180, 255, 196)" @endif>
                                                                {{ $option->option }}
                                                            </span></label><br>
                                                        @endif
                                                        @endforeach
                                                        @else
                                                        <br>
                                                        <br>
                                                        <textarea
                                                            class="form-control">{{ $result[0]->{'question_' . $question->id} }}</textarea>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right"
                    wire:click="cancel()"><i class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
</div>