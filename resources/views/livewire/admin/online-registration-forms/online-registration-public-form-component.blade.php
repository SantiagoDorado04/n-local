<div>
    <style>
        .progress-bar {
            background-color: #ffffff;
        }

        .progress-bar-striped {
            background-image: linear-gradient(-45deg, #A21B72 25%, transparent 25%, transparent 50%, #A21B72 50%, #A21B72 75%, transparent 75%, transparent);
        }

        #q-box__buttons button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        #q-box__buttons button:hover {
            background-color: #45a049;
        }

        #q-box__buttons #submit-btn:hover {
            background-color: #FFC107;
        }

        .banner-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .banner-img {
            width: 100%;
            max-width: 500px;
            /* Para que no sea demasiado grande */
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .video-wrapper {
            border-radius: 12px;
            /* Ajusta según el redondeado que desees */
            overflow: hidden;
            /* Evita que el iframe sobresalga */
        }

        .video-wrapper iframe {
            border-radius: 12px;
        }
    </style>

    <div class="container d-flex align-items-center min-vh-100">
        <div class="row g-0 justify-content-center">
            <div class="col-lg-4 offset-lg-1 mx-0 px-0" style="width:450px">
                <div id="title-container">
                  {{--   @if ($bannerImage)
                        <img src="{{ $bannerImage }}" alt="Imagen" class="img-fluid"
                           >
                    @else
                        <img class="covid-image" src="{{ url('assets/img/logo-nido.png') }}">
                    @endif --}}
                    @if ($bannerImage)
                        @if (Str::endsWith($bannerImage, ['jpg', 'jpeg', 'png', 'gif']))
                            <img src="{{ Storage::url($bannerImage) }}" alt="Imagen adjunta" class="img-fluid"
                            style="max-width: 350px; max-height: 350px; margin-bottom: 20px; margin-top: -80px;">
                        @else
                            <a href="{{ Storage::url($bannerImage) }}" target="_blank">Ver archivo</a>
                        @endif
                    @else
                    @endif
                    {{-- <h2>{{ setting('admin.title') }}</h2> --}}
                    <h2>{{ $form->name }}</h2>
                    <p
                        style="text-align: justify;
                            text-justify: inter-word; margin-top: 20px;font-size: 18px">
                        {{ $form->description }}
                    </p>
                </div>
            </div>
            <div class="col-lg-7 mx-0 px-0">
                <div class="progress">
                    <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="50"
                        class="progress-bar progress-bar-striped progress-bar-animated bg-default" role="progressbar"
                        style="width: {{ $progress }}%"></div>
                </div>
                @if ($finish == false)
                    <div id="qbox-container">
                        <form wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))"
                            id="form-appointment" autocomplete="off" onsubmit="return false;">
                            <div class="needs-validation">
                                <div id="steps-container" style="width: 600px">

                                    <div class="step"
                                        style="display:{{ $count == 1 ? 'block' : 'none' }}; width:100%">
                                        @if ($embebed_video)
                                            <div class="embed-responsive embed-responsive-16by9 video-wrapper">
                                                {!! $embebed_video !!}
                                            </div>
                                        @endif

                                        @if ($canRegister)
                                            <h4 class="mt-3 fw-bold text-primary">Para iniciar, ingresa tu Cédula:</h4>
                                            <p><small>*Ten en cuenta que este será el documento con el que se emitirá tu
                                                    certificado:</small></p>
                                            <div class="row mt-2">
                                                <div class="col-lg-12">
                                                    <label class="form-label is-required">Cédula:</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" wire:model="nit"
                                                            id="nit" autocomplete="off" autofocus>
                                                        <button class="btn btn-primary" type="button"
                                                            wire:click="searchNit">
                                                            Buscar <i class="fa fa-search"></i>
                                                        </button>
                                                    </div>
                                                    @error('nit')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                    @error('online_registration_course')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        @elseif ($canRegister == true)
                                            <h4 class="mt-3 fw-bold text-primary">Para iniciar, ingresa tu Cédula:</h4>
                                            <p><small>*Ten en cuenta que este será el documento con el que se emitirá tu
                                                    certificado:</small></p>
                                            <div class="row mt-2">
                                                <div class="col-lg-12">
                                                    <label class="form-label is-required">Cédula:</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" wire:model="nit"
                                                            id="nit" autocomplete="off" autofocus>
                                                        <button class="btn btn-primary" type="button"
                                                            wire:click="searchNit">
                                                            Buscar <i class="fa fa-search"></i>
                                                        </button>
                                                    </div>

                                                    @error('nit')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                    @error('online_registration_course')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        @elseif ($canRegister == false)
                                            <h4 class="mt-3 fw-bold text-primary">Para iniciar, ingresa tu Cédula:</h4>
                                            <p><small>*Ten en cuenta que este será el documento con el que se emitirá tu
                                                    certificado:</small></p>

                                            <div class="row mt-2">
                                                <div class="col-lg-12">
                                                    <label class="form-label is-required">Cédula:</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" wire:model="nit"
                                                            id="nit" autocomplete="off" autofocus>
                                                        <button class="btn btn-primary" type="button"
                                                            wire:click="searchNit">
                                                            Buscar <i class="fa fa-search"></i>
                                                        </button>

                                                    </div>
                                                    @error('nit')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                    @error('online_registration_course')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="alert alert-danger mt-3">
                                                <strong>¡Lo sentimos!</strong> Tienes que esperar
                                                {{ $missingCourses + 1 }} cursos antes de
                                                poder volver a
                                                inscribirte.
                                            </div>
                                        @else
                                            <div class="alert alert-danger mt-3">
                                                <strong>¡Lo sentimos!</strong> El curso al que intentas inscribirte ya
                                                no está activo.
                                            </div>
                                        @endif
                                    </div>
                                    <div class="step"
                                        style="display:{{ $count == 2 ? 'block' : 'none' }}; width:100%">
                                        <h4>Información de registro</h4>
                                        <h6>Ingresa o actualiza tu informacion a continuacion:</h6>
                                        <br>
                                        <div class="row mt-1">
                                            <div class="col-lg-6 col-md-6 col-6">
                                                <label class="form-label is-required">Cédula:</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="nit"
                                                        wire:model="nit" autocomplete="off" aria-autocomplete="none"
                                                        onkeydown="if(event.key === 'Enter'){ event.preventDefault(); return false; }">
                                                    {{-- <button class="btn btn-primary" type="button"
                                                        wire:click="searchNit"><i class="fa fa-search"
                                                            aria-hidden="true"></i></button> --}}
                                                </div>
                                                @error('nit')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="form-label is-required">Nombre:</label>
                                                <input type="text" class="form-control" name="name"
                                                    wire:model="name" autocomplete="off" aria-autocomplete="none"
                                                    onkeydown="if(event.key === 'Enter'){ event.preventDefault(); return false; }">
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-lg-6">
                                                <label class="form-label is-required">Correo electrónico:</label>
                                                <input type="text" class="form-control" name="email"
                                                    wire:model="email" autocomplete="off" aria-autocomplete="none"
                                                    onkeydown="if(event.key === 'Enter'){ event.preventDefault(); return false; }">
                                                @error('email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="form-label is-required">Celular/Whatsapp:</label>
                                                <input type="text" class="form-control" name="phone"
                                                    wire:model="phone" autocomplete="off" aria-autocomplete="none"
                                                    onkeydown="if(event.key === 'Enter'){ event.preventDefault(); return false; }">
                                                @error('phone')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-lg-6">
                                                <label class="form-label">WhatsApp:</label>
                                                <input type="text" class="form-control" name="whatsapp"
                                                    wire:model="whatsapp" autocomplete="off" aria-autocomplete="none"
                                                    onkeydown="if(event.key === 'Enter'){ event.preventDefault(); return false; }">
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="form-label is-required">Nombre de persona de
                                                    contacto:</label>
                                                <input type="text" class="form-control" name="contact_person_name"
                                                    wire:model="contact_person_name" autocomplete="off"
                                                    aria-autocomplete="none"
                                                    onkeydown="if(event.key === 'Enter'){ event.preventDefault(); return false; }">
                                                @error('contact_person_name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-lg-6 col-md-6 col-6">
                                                <label class="form-label">Página web:</label>
                                                <input type="text" class="form-control" name="website"
                                                    wire:model="website" autocomplete="off" aria-autocomplete="none"
                                                    onkeydown="if(event.key === 'Enter'){ event.preventDefault(); return false; }">
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-lg-12 col-md-12 col-12 text-center">
                                                @error('course_registration_form')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="step" style="display:{{ $count == 2 ? 'block' : 'hidden' }}">
                                        <div class="mt-1">
                                            <div class="closing-text">
                                                <h4>Inicio de formulario!</h4>
                                                <p>A continuación formulario generado desde el admin.</p>
                                                <p>Click en el boton <b>Siguiente</b> para continuar.</p>
                                            </div>
                                        </div>
                                    </div> --}}
                                    @foreach ($questions as $question)
                                        <div class="step"
                                            style="display:{{ $count == $loop->iteration + 2 ? 'block' : 'hidden' }}; width:100%">
                                            <div class="row no-margin-bottom">
                                                <div class="col-md-12">
                                                    <div class="panel panel-bordered">
                                                        <div class="panel-body">
                                                            <div class="row no-margin-bottom">
                                                                <div class="col-md-1">
                                                                    <strong>{{ $loop->iteration . '. ' }}</strong>
                                                                </div>
                                                                <div class="col-md-11">
                                                                    <p>{{ $question->text }}</p>
                                                                    {!! nl2br($question->question) !!}
                                                                    @if ($question->type == 'OM')
                                                                        <div>
                                                                            @foreach ($question->options as $index => $option)
                                                                                <input
                                                                                    name="question_{{ $question->id }}.{{ $index }}"
                                                                                    value="{{ $option->id }}"
                                                                                    type="checkbox"
                                                                                    wire:model.defer="answers.question_{{ $question->id }}.{{ $index }}">
                                                                                <label
                                                                                    for="option_{{ $option->id }}">{{ $option->text }}</label><br>
                                                                            @endforeach
                                                                        </div>
                                                                    @elseif ($question->type == 'OS')
                                                                        <div>
                                                                            @foreach ($question->options as $option)
                                                                                <input type="radio"
                                                                                    id="option_{{ $option->id }}"
                                                                                    name="question_{{ $question->id }}"
                                                                                    value="{{ $option->id }}"
                                                                                    class="radio-option"
                                                                                    data-question-id="{{ $question->id }}"
                                                                                    wire:model.defer="answers.question_{{ $question->id }}">
                                                                                <label
                                                                                    for="option_{{ $option->id }}">{{ $option->text }}</label><br>
                                                                            @endforeach
                                                                        </div>
                                                                    @elseif ($question->type == 'AD')
                                                                        <input type="file"
                                                                            name="question_{{ $question->id }}"
                                                                            accept="image/*"
                                                                            onkeydown="if(event.key === 'Enter'){ event.preventDefault(); return false; }"
                                                                            wire:model.defer="answers.question_{{ $question->id }}">
                                                                    @elseif ($question->type == 'AC')
                                                                        <input type="text" class="form-control"
                                                                            name="question_{{ $question->id }}"
                                                                            onkeydown="if(event.key === 'Enter'){ event.preventDefault(); return false; }"
                                                                            wire:model.defer="answers.question_{{ $question->id }}">
                                                                    @elseif ($question->type == 'AL')
                                                                        <textarea class="form-control" name="question_{{ $question->id }}" rows="4"
                                                                            wire:model.defer="answers.question_{{ $question->id }}"
                                                                            onkeydown="if(event.key === 'Enter'){ event.stopPropagation(); }">
                                                                    </textarea>
                                                                    @endif
                                                                    @error("answers.question_{$question->id}")
                                                                        <small
                                                                            class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="step text-center"
                                        style="display:{{ $count == $cant ? 'block' : 'none' }};">
                                        <div class="mt-5">
                                            <h4 class="fw-bold text-primary">Todo listo, revisa tus respuestas antes de
                                                enviar el formulario!</h4>
                                            <h6>si todo está correcto, haz click en enviar:</h6>
                                        </div>
                                    </div>

                                </div>
                                <div id="q-box__buttons">
                                    @if ($count > 1)
                                        <button id="prev-btn" type="button" wire:click="previousQuestion()"
                                            style="display:{{ $count == 2 ? 'none' : 'inline-block' }}">Anterior</button>
                                        {{-- @else
                                        <button id="prev-btn" type="button" wire:click="previousQuestion()"
                                            style="display:{{ $count == 1 ? 'none' : 'inline-block' }}">Anterior</button> --}}
                                    @endif
                                    @if ($count >= 2)
                                        <button id="next-btn" type="button" onclick="nextStep()"
                                            style="display:{{ $count == $cant ? 'none' : 'inline-block' }}">Siguiente</button>
                                        @error('next_question')
                                            <br>
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    @endif
                                    <button id="submit-btn" type="submit"
                                        style="display:{{ $count == $cant ? 'inline-block' : 'none' }}">Enviar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @elseif ($finish == true)
                    <div id="qbox-container">
                        <div class="needs-validation">
                            <div id="steps-container" style="width: 600px">
                                <div id="success" style="display: block-inline">
                                    <div class="mt-5">
                                        <h4>Formulario enviado correctamente!</h4>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function nextStep() {
            @this.nextQuestion();
        }
    </script>
    <script>
        function validateField() {
            if (@this.count > 2) {
                Livewire.emit('getQuestion');
            } else {
                Livewire.emit('nextQuestion');
            }
        }
    </script>
    @section('javascript')
        <script type="text/javascript">
            Livewire.on('sendQuestion', data => {
                if (data[1] == 'pa') {
                    let x = document.querySelector('[name="question_' + data[0] + '"]').value;
                    if (x == "") {
                        @this.message = 'El campo es requerido';
                    } else {
                        Livewire.emit('nextQuestion');
                        @this.message = '';
                    }
                } else {
                    var ele = document.getElementsByName('question_' + data[0]);

                    for (i = 0; i < ele.length; i++) {
                        if (ele[i].checked) {
                            @this.message = '';
                            Livewire.emit('nextQuestion');
                        } else {
                            @this.message = 'Seleccione una de las opciones';
                        }
                    }
                }
            })

            Livewire.on('showLoader', function(data) {
                let step = document.getElementsByClassName('step');
                let prevBtn = document.getElementById('prev-btn');
                let nextBtn = document.getElementById('next-btn');
                let submitBtn = document.getElementById('submit-btn');
                let form = document.getElementsByTagName('form')[0];
                let preloader = document.getElementById('preloader-wrapper');
                let bodyElement = document.querySelector('body');
                let succcessDiv = document.getElementById('success');

                preloader.classList.add('d-block');

                const timer = ms => new Promise(res => setTimeout(res, ms));

                timer(3000)
                    .then(() => {
                        bodyElement.classList.add('loaded');
                    }).then(() => {
                        prevBtn.classList.remove('d-inline-block');
                        prevBtn.classList.add('d-none');
                        submitBtn.classList.remove('d-inline-block');
                        submitBtn.classList.add('d-none');
                        succcessDiv.classList.remove('d-none');
                        succcessDiv.classList.add('d-block');
                    })
            });
            document.addEventListener("DOMContentLoaded", function() {
                document.addEventListener("keydown", function(event) {
                    if (event.key === "Enter") {
                        event.preventDefault();
                    }
                });
            });
        </script>
    @endsection
</div>
