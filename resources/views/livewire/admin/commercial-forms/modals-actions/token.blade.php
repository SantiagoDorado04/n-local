<div wire:ignore.self class="modal modal-primary fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="info-modal-2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}" wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-link"></i>&nbsp;Token para asignar formulario
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label><strong>Token:</strong></label>
                            <div class="input-group">
                                <input type="text" class="form-control" style="margin-top: 5px" value="{{ $token }}" id="token">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button" onclick="copy()">
                                        <i class="fa fa-files-o"></i>&nbsp;Copiar!
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
    <script>
        function copy() {
            var copyText = document.getElementById("token");
    
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);
    
            toastr.success('Enlace copiado!');
        }
    </script>
</div>
