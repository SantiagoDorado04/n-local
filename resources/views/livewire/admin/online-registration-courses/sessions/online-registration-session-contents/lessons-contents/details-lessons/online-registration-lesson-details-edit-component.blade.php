<div>
    <style>
        .switch-container {
            display: flex;
            align-items: center;
            gap: 10px;
            /* Espacio entre el switch y el texto */
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
            border-radius: 20px;
            padding: 2px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .switch::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: white;
            top: 2px;
            left: 2px;
            transition: transform 0.3s ease-in-out;
        }

        .switch-on {
            background-color: #4CAF50;
        }

        .switch-off {
            background-color: #ccc;
        }

        .switch-on::after {
            transform: translateX(20px);
        }

        .switch-text {
            font-size: 14px;
            color: #333;
        }
    </style>
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li><a href="{{ route('online-registrations') }}">Controles de registro</a></li>
            <li><a
                    href="{{ route('online-registration-categories', ['id' => $session_id->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->id]) }}">Categorias</a>
            </li>
            <li><a
                    href="{{ route('online-registration-courses', ['id' => $session_id->onlineRegistrationCourse->onlineRegistrationCategory->id]) }}">Cursos</a>
            </li>
            <li><a
                    href="{{ route('online-registration-courses-sessions', ['id' => $session_id->onlineRegistrationCourse->id]) }}">Sesiones</a>
            </li>
            <li><a href="{{ route('online-registration-sessionContent', ['id' => $session_id->id]) }}">Contenidos</a>
            </li>
            <li><a>Lección</a></li>
        </ol>
    @endsection

    @section('page_title', 'Video | ' . setting('admin.title'))
    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-book"></i>&nbsp; Editar Detalles De La Lección
            </h1>

        </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin-bottom:0px">
                    <div class="panel-body" style="margin-bottom:0px">
                        <ul>
                            <li><strong>Control de registro: </strong>
                                {{ $session_id->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->name }}<br>
                            </li>
                            <li><strong>Categoria: </strong>
                                {{ $session_id->onlineRegistrationCourse->onlineRegistrationCategory->name }}<br>
                            </li>
                            <li><strong>Curso: </strong>
                                {{ $session_id->onlineRegistrationCourse->name }}<br></li>
                            <li><strong>Sesión: </strong> {{ $session_id->name }}<br></li>
                            <li><strong>Contenido de cursos: </strong> {{ $lesson_session->title }}<br></li>
                        </ul>
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
                            <div class="col-lg-12 d-flex">
                                <!-- Área de texto -->
                                <div class="mb-3">
                                    <label class="form-label">Título:</label>
                                    <input type="text" class="form-control" wire:model="title"
                                        placeholder="Ingrese el título de la lección">
                                    @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-8">
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


                                </div>
                                <br>
                                <!-- Tarjeta para subir imagen -->
                                <div class="col-md-4">
                                    <div class="panel panel-bordered">

                                        <div class="panel-body text-center">
                                            <h5><strong>Subir Imagen</strong></h5>
                                            <input type="file" accept="image/*" wire:model="image"
                                                class="form-control">

                                            @if ($image)
                                                <img src="{{ $image->temporaryUrl() }}" alt="Vista previa"
                                                    class="img-fluid"
                                                    style="max-width: 80%; max-height: 400px; margin-bottom: 20px;">
                                            @elseif($existingFile)
                                                <img src="{{ $existingFile }}" alt="Vista previa" class="img-fluid"
                                                    style="max-width: 80%; max-height: 400px; margin-bottom: 20px;">
                                            @else
                                                <p class="text-muted">No hay imagen seleccionada</p>
                                            @endif

                                            <br>
                                            {{--       @if ($existingFile)
                                                <button class="btn btn-danger mt-2" wire:click="removeFile">
                                                    <i class="fa fa-trash"></i> Eliminar imagen
                                                </button>
                                            @endif --}}

                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                    </div>

                                    <div class="card-header bg-secondary text-white text-center">
                                        <div class="switch {{ $parameter ? 'switch-on' : 'switch-off' }}"
                                            wire:click="toggleApprovalForm">
                                            <div></div>
                                        </div>
                                        <p class="switch-text">
                                            @if ($align_image == 'right')
                                                Imagen a la Derecha
                                            @elseif ($align_image == 'left')
                                                Imagen a la Izquierda
                                            @else
                                                No definido
                                            @endif
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-center gap-3 text-center"
                                        style="margin-top: 20px;">
                                        <button class="btn btn-success" wire:click="update()">
                                            <i class="fa fa-save"></i> Guardar Contenido
                                        </button>

                                        <a href="{{ route('online-registration-lesson-content-detail', ['id' => $this->lesson_session->lesson->content_id]) }}"
                                            class="btn btn-danger">
                                            <i class="fa fa-list"></i> Cancelar
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <br><br>

                            <div class="card-header bg-secondary text-white text-center">
                                <h3 class="mb-0">Vista previa</h3>
                            </div><br><br>

                            <div class="page-content browse container-fluid">
                                <div class="row no-margin-bottom">
                                    <div class="col-md-12">
                                        <div class="panel panel-bordered text-center">
                                            <h2 class="fw-bold mb-3 ms-2 fs-5">
                                                {{ $this->lessonContent->onlineRegistrationSessionContent->title ?? '' }}
                                            </h2>
                                            <p class="text-muted ms-2">
                                                {{ $this->lessonContent->onlineRegistrationSessionContent->description ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="page-content browse container-fluid">
                                    <div class="row no-margin-bottom">
                                        <!-- Imagen a la izquierda -->
                                        @if ($align_image === 'left')
                                            <div class="col-md-4">
                                                <div class="panel panel-bordered">
                                                    <div class="panel-body text-center">
                                                        <!-- Imagen dentro de la tarjeta -->
                                                        @if ($image)
                                                            <img src="{{ $image->temporaryUrl() }}" alt="Vista previa"
                                                                class="img-fluid"
                                                                style="max-width: 100%; max-height: 400px; margin-bottom: 20px;">
                                                        @elseif($existingFile)
                                                            <img src="{{ $existingFile }}" alt="Vista previa"
                                                                class="img-fluid"
                                                                style="max-width: 100%; max-height: 400px; margin-bottom: 20px;">
                                                        @else
                                                            <p class="text-muted">No hay imagen seleccionada</p>
                                                        @endif
                                                        @error('image')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <br> <br>

                                                        <!-- Menú de contenidos dentro de la tarjeta -->
                                                        <div class="panel-group" id="accordion">
                                                            <div class="panel panel-primary">
                                                                <a data-toggle="collapse" data-parent="#accordion"
                                                                    href="#collapse1" style="text-decoration:none">
                                                                    <div class="panel-heading panel-heading-custom"
                                                                        id="heading1" style="padding: 4px">
                                                                        <p style="padding: 5px; margin-bottom:0px">
                                                                            <strong>Menu de contenidos</strong>
                                                                        </p>
                                                                    </div>
                                                                </a>
                                                                <div id="collapse1"
                                                                    class="panel-collapse collapse in">
                                                                    <div class="panel-body">
                                                                        <ul class="list-group">
                                                                            <li class="list-group-item"><a
                                                                                    href="#"
                                                                                    wire:click="">Slide
                                                                                    1</a></li>
                                                                            <li class="list-group-item"><a
                                                                                    href="#"
                                                                                    wire:click="">Video</a></li>
                                                                            <li class="list-group-item"><a
                                                                                    href="#"
                                                                                    wire:click="">Lección</a></li>
                                                                            <li class="list-group-item"><a
                                                                                    href="#"
                                                                                    wire:click="">Test</a></li>
                                                                            <li class="list-group-item"><a
                                                                                    href="#"
                                                                                    wire:click="">Despedida</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Contenido principal -->
                                        <div class="col-md-8">
                                            <div class="panel panel-bordered" style="margin: 0px;height:730px">
                                                <div class="panel-body" style="margin: 0px">
                                                    <div class="row no-margin-bottom">
                                                        <div class="col-lg-12">
                                                            <h2 class="col-md-12 ms-6 mb-3">{{ $title ?? '' }}</h2>
                                                            <br>
                                                            <div class="col-md-12 ms-6 mb-3">
                                                                {!! $content !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Imagen a la derecha -->
                                        @if ($align_image === 'right')
                                            <div class="col-md-4">
                                                <div class="panel panel-bordered">
                                                    <div class="panel-body text-center">
                                                        <!-- Imagen dentro de la tarjeta -->
                                                        @if ($image)
                                                            <img src="{{ $image->temporaryUrl() }}"
                                                                alt="Vista previa" class="img-fluid"
                                                                style="max-width: 100%; max-height: 400px; margin-bottom: 20px;">
                                                        @elseif($existingFile)
                                                            <img src="{{ $existingFile }}" alt="Vista previa"
                                                                class="img-fluid"
                                                                style="max-width: 100%; max-height: 400px; margin-bottom: 20px;">
                                                        @else
                                                            <p class="text-muted">No hay imagen seleccionada</p>
                                                        @endif
                                                        @error('image')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <br> <br>

                                                        <!-- Menú de contenidos dentro de la tarjeta -->
                                                        <div class="panel-group" id="accordion">
                                                            <div class="panel panel-primary">
                                                                <a data-toggle="collapse" data-parent="#accordion"
                                                                    href="#collapse1" style="text-decoration:none">
                                                                    <div class="panel-heading panel-heading-custom"
                                                                        id="heading1" style="padding: 4px">
                                                                        <p style="padding: 5px; margin-bottom:0px">
                                                                            <strong>Menu de contenidos</strong>
                                                                        </p>
                                                                    </div>
                                                                </a>
                                                                <div id="collapse1"
                                                                    class="panel-collapse collapse in">
                                                                    <div class="panel-body">
                                                                        <ul class="list-group">
                                                                            <li class="list-group-item"><a
                                                                                    href="#"
                                                                                    wire:click="">Slide 1</a></li>
                                                                            <li class="list-group-item"><a
                                                                                    href="#"
                                                                                    wire:click="">Video</a></li>
                                                                            <li class="list-group-item"><a
                                                                                    href="#"
                                                                                    wire:click="">Lección</a></li>
                                                                            <li class="list-group-item"><a
                                                                                    href="#"
                                                                                    wire:click="">Test</a></li>
                                                                            <li class="list-group-item"><a
                                                                                    href="#"
                                                                                    wire:click="">Despedida</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                    <div class="text-center">
                                        <a href="#" class="btn btn-warning">
                                            <i class="fa fa-arrow-left"></i> Anterior
                                        </a>
                                        <a href="#" class="btn btn-success">
                                            Siguiente <i class="fa fa-arrow-right"></i>
                                        </a>
                                        <br>
                                        <a href="{{ route('online-registration-sessionContent', ['id' => $this->session_id]) }}"
                                            class="btn btn-primary">
                                            <i class="fa fa-close"></i> Cerrar
                                        </a>
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
            height: '520px',
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
