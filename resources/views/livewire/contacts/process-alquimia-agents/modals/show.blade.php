<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="show-modal" role="dialog">
    <div wire:loading wire:target="generateFromChat">
        @include('partials.loader')
    </div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-list"></i>&nbsp;Generar texto con IA (Chat de guía)
                </h5>
            </div>

            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        {{-- Ventana de chat --}}
                        <div style="max-height:400px; overflow-y:auto; padding:12px; background:#f7f7f7; border-radius:8px;"
                            id="chatWindow">
                            @if (!empty($chatHistory))
                                @foreach ($chatHistory as $i => $msg)
                                    <div class="mb-4"
                                        style="display:flex; justify-content: {{ $msg['type'] === 'user' ? 'flex-end' : 'flex-start' }};">
                                        <div
                                            style="padding:12px 16px; border-radius:16px; max-width:80%;
                    background: {{ $msg['type'] === 'bot' ? '#eef2ff' : '#e6e6e6' }};
                    color:#111; font-size:15px; line-height:1.5;">
                                            {!! nl2br(e($msg['text'])) !!}
                                        </div>
                                    </div>
                                    <br>
                                @endforeach
                            @else
                                <div class="text-muted">Aquí aparecerán las preguntas del chat.</div>
                            @endif
                        </div>

                        {{-- Input o botón Generar --}}
                        <div class="mt-3">
                            @if (!$isFinishedChat)
                                <form wire:submit.prevent="sendChatAnswer" class="d-flex gap-2">
                                    <input wire:model.defer="currentMessage" wire:keydown.enter.prevent="sendChatAnswer"
                                        type="text" placeholder="Escribe tu respuesta..." class="form-control" />
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                </form>
                            @else
                                <div class="d-flex justify-content-between">
                                    <button wire:click="resetChat" class="btn btn-warning">Limpiar chat</button>
                                    <button wire:click="generateFromChat" class="btn btn-success"
                                        wire:loading.attr="disabled">
                                        <span wire:loading.remove>Generar</span>
                                        <span wire:loading>Generando...</span>
                                    </button>
                                </div>
                            @endif
                        </div>

                        {{-- Resultado de la IA: textarea editable --}}
                        @if ($generatedText !== '')
                            <hr>
                            <div class="mt-2">
                                <label><strong>Texto generado (edítalo si deseas):</strong></label>
                                <textarea class="form-control" wire:model.defer="generatedText" rows="10"></textarea>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" wire:click="cancel()">
                    {{ __('voyager::generic.close') }}
                </button>

                {{-- Solo se muestra si ya hay texto generado --}}
                @if ($generatedText !== '')
                    <button type="button" class="btn btn-success" wire:click="storeGeneratedText">Aceptar</button>
                @endif
            </div>
        </div>
    </div>
</div>
