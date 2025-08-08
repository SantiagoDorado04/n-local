<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-check-square-o"></i>
                    Respuestas diligenciamiento de información
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                        @if ($contactProposal != [])
                            @foreach ($contactProposal->proposal->questions as $pregunta)
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="{{ $pregunta->key }}"><strong>{{ $pregunta->question }}</strong></label>
                                    <input type="text" class="form-control" name="{{ $pregunta->key }}" value="{{ $answers[$pregunta->key] ?? '' }}">
                                </div>
                            </div>
                            @endforeach
                        @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i
                        class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.close') }}</button>
            </div>
        </div>
    </div>
</div>
