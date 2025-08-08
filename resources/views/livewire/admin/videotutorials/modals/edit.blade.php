<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="edit-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}" wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-pencil-square"></i>&nbsp;Editar tutorial
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <label class="is-required"><strong>Título:</strong></label>
                        <input type="text" class="form-control" wire:model="title">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-lg-12">
                        <label class="is-required"><strong>Descripción:</strong></label>
                        <div wire:ignore>
                            <textarea class="form-control" rows="4" wire:model="description" id="content2" ></textarea>
                        </div>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-lg-12">
                        <label class="is-required"><strong>Embed:</strong></label>
                        <textarea class="form-control" rows="4" wire:model="embed"></textarea>
                        @error('embed')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-lg-12">
                        <label class=""><strong>Adjunto:</strong></label>
                        <input type="file" class="form-control" wire:model="attached_question">
                        @error('attached_question')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-lg-12">
                        <label class="is-required"><strong>Categoría:</strong></label>
                        <select class="form-control" wire:model="category_tutorials_id">
                            <option value="">Seleccionar</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                        @error('category_tutorials_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-lg-12">
                        <label class="is-required"><strong>Estado:</strong></label>
                        <select class="form-control" wire:model="state">
                            <option value="">Seleccionar</option>
                            <option value="borrador">Borrador</option>
                            <option value="publicado">Publicado</option>
                        </select>
                        @error('state')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary pull-right" wire:click="update()"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i class="fa fa-ban"></i>
                    &nbsp;{{ __('voyager::generic.close') }}
                </button>
            </div>
        </div>
    </div>
</div>