<div>
   <style>
      .progress-bar {
         background-color: #ffffff;
      }

      .progress-bar-striped {
         background-image: linear-gradient(-45deg, #7EB5FF 25%, transparent 25%, transparent 50%, #7EB5FF 50%, #7EB5FF 75%, transparent 75%, transparent);
      }
   </style>

   <div class="container d-flex align-items-center min-vh-100">
      <div class="row g-0 justify-content-center">
         {{-- Form details --}}
         <div class="col-lg-4 offset-lg-1 mx-0 px-0" style="width:450px">
            <div id="title-container">
               <img class="covid-image" src="{{ url('assets/img/logo-nido.png') }}">
               <h2>{{ setting('admin.title') }}</h2>
               <h3>{{ $form->name }}</h3>
               <p style="text-align: justify;
                        text-justify: inter-word; margin-top: 20px;font-size: 18px">{{ $form->description }}
               </p>
            </div>
         </div>
         {{-- Form questions --}}
         <div class="col-lg-7 mx-0 px-0">
            <div class="progress">
               <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="50"
                  class="progress-bar progress-bar-striped progress-bar-animated bg-default" role="progressbar"
                  style="width: {{ $progress }}%"></div>
            </div>
            {{-- If you have not finished, show the questions, otherwise the result --}}
            @if ($finish == false)
            {{-- Questions --}}
            <div id="qbox-container">
               <form wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))"
                  id="form-appointment"  autocomplete="off">
                  <div class="needs-validation">
                     <div id="steps-container" style="width: 600px">
                        {{-- Company data --}}
                        <div class="step" style="display:{{ $count == 1 ? 'block' : 'hidden' }}; width:100%">
                           <h4>Información de la empresa:</h4>
                           <div class="row mt-1">
                              <div class="col-lg-6 col-md-6 col-6">
                                 <label class="form-label is-required">NIT / Cédula:</label>
                                 <input type="text" class="form-control" name="nit" wire:model="nit" autocomplete="off" aria-autocomplete="none" >
                                 @error('nit')
                                 <small class="text-danger">{{ $message }}</small>
                                 @enderror
                              </div>
                              <div class="col-lg-6">
                                 <label class="form-label is-required">Nombre de la empresa:</label>
                                 <input type="text" class="form-control" name="name" wire:model="name" autocomplete="off" aria-autocomplete="none" >
                                 @error('name')
                                 <small class="text-danger">{{ $message }}</small>
                                 @enderror
                              </div>
                           </div>
                           <div class="row mt-1">
                              <div class="col-lg-6 col-md-6 col-6">
                                 <label class="form-label is-required">Correo electrónico:</label>
                                 <input type="text" class="form-control" name="email" wire:model="email" autocomplete="off" aria-autocomplete="none" >
                                 @error('email')
                                 <small class="text-danger">{{ $message }}</small>
                                 @enderror
                              </div>
                              <div class="col-lg-6">
                                 <label class="form-label is-required">Teléfono:</label>
                                 <input type="text" class="form-control" name="phone" wire:model="phone" autocomplete="off" aria-autocomplete="none" >
                                 @error('phone')
                                 <small class="text-danger">{{ $message }}</small>
                                 @enderror
                              </div>
                           </div>
                           <div class="row mt-1">
                              <div class="col-lg-6 col-md-6 col-6">
                                 <label class="form-label">WhatsApp:</label>
                                 <input type="text" class="form-control" name="whatsapp" wire:model="whatsapp" autocomplete="off" aria-autocomplete="none" >
                              </div>
                              <div class="col-lg-6">
                                 <label class="form-label is-required">Nombre de persona de
                                    contacto:</label>
                                 <input type="text" class="form-control" name="contact_person_name"
                                    wire:model="contact_person_name" autocomplete="off" aria-autocomplete="none" >
                                 @error('contact_person_name')
                                 <small class="text-danger">{{ $message }}</small>
                                 @enderror
                              </div>
                           </div>
                           <div class="row mt-1">
                              <div class="col-lg-6 col-md-6 col-6">
                                 <label class="form-label">Página web:</label>
                                 <input type="text" class="form-control" name="website" wire:model="website" autocomplete="off" aria-autocomplete="none" >
                              </div>
                           </div>
                        </div>
                        <div class="step" style="display:{{ $count == 2 ? 'block' : 'hidden' }}">
                           <div class="mt-1">
                              <div class="closing-text">
                                 <h4>Inicio de formulario!</h4>
                                 <p>A continuación formulario generado desde el admin.</p>
                                 <p>Click en el boton <b>Siguiente</b> para continuar.</p>
                              </div>
                           </div>
                        </div>

                        {{-- Dynamic questions --}}
                        @foreach ($questions as $question)
                        <div class="step"
                           style="display:{{ $count == $loop->iteration + 2 ? 'block' : 'hidden' }}; width:100%">
                           <h4>{{ $loop->iteration . '. ' . $question->question }}</h4>
                           @if ($question->type == 'po')
                           <div class="row mt-2">
                              <div class="form-check ps-0 q-box">
                                 <div class="q-box__question">
                                    @foreach ($options as $option)
                                    @if ($option->commercial_form_question_id == $question->id)
                                    <input type="radio" class="form-check-input question__input"
                                       id="q_{{ $question->id }}_{{ $option->value }}"
                                       name="question_{{ $question->id }}" value="{{ $option->value }}" required autofocus>
                                    <label class="form-check-label question__label"
                                       for="q_{{ $question->id }}_{{ $option->value }}">{{ $option->option }}</label><br>
                                    @endif
                                    @endforeach
                                 </div>
                                 <small class="text-danger">{{ $message }}</small>
                              </div>
                           </div>
                           @else
                           <div class="row mt-2">
                              <textarea class="form-control" name="question_{{ $question->id }}" required autofocus autocomplete="off" aria-autocomplete="none" ></textarea>
                              <small class="text-danger">{{ $message }}</small>
                           </div>
                           @endif

                        </div>
                        @endforeach
                     </div>
                     {{-- Buttons --}}
                     <div id="q-box__buttons">
                        @if (auth()->check())
                        <button id="prev-btn" type="button" wire:click="previousQuestion()"
                        style="display:{{ $count ==2 ? 'none' : 'inline-block' }}">Anterior</button>
                        @else
                           <button id="prev-btn" type="button" wire:click="previousQuestion()"
                           style="display:{{ $count == 1 ? 'none' : 'inline-block' }}">Anterior</button>
                        @endif
                        <button id="next-btn" type="button" onclick="validateField()"
                           style="display:{{ $count == $cant ? 'none' : 'inline-block' }}">Siguiente</button>
                        <button id="submit-btn" type="submit"
                           style="display:{{ $count == $cant ? 'inline-block' : 'none' }}; background-color:#9492E6">Enviar</button>
                     </div>
                  </div>
               </form>
            </div>
            {{-- If the form was sent --}}
            @elseif ($finish == true)
            <div id="qbox-container">
               <div class="needs-validation">
                  <div id="steps-container" style="width: 600px">
                     <div id="success" style="display: block-inline">
                        <div class="mt-5">
                           <h4>Formulario enviado correctamente!</h4>
                           <br>
                           {{-- If there are calls, otherwise they show a message that is not available --}}
                           @if ($anContact != [])
                           De acuerdo al resultado, su empresa aplica a las siguientes convocatorias:
                           <br>
                           <br>
                           <ul>
                              @foreach ($anContact as $item)
                                 @foreach ($announcements as $announcement)
                                    @if ($item == $announcement->id)
                                       <li>{{ $announcement->name }}</li>
                                    @endif
                                 @endforeach
                              @endforeach
                           </ul>
                           @else
                           <p>De acuerdo al resultado por el momento no hay convocatorias disponibles a
                              las que pueda
                              aplicar.</p>
                           @endif
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @endif
         </div>
      </div>
   </div>

   {{-- Movement between steps --}}
   <script>
      function validateField() {
            if (@this.count > 2) {
               Livewire.emit('getQuestion');
            } else {
               Livewire.emit('nextQuestion');
            }
      }
   </script>
   
   {{-- Validation required fields --}}
   @section('javascript')
   <script type="text/javascript">
      Livewire.on('sendQuestion', data => {
         /* If it is an open question, it is validated that it is not empty */
         if (data[1] == 'pa') {
            let x = document.querySelector('[name="question_' + data[0] + '"]').value;
            /* Message error is shown */
            if (x == "") {
                  @this.message = 'El campo es requerido';
            }
            /* Moves to the next step */
            else {
                  Livewire.emit('nextQuestion');
                  @this.message = '';
            }
         }
         /* If it is of simple option, it is validated that at least one */
         else {
            var ele = document.getElementsByName('question_' + data[0]);

            for (i = 0; i < ele.length; i++) {
                  /* Moves to the next step */
                  if (ele[i].checked) {
                     @this.message = '';
                     Livewire.emit('nextQuestion');
                  }
                  /* Message error is shown */
                  else {
                     @this.message = 'Seleccione una de las opciones';
                  }
            }

         }
      })

      /* Loader loads, the other components are hidden */
      Livewire.on('showLoader', data => {
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

         timer(2000)
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
      })
   </script>
   @endsection
</div>