<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="create-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Diligenciamiento de información
                </h5>
            </div>
            <form wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))" id="form">
                <div class="modal-body">
                    <div class="row no-margin-bottom">
                        @if ($contactProposal != [])
                            @if ($contactProposal->proposal->questions!=[])
                                @foreach ($contactProposal->proposal->questions as $pregunta)
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="{{ $pregunta->key }}"><strong>{{ $pregunta->question }}</strong></label>
                                            <input type="text" class="form-control" name="{{ $pregunta->key }}" value="{{ $answers[$pregunta->key] ?? '' }}" required >
                                        </div>
                                    </div>
                                @endforeach
                            @else
                            <div class="col-lg-12 text-center">
                                <h5>Sin preguntas</h5>
                            </div>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary pull-right"><i
                            class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                    <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i
                            class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.livewire.on('reset-form', () => {
        document.getElementById("form").reset();
    });
</script>
