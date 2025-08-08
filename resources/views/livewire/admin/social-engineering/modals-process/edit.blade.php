<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="edit-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-list"></i>&nbsp;Proceso de ingeniería social
                </h5>
            </div>
            @if ($process != '')
                <form wire:submit.prevent="update(Object.fromEntries(new FormData($event.target)))" id="social-form"
                    autocomplete="off">
                    <div class="modal-body">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <div class="row no-margin-bottom">
                                    <div class="col-lg-12 text-center">
                                        <h5>Preguntas Generales</h5>
                                    </div>
                                    @foreach ($gQuestions as $gQuestion)
                                        <div class="col-lg-12">
                                            <label><strong>{{ $loop->iteration . '. ' }}{{ $gQuestion->question }}</strong></label>
                                            <textarea class="form-control" rows="2" name='question_{{ $gQuestion->id }}'>{{ $process->{'question_' . $gQuestion->id} }}</textarea>
                                            @if ($errors->has('question_' . $gQuestion->id))
                                                <span
                                                    class="text-danger">{{ $errors->first('question_' . $gQuestion->id) }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @if ($aQuestions != '')
                            <div class="panel panel-bordered">
                                <div class="panel-body">
                                    <div class="row no-margin-bottom">
                                        <div class="col-lg-12 text-center">
                                            <h5>Preguntas Acción Comercial</h5>
                                        </div>
                                        @foreach ($aQuestions as $aQuestion)
                                            <div class="col-lg-12">
                                                <label><strong>{{ $loop->iteration . '. ' }}{{ $aQuestion->question }}</strong></label>
                                                <textarea class="form-control" rows="2" name='question_{{ $aQuestion->id }}'>{{ $process->{'question_' . $aQuestion->id} }}</textarea>
                                                @if ($errors->has('question_' . $aQuestion->id))
                                                    <span
                                                        class="text-danger">{{ $errors->first('question_' . $aQuestion->id) }}</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary pull-right" type="submit"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                        <button type="button" class="btn btn-default pull-right"
                            wire:click="cancel()">{{ __('voyager::generic.close') }}</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
