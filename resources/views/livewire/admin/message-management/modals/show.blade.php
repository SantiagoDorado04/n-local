<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}" wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-list"></i>&nbsp;Detalles del mensaje
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <table class="table table-striped">
                            <tr>
                                <th><li>Título:</li></th>
                            </tr>
                            <tr>
                                <td>{{ $title }}</td>
                            </tr>
                            <tr>
                                <th><li>Mensaje:</li></th>
                            </tr>
                            <tr>
                                <td><textarea class="form-control" id="textarea" style="background-color:#fff" readonly rows="10">{{ $message }}</textarea></td>
                            </tr>
                            <tr>
                                <td>
                                    <button class="btn btn-primary" onclick="copy()"><i class="fa fa-files-o"></i>&nbsp;Copiar!</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" wire:click='cancel()'>{{ __('voyager::generic.close') }}</button>
            </div>
        </div>
    </div>
</div>

<script>
    function copy() {
        let textarea = document.getElementById("textarea");
        textarea.select();
        document.execCommand("copy");
        toastr['success']('Texto copiado correctamente!');
    }
</script>    
