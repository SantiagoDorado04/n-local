<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="page-content browse container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('commercial.send-form-action', ['token' => $token]) }}"
                                method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="text-center">{{ $form->name }}</h5>
                                    </div>
                                    <div class="col-md-12">
                                        <p>{{ $form->description }}</p>
                                    </div>
                                    @if (Session::has('success'))
                                    <div class="col-md-12">

                                        <div class="alert alert-success" role="alert">
                                            <h4 class="alert-heading"><strong>Excelente!</strong> {{ session('success')
                                                }}</h4>
                                            @if (is_array($anContact))
                                            @if (count($anContact)>0)
                                            <p>De acuerdo a sus respuestas del formulario, aplica a las siguientes
                                                convocatorias.</p>
                                            <hr>
                                            <ul>
                                                @foreach ($anContact as $contact)
                                                @foreach ($announcements as $announcement)
                                                @if ($announcement->id == $contact)
                                                <li>{{ $announcement->name }}</li>
                                                @endif
                                                @endforeach
                                                @endforeach
                                            </ul>
                                            @endif
                                            @else
                                            <p>Por el momento no hay convocatorias disponibles.</p>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-md-12">
                                        <span class="text-center">
                                            <h5>Información General</h5>
                                        </span>
                                        <br>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <label><strong>NIT:</strong></label>
                                                        <input type="text" class="form-control" name="nit"
                                                            value="{{ old('nit') }}">
                                                        @error('nit')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label><strong>Nombre de la empresa:</strong></label>
                                                        <input type="text" class="form-control" name="name"
                                                            value="{{ old('name') }}">
                                                        @error('name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <label><strong>Teléfono:</strong></label>
                                                        <input type="phone" class="form-control" name="phone"
                                                            value="{{ old('phone') }}">
                                                        @error('phone')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label><strong>Número de WhatsApp:</strong></label>
                                                        <input type="phone" class="form-control" name="whatsapp"
                                                            value="{{ old('whatsapp') }}">
                                                        @error('whatsapp')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <label><strong>Correo electrónico:</strong></label>
                                                        <input type="email" class="form-control" name="email"
                                                            value="{{ old('email') }}">
                                                        @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label><strong>Nombre de persona de contacto:</strong></label>
                                                        <input type="text" class="form-control"
                                                            name="contact_person_name"
                                                            value="{{ old('contact_person_name') }}">
                                                        @error('contact_person_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <label><strong>Página Web:</strong></label>
                                                        <input type="url" class="form-control" name="website"
                                                            value="{{ old('website') }}">
                                                        @error('website')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card" style="margin-top:20px">
                                            <div class="card-body">
                                                <div class="row no-margin-bottom">
                                                    @foreach ($questions as $question)
                                                    <div class="col-md-12">
                                                        <div class="row no-margin-bottom">
                                                            <div class="col-md-1">
                                                                <strong>{{ $loop->iteration . '. ' }}</strong>
                                                            </div>
                                                            <div class="col-md-11">
                                                                {!! nl2br($question->question) !!}
                                                                @if ($question->type == 'po')
                                                                <br>
                                                                <br>
                                                                @foreach ($options as $option)
                                                                @if ($option->commercial_form_question_id ==
                                                                $question->id)
                                                                <input type="radio" name="question_{{ $question->id }}"
                                                                    value="{{ $option->value }}" {{ old('question_'.
                                                                    $question->id)==$option->value ?
                                                                'checked='.'"checked"' : '' }} required>
                                                                <label for="html">{{ $option->option }}</label><br>
                                                                @endif
                                                                @endforeach
                                                                @else
                                                                <br>
                                                                <br>
                                                                <textarea class="form-control"
                                                                    name="question_{{ $question->id }}"
                                                                    required>{{old('question_'. $question->id)}}</textarea>

                                                                @endif
                                                                @error('question_{{ $question->id }}')
                                                                <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <button class="btn btn-success">Enviar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.3.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    {{-- <script>
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 4000);
    </script> --}}
</body>

</html>