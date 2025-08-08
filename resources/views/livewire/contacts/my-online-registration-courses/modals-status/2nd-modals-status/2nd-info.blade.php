<style>
    /* Prevenir el desplazamiento en el fondo cuando el modal está abierto */
    .modal-open {
        overflow: hidden;
    }

    /* Asegurar que el modal tenga scroll en su contenido */
    .modal-dialog-scrollable .modal-body {
        overflow-y: auto;
        max-height: calc(100vh - 200px);
        /* Ajusta la altura del modal según sea necesario */
    }
</style>
<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="2nd-info-1-modal" role="dialog" style="z-index: 100002;">
    <div class="modal-dialog  modal-dialog-scrollable" role="document"">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    onclick="$('#2nd-info-1-modal').modal('hide'); $('#info-modal').modal('show')"
                    wire:click="cancel_2nd()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-file-text-o"></i>&nbsp; Video explicativo
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12" style="font-size: 16px; line-height: 1.5; text-align: justify;">
                        @if ($embedVideo)
                            {!! $embedVideo !!}
                        @else
                            <p>No se ha ingresado ningún video</p>
                        @endif
                    </div>
                </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right"
                    onclick="$('#2nd-info-1-modal').modal('hide'); $('#info-modal').modal('show')"
                    wire:click="cancel_2nd()">
                    {{ __('voyager::generic.close') }}
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    // Script para bloquear el desplazamiento del fondo cuando el modal está abierto
    $(document).on('show.bs.modal', function() {
        $('body').css('overflow', 'hidden'); // Bloquea el scroll del fondo
    });

    $(document).on('hidden.bs.modal', function() {
        $('body').css('overflow', 'auto'); // Restaura el scroll del fondo cuando el modal se cierra
    });
</script>
