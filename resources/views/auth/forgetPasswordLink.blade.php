@extends('voyager::auth.master')
@section('content')
    <div class="login-container">

        <h4>Restablecer contraseña</h4>

        <form action="{{ route('reset.password.post') }}" method="POST">
            {{ csrf_field() }}
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group form-group-default" id="emailGroup">
                <h5>Correo electronico:</h5>
                <div class="controls">
                    <input type="text" name="email" id="email" class="form-control" name="email" required
                        autofocus>
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group form-group-default" id="passwordGroup">
                <h5>Nueva Contraseña:</h5>
                <div class="controls">
                    <input type="password" name="password" placeholder="{{ __('voyager::generic.password') }}"
                        class="form-control" required autofocus>
                    @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group form-group-default" id="passwordGroup">
                <h5>Confirmar Contraseña:</h5>
                <div class="controls">
                    <input type="password" name="password_confirmation" placeholder="{{ __('voyager::generic.password') }}"
                        class="form-control" required autofocus>
                    @if ($errors->has('password_confirmation'))
                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>
            </div>

            <button type="submit" class="btn btn-block login-button">
                Restablecer contraseña
            </button>

        </form>

        <div style="clear:both"></div>

        @if (!$errors->isEmpty())
            <div class="alert alert-red">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div> <!-- .login-container -->
@endsection

@section('post_js')
    <script>
        var btn = document.querySelector('button[type="submit"]');
        var form = document.forms[0];
        var email = document.querySelector('[name="email"]');
        var password = document.querySelector('[name="password"]');
        btn.addEventListener('click', function(ev) {
            if (form.checkValidity()) {
                btn.querySelector('.signingin').className = 'signingin';
                btn.querySelector('.signin').className = 'signin hidden';
            } else {
                ev.preventDefault();
            }
        });
        email.focus();
        document.getElementById('emailGroup').classList.add("focused");

        // Focus events for email and password fields
        email.addEventListener('focusin', function(e) {
            document.getElementById('emailGroup').classList.add("focused");
        });
        email.addEventListener('focusout', function(e) {
            document.getElementById('emailGroup').classList.remove("focused");
        });

        password.addEventListener('focusin', function(e) {
            document.getElementById('passwordGroup').classList.add("focused");
        });
        password.addEventListener('focusout', function(e) {
            document.getElementById('passwordGroup').classList.remove("focused");
        });
    </script>
@endsection
