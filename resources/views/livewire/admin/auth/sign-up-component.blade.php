<div>
    <style>
        .progress-bar {
            background-color: #ffffff;
        }

        .progress-bar-striped {
            background-image: linear-gradient(-45deg, #F5B029 25%, transparent 25%, transparent 50%, #F5B029 50%, #F5B029 75%, transparent 75%, transparent);
        }

        .roboto-font-light {
            font-family: 'Roboto Light', sans-serif;
        }

        .roboto-font-bold {
            font-family: 'Roboto Bold', sans-serif;
        }
    </style>

    <title>Registro | {{ setting('admin.title') }}</title>

    <div class="container d-flex align-items-center min-vh-100">
        <div class="row g-0 justify-content-center">

            <div class="col-lg-4 offset-lg-1 mx-0 px-0" style="width:450px">
                <div id="title-container">
                    <img class="covid-image" src="{{ setting('admin.icon_image') }}">
                    <h2 class="roboto-font-light">{{ setting('admin.title') }}</h2>
                    <p class="roboto-font-light"
                        style="text-align: justify;
                        text-justify: inter-word; margin-top: 20px;font-size: 18px;">
                        {{ setting('admin.signup_text') }}
                    </p>
                </div>
            </div>
            <div class="col-lg-7 mx-0 px-0">
                <div class="progress">
                    <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="50"
                        class="progress-bar progress-bar-striped progress-bar-animated bg-default" role="progressbar"
                        style="width: 100%"></div>
                </div>
                <div id="qbox-container">
                    <div class="needs-validation">
                        <div id="steps-container" style="width: 600px">
                            <div class="step" style="display:block; width:100%">
                                <h4 class="roboto-font-bold">Información de la empresa:</h4>
                                <div class="row mt-1">
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <label class="form-label is-required roboto-font-light">NIT / Cédula:</label>
                                        <input type="text" class="form-control" name="nit" wire:model="nit"
                                            autocomplete="off" aria-autocomplete="none">
                                        @error('nit')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label is-required roboto-font-light">Nombre de la
                                            empresa:</label>
                                        <input type="text" class="form-control" name="name" wire:model="name"
                                            autocomplete="off" aria-autocomplete="none">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <label class="form-label is-required roboto-font-light">Correo
                                            electrónico:</label>
                                        <input type="text" class="form-control" name="email" wire:model="email"
                                            autocomplete="off" aria-autocomplete="none">
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label is-required roboto-font-light">Teléfono:</label>
                                        <input type="text" class="form-control" name="phone" wire:model="phone"
                                            autocomplete="off" aria-autocomplete="none">
                                        @error('phone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <label class="form-label roboto-font-light">WhatsApp:</label>
                                        <input type="text" class="form-control" name="whatsapp" wire:model="whatsapp"
                                            autocomplete="off" aria-autocomplete="none">
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label is-required roboto-font-light">Nombre de persona de
                                            contacto:</label>
                                        <input type="text" class="form-control" name="contact_person_name"
                                            wire:model="contact_person_name" autocomplete="off"
                                            aria-autocomplete="none">
                                        @error('contact_person_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <label class="form-label roboto-font-light">Página web:</label>
                                        <input type="text" class="form-control" name="website" wire:model="website"
                                            autocomplete="off" aria-autocomplete="none">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="q-box__buttons">
                            <a href="{{ route('voyager.login') }}" style="text-decoration: none">
                                <button id="prev-btn" class="roboto-font-bold" type="button"
                                    style="display:inline-block">Iniciar
                                    sesión</button>
                            </a>
                            <button id="submit-btn" class="roboto-font-bold"
                                style="display:inline-block ; background-color:#F5B029"
                                wire:click="register()">Registrarme</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
