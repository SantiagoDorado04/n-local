<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="create-modal-2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Importar nuevo paso
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="is-required"><strong>Seleccione el proceso: </strong></label>
                            <select class="form-control" wire:model="processM">
                                <option value="">Seleccione un proceso</option>
                                @foreach ($processes as $process)
                                    <option value="{{ $process->id }}">{{ $process->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Seleccione la etapa: </strong></label>
                            <select class="form-control" wire:model="stageM">
                                <option value="">Seleccione una etapa</option>
                                @foreach ($stagesList as $stage)
                                    <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Seleccione el paso: </strong></label>
                            <select class="form-control" wire:model="stepM">
                                <option value="">Seleccione un paso</option>
                                @foreach ($stepsList as $step)
                                    <option value="{{ $step->id }}">{{ $step->name .' ('. $step->step_type.')' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary pull-right" wire:click="duplicate()"><i
                        class="fa fa-floppy-o"></i>&nbsp;Duplicar</button>
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i
                        class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
