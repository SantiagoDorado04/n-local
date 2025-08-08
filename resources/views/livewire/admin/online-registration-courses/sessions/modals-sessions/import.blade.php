<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="create-modal-2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Importar nueva sessión
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
                        @if ($processM)
                            <div class="form-group">
                                <label class="is-required"><strong>Seleccione la categoría: </strong></label>
                                <select class="form-control" wire:model="categoriesM">
                                    <option value="">Seleccione una categoría</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($categoriesM)
                                <div class="form-group">
                                    <label class="is-required"><strong>Seleccione el curso: </strong></label>
                                    <select class="form-control" wire:model="coursesM">
                                        <option value="">Seleccione un curso</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($coursesM)
                                    <div class="form-group">
                                        <label class="is-required"><strong>Seleccione la sessión: </strong></label>
                                        <select class="form-control" wire:model="sessionsM">
                                            <option value="">Seleccione una sessión</option>
                                            @foreach ($sessions as $session)
                                                <option value="{{ $session->id }}">{{ $session->name }}</option>
                                            @endforeach -
                                        </select>
                                    </div>
                                    @if ($sessionsM)
                                        <div class="form-group">
                                            <label class="is-required"><strong>Seleccione la sessión: </strong></label>
                                            <select class="form-control" wire:model="option">
                                                <option value="">Seleccione una opción</option>
                                                <option value="T">Todo</option>
                                                <option value="SF">Solo formularios</option>
                                                <option value="SC">Solo contenidos</option>
                                            </select>
                                        </div>
                                    @endif
                                @endif
                            @endif
                        @endif


                    </div>
                </div>
            </div>
            {{-- @php
                dd($option);
            @endphp --}}
            <div class="modal-footer">
                @if ($option && $sessionsM)
                    <button class="btn btn-primary pull-right" wire:click="duplicate()"><i
                            class="fa fa-floppy-o"></i>&nbsp;Duplicar</button>
                @endif
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i
                        class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
