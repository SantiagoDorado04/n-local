<div>
    @include('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.test-contents.test-response-modal.show')
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li><a href="{{ route('online-registrations') }}">Controles de registro</a></li>
            <li><a
                    href="{{ route('online-registration-categories', ['id' => $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->id]) }}">Categorias</a>
            </li>
            <li><a
                    href="{{ route('online-registration-courses', ['id' => $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->id]) }}">Cursos</a>
            </li>
            <li><a
                    href="{{ route('online-registration-courses-sessions', ['id' => $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->id]) }}">Sesiones</a>
            </li>
            <li><a
                    href="{{ route('online-registration-sessionContent', ['id' => $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->id]) }}">Contenidos</a>
            </li>
            <li><a>Lección</a></li>
        </ol>
    @endsection

    @section('page_title', 'Test | ' . setting('admin.title'))
    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-book"></i>&nbsp; Previsualización del test
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
                                {{ $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->name }}<br>
                            </li>
                            <li><strong>Categoria: </strong>
                                {{ $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->name }}<br>
                            </li>
                            <li><strong>Curso: </strong>
                                {{ $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->name }}<br>
                            </li>
                            <li><strong>Sesión: </strong>
                                {{ $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->name }}<br>
                            </li>
                            <li><strong>Test: </strong> {{ $test->onlineRegistrationSessionContent->title }}<br></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="8" class="thwidth text-center">
                            <small>
                                <strong>Informacion de los usuarios</strong>
                            </small>
                        </th>
                        <th colspan="1" rowspan="2" class="thwidth text-center">
                            <small>
                                <strong>Acciones</strong>
                            </small>
                        </th>
                    </tr>
                    <tr>
                        <th class="thwidth"><small>NIT / Cédula</small></th>
                        <th class="thwidth"><small>Nombre</small></th>
                        <th class="thwidth"><small>Correo electrónico</small></th>
                        <th class="thwidth"><small>Teléfono</small></th>
                        <th class="thwidth"><small>WhatsApp</small></th>
                        <th class="thwidth"><small>No. de intentos</small></th>
                        <th class="thwidth"><small>% de aciertos</small></th>
                        <th class="thwidth"><small>Estado</small></th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($userRegistered as $userRegister)
                        <tr>

                            <td>{{ $userRegister->contact->nit }}</td>
                            <td>{{ $userRegister->contact->name }}</td>
                            <td>{{ $userRegister->contact->email }}</td>
                            <td>{{ $userRegister->contact->phone }}</td>

                            <td>
                                <a href="https://wa.me/+57{{ $userRegister->contact->phone }}" target="_blank">
                                    {{ $userRegister->contact->whatsapp }}
                                </a>
                            </td>

                            <td>{{ $userRegister->attempts }}</td>
                            <td>{{ $userRegister->hits }}</td>
                            @if ($userRegister->approved == 1)
                                <td><span class="label label-success">Aprobado</span></td>
                            @elseif ($userRegister->approved == 0)
                                <td><span class="label label-danger">Reprobado</span></td>
                            @endif

                            <td>
                                <button class="btn btn-success sm-b" data-toggle="modal"
                                    title="Clic para eliminar el registro" data-target="#show-modal"
                                    wire:click="show({{ $test->id }}, {{ $userRegister->contact->id }})">
                                    <i class="fa fa-eye"></i>
                                    Respuestas
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
