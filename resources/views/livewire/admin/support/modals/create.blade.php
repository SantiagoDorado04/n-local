<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="create-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}" wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>&nbsp;Crear soporte
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <label class="is-required"><strong>Asunto:</strong></label>
                        <input type="text" class="form-control" wire:model="subject">
                        @error('subject')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-lg-12">
                        <label class="is-required"><strong>Descripción:</strong></label>
                        <div wire:ignore>
                            <textarea class="form-control" rows="4" wire:model="body" id="content" ></textarea>
                        </div>
                        @error('body')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-lg-12">
                        <label class=""><strong>Adjunto:</strong></label>
                        <input type="file" class="form-control" wire:model="attached_support">
                        @error('attached_support')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-lg-12">
                        <label class="is-required"><strong>Categoría:</strong></label>
                        <select class="form-control" wire:model="category_supports_id">
                            <option value="">Seleccionar</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                        @error('category_supports_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary pull-right" wire:click="store()"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i class="fa fa-ban"></i>
                    &nbsp;{{ __('voyager::generic.close') }}
                </button>
            </div>
        </div>
    </div>
</div>