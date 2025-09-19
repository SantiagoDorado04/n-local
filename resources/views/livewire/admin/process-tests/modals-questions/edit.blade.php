<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="edit-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-pencil-square"></i>
                    Editar pregunta
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">

                        <div class="form-group">
                            <label class="is-required"><strong>Texto: </strong></label>
                            <input type="text" class="form-control" wire:model="text"
                                placeholder="Texto de la pregunta">
                            @error('text')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="is-required"><strong>Seleccione la categoria: </strong></label>
                            <select class="form-control" wire:model="categoryM">
                                <option value="">Seleccione una categoria</option>
                                @foreach ($processTestCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($categoryM != '')
                            <select class="form-control" wire:model="p_test_subcategory_id">
                                <option value="">Seleccione una subcategoría</option>
                                @foreach ($processTestSubcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                @endforeach
                            </select>
                            @error('p_test_subcategory_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary pull-right" wire:click="update()"><i
                        class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i
                        class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
