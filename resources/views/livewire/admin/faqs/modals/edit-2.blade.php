<div wire:ignore.self class="modal modal-success fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="edit-modal-2" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}" wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-pencil-square"></i>&nbsp;Responder FAQ
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12 text-center">
                        <h5>Información Faq</h5>
                    </div>
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
                            <textarea class="form-control" rows="4" wire:model="description_question" id="content3" >{!! $description_question  !!}</textarea>
                        </div>
                        @error('description_question')
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
                        <select class="form-control" wire:model="category_faq_id">
                            <option value="">Seleccionar</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                        @error('category_faq_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-lg-12 text-center">
                        <h5>Información Respuesta</h5>
                    </div>

                    <div class="col-lg-12">
                        <label class="is-required"><strong>Descripción:</strong></label>
                        <div wire:ignore>
                            <textarea class="form-control" rows="4" wire:model="description_response" id="content4" >{!! $description_response  !!}</textarea>
                        </div>
                        @error('description_response')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-lg-12">
                        <label class=""><strong>Adjunto:</strong></label>
                        <input type="file" class="form-control" wire:model="attached_response">
                        @error('attached_response')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary pull-right" wire:click="confirmReply()"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i class="fa fa-ban"></i>
                    &nbsp;{{ __('voyager::generic.close') }}
                </button>
            </div>
        </div>
    </div>
</div>