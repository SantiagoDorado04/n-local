<div>

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('processes') }}">Procesos</a>
            </li>
            <li>
                <a href="{{ route('stages', ['id' => $topic->course->step->stage->process_id]) }}">Etapas</a>
            </li>
            <li>
                <a href="{{ route('steps', ['id' => $topic->course->step->stage_id]) }}">Pasos</a>
            </li>
            <li>
                <a href="{{ route('courses', ['id' => $topic->course->step_id]) }}">Cursos</a>
            </li>
            <li>
                <a href="{{ route('topics', ['id' => $topic->course_id]) }}">Tematicas</a>
            </li>
            <li>
                Contenido
            </li>
        </ol>
    @endsection
    
    @section('page_title', 'Lecciones | ' . setting('admin.title'))
    
    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-file-text-o"></i>&nbsp;Contenido
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
                                <li><strong>Proceso:</strong> {{ $topic->course->step->stage->process->name }}</li>
                                <li><strong>Etapa:</strong> {{ $topic->course->step->stage->name }}</li>
                                <li><strong>Paso:</strong> {{ $topic->course->name }}</li>
                                <li><strong>Curso:</strong> {{ $topic->course->name }}</li>
                                <li><strong>Tematica:</strong> {{ $topic->name }}</li>
                                <li><strong>Lección:</strong>  {{ $lesson->title }}</li>
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
                                                <textarea name="content" id="content" class="form-control" wire:model.debounce.500ms="content"></textarea>
                                            </div>
                                            @error('content')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>           
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
                                                                    {!! $content !!}
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

        const editor = CKEDITOR.replace('content', {
            filebrowserUploadUrl: "{{ route('upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form',
            height: '300px',
        });
        editor.on('change', function(event) {
            @this.set('content', event.editor.getData());
        });

        window.livewire.on('cke', () => {
            editor.setData(@this.content, {
                callback: function() {
                    this.checkDirty();
                }
            });
        });
</script>
@endpush