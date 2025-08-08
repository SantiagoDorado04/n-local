
<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="info-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}" wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-wpforms"></i>&nbsp;Previsualizaciónb del formulario
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        @if ($form!=[])
                            @livewire('admin.commercial-forms.commercial-form-preview-component',['form'=>$form->commercialForm->id])
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>