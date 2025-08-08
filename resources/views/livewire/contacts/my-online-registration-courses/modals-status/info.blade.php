@include('livewire.contacts.my-online-registration-courses.modals-status.2nd-modals-status.2nd-info')
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
<div wire:ignore.self class="modal modal-info fade" tabindex="-2" data-backdrop="static" data-keyboard="false"
    id="info-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content modal-dialog-scrollable">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-file-text-o"></i>&nbsp;Mi estado en el curso
                </h5>
            </div>
            @if ($certificate == false)
                <div class="modal-body">
                    <div class="row no-margin-bottom">
                        <div class="col-lg-12" style="font-size: 16px; line-height: 1.5; text-align: justify;">
                            <p><strong>No cumplió los requisitos para la certificación.</strong></p>
                            <p>Si tiene alguna solicitud, por favor contacte con el docente del curso.</p>
                        </div>
                    </div>
                </div>
            @elseif (($certificate && $existArchive) || $courseDocument->isEmpty())
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" style="font-size: 16px; line-height: 1.5; text-align: justify;">
                            <p><strong>Certificado:</strong> <span class="text-success">Si</span></p>

                            <p><strong>Descargas De Documentos:</strong></p>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th colspan="2">Nombre</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($courseDocumentComplete) && $courseDocumentComplete->isNotEmpty())
                                            @foreach ($courseDocumentComplete as $document)
                                                <tr>
                                                    <td colspan="2">{{ $document->name ?? 'Sin nombre' }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center justify-content-start"
                                                            style="gap: 0.5rem; overflow-x: auto; white-space: nowrap;">
                                                            <a href="{{ route('descargar.certificado', ['id' => $document->id, 'contactId' => $contactId]) }}"
                                                                class="btn btn-success" data-bs-toggle="tooltip"
                                                                title="Descargar documento">
                                                                <i class="fa fa-download"></i>Descargar
                                                            </a>
                                                            <!-- Botón de explicación -->
                                                            <button class="btn btn-primary" data-toggle="modal"
                                                                title="Clic para ver la explicación"
                                                                data-target="#2nd-info-1-modal"
                                                                onclick="$('#info-modal').modal('hide')"
                                                                wire:click="status_video({{ $document->id }})">
                                                                <i class="fa fa-info-circle"></i> Ver Explicación
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center">No hay documentos para descargar
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if ($courseDocumentNoRequired->isEmpty())
                            @else
                                <p><strong>Estos Documentos Son Opcionales:</strong></p>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-light">
                                            <tr>
                                                <th colspan="2">Nombre</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($courseDocumentNoRequired as $document)
                                                <tr>
                                                    <td colspan="2">{{ $document->name ?? 'Sin nombre' }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center justify-content-start"
                                                            style="gap: 0.5rem; overflow-x: auto; white-space: nowrap;">

                                                            @if (!$document->sent)
                                                                <!-- Subir archivo -->
                                                                <label
                                                                    class="btn btn-outline-secondary btn-sm mb-1 mb-sm-0">
                                                                    <i class="fa fa-upload"></i> Subir
                                                                    <input wire:model="file" type="file" hidden>
                                                                </label>


                                                                <!-- Enviar -->
                                                                <button class="btn btn-sm btn-success"
                                                                    wire:click="upload_file({{ $document->id }})">
                                                                    <i class="fa fa-send"></i>&nbsp;Enviar
                                                                </button>
                                                                @error('file')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror

                                                                <a wire:click='downloadDocument(@json($document->url))'
                                                                    class="btn btn-warning" target="_blank" download>
                                                                    Descargar
                                                                </a>

                                                                <!-- Explicación -->
                                                                <button class="btn btn-primary" data-toggle="modal"
                                                                    title="Clic para ver la explicación"
                                                                    onclick="$('#info-modal').modal('hide')"
                                                                    data-target="#2nd-info-1-modal"
                                                                    wire:click="status_video({{ $document->id }})">
                                                                    <i class="fa fa-info-circle"></i> Ver Explicación
                                                                </button>
                                                            @else
                                                                <span class="">
                                                                    <i class="fa fa-check-circle"></i> Enviado
                                                                </span>
                                                            @endif

                                                            <!-- Descargar (siempre disponible o solo si se envió, según prefieras) -->

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            <p><strong>Historial De Descargas:</strong></p>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th colspan="2">Nombre</th>
                                            <th>Última descarga</th>
                                            <th>Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($registers) && $registers->isNotEmpty())
                                            @foreach ($registers as $register)
                                                <tr>
                                                    <td colspan="2">
                                                        {{ $register->document->name ?? 'Sin documento' }}</td>
                                                    <td>{{ $register->last_download_date ?? '' }}</td>
                                                    <td>{{ $register->count_downloads ?? '' }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center">No hay registros de descarga</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($certificate && !$existArchive)
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12" style="font-size: 16px; line-height: 1.5; text-align: justify;">
                            <p><strong>Certificado:</strong> <span class="text-danger">Pendiente</span></p>

                            <p><strong>Mi Certificado:</strong></p>
                            <p>Sin emitir. Para poder recibir su certificado, debe entregar los siguientes documentos:
                            </p>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th colspan="2">Nombre</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($courseDocument as $document)
                                            <tr>
                                                <td colspan="2">{{ $document->name ?? 'Sin nombre' }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-start"
                                                        style="gap: 0.5rem; overflow-x: auto; white-space: nowrap;">

                                                        @if (!$document->sent)
                                                            <!-- Subir archivo -->
                                                            <label
                                                                class="btn btn-outline-secondary btn-sm mb-1 mb-sm-0">
                                                                <i class="fa fa-upload"></i> Subir
                                                                <input wire:model="file" type="file" hidden>
                                                            </label>

                                                            <!-- Enviar -->
                                                            <button class="btn btn-sm btn-success" wire:model="file"
                                                                wire:click="upload_file({{ $document->id }})">
                                                                <i class="fa fa-send"></i>&nbsp;Enviar
                                                            </button>

                                                            @error('file')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror

                                                            <a wire:click='downloadDocument(@json($document->url))'
                                                                class="btn btn-warning" target="_blank" download>
                                                                Descargar
                                                            </a>

                                                            <!-- Explicación -->
                                                            <button class="btn btn-primary" data-toggle="modal"
                                                                title="Clic para ver la explicación"
                                                                data-target="#2nd-info-1-modal"
                                                                onclick="$('#info-modal').modal('hide')"
                                                                wire:click="status_video({{ $document->id }})">
                                                                <i class="fa fa-info-circle"></i> Ver Explicación
                                                            </button>
                                                        @else
                                                            <span class="">
                                                                <i class="fa fa-check-circle"></i> Enviado
                                                            </span>
                                                        @endif

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            @endif
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right"
                    wire:click="cancel()">{{ __('voyager::generic.close') }}</button>
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
