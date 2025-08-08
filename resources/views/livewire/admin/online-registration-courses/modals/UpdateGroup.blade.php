<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="edit-modal-2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Actualizar grupo del curso
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="channel-select"><strong>Canal:</strong></label>
                            <select wire:model="selectedChannelId" class="form-control" id="channel-select">
                                <option value="">Seleccione un canal</option>
                                @foreach ($channels as $channel)
                                    <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        @if (!empty($channelStructure))
                            <div class="form-group">
                                <label for="group-instance"><strong>Instancia del endpoint:</strong></label>
                                <input type="text" id="group-instance" wire:model="updateInstance"
                                    class="form-control" placeholder="Ej: /group/create/parquesoftnarino">
                            </div>
                            @if ($fullEndpointUrl)
                                <div class="form-group">
                                    <label><strong>Endpoint final:</strong></label>
                                    <div class="alert alert-info">
                                        {{ $fullEndpointUrl }}
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary pull-right" wire:click="updateWaGroup()"><i
                        class="fa fa-floppy-o"></i>&nbsp;Actualizar</button>
                @error('apikey')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i
                        class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
