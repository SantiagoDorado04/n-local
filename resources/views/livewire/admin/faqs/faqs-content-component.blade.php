<div>

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('faqs-content', ['id' => $faq->id]) }}">FAQ</a>
            </li>
            <li>
                Contenido FAQ
            </li>
        </ol>
    @endsection

    @section('page_title', 'Lecciones | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-file-text-o"></i>&nbsp;
                @if ($activeField == 'description_response')
                    Contenido Respuesta
                @else
                    Contenido Pregunta
                @endif
            </h1>
        </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin-bottom:0px">
                    <div class="panel-body" style="margin-bottom:0px">
                        <small>
                            <ul>
                                <li><strong>FAQ: </strong> {{ $faq->title }}</li>
                            </ul>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <div class="col-md-12">
                                    <div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <br>
                                            <div wire:ignore>
                                                <label class=""><strong>Descripcion:</strong></label>
                                                <textarea name="{{ $activeField }}" class="form-control" wire:model.debounce.500ms="{{ $activeField }}"></textarea>
                                            </div>
                                            @error($activeField)
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        @if ($activeField == 'description_response')
                                        <br><br>
                                            <div class="col-lg-12">
                                                <label class=""><strong>Adjunto:</strong></label>
                                                <input type="file" class="form-control"
                                                    wire:model="attached_response">
                                                @error('attached_response')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <br><br>
                                        @else
                                        <br><br>
                                            <div class="col-lg-12">
                                                <label class=""><strong>Adjunto:</strong></label>
                                                <input type="file" class="form-control"
                                                    wire:model="attached_question">
                                                @error('attached_question')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <br><br>
                                        @endif

                                    </div>
                                    <div class="text-center" style="margin-top: 20px;">
                                        <button class="btn btn-success sm-b" wire:click="store">
                                            <i class="fas fa-save"></i> Guardar Contenido
                                        </button>
                                    </div>
                                </div>
                                <!-- Previsualización -->
                                <div class="col-md-12">
                                    <div class="page-content browse container-fluid">
                                        <div class="row no-margin-bottom">
                                            <div class="col-md-12">
                                                <div class="panel panel-bordered" style="margin: 0px;height:730px">
                                                    <div class="panel-body" style="margin: 0px">
                                                        <div class="row no-margin-bottom">
                                                            <div class="col-lg-12">
                                                                <h5><strong>Previsualización</strong></h5>
                                                                <hr style="margin:0px; padding:0px">
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div>
                                                                    {!! $description_response !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@push('javascript')
    <script>
        $(".enter-cc").keydown(function(e) {
            if (e.keyCode == 13 || e.keyCode == 32) {
                var getValue = $(this).val();
                @this.addCc(getValue)
                $(this).val('');
            }
        });

        $(document).on('click', '.cancel-cc', function() {
            var element = $(this).parent().text()
            @this.removeCc(element);
            $(this).parent().remove();

        });

        $(".enter-cco").keydown(function(e) {
            if (e.keyCode == 13 || e.keyCode == 32) {
                var getValue = $(this).val();
                @this.addCco(getValue)
                $(this).val('');
            }
        });

        $(document).on('click', '.cancel-cco', function() {
            var element = $(this).parent().text()
            @this.removeCco(element);
            $(this).parent().remove();
        });

        const editor = CKEDITOR.replace('{{ $activeField }}', {
            filebrowserUploadUrl: "{{ route('upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form',
            height: '300px',
        });
        editor.on('change', function(event) {
            @this.set('{{ $activeField }}', event.editor.getData());
        });

        window.livewire.on('render', () => {
            editor.setData(@this.get('{{ $activeField }}'), {
                callback: function() {
                    this.checkDirty();
                }
            });
        });
    </script>
@endpush
