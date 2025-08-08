<div>
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('online-registrations') }}">Controles de registro</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-categories', ['id' => $session->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->id]) }}">Categorias</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-courses', ['id' => $session->onlineRegistrationCourse->onlineRegistrationCategory->id]) }}">Cursos</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-courses-sessions', ['id' => $session->onlineRegistrationCourse->id]) }}">Sesiones</a>
            </li>
            <li>
                <a href="{{ route('online-registration-sessionContent', ['id' => $session->id]) }}">Contenidos</a>
            </li>

            <li>
                <a>Test</a>
            </li>
        </ol>
    @endsection

    @section('page_title', 'Test | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-documentation"></i>&nbsp; Crear test
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
                                {{ $session->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->name }}<br>
                            </li>
                            <li><strong>Categoria: </strong>
                                {{ $session->onlineRegistrationCourse->onlineRegistrationCategory->name }}<br></li>
                            <li><strong>Curso: </strong> {{ $session->onlineRegistrationCourse->name }}<br></li>
                            <li><strong>Sesión: </strong> {{ $session->name }}<br></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label is-required">Título:</label>
                            <input type="text" class="form-control" wire:model="title"
                                placeholder="Ingrese el título del test">
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <br>
                        <div class="mb-3">
                            <label class="form-label is-required"><strong>Descripción:</strong></label>
                            <textarea class="form-control" rows="10" placeholder="Ingrese la descripción" wire:model="description"></textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <br>
                        <div class="mb-3">
                            <label class="form-label">I<strong>nstrucciones:</strong></label>
                            <textarea class="form-control" rows="10" placeholder="Ingrese las instrucciones" wire:model="instructions"></textarea>
                            @error('instructions')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <br>
                        <div class="mb-3" style="max-width: 16%;">
                            <label class="is-required"><strong>Porcentaje de aprobacion %: </strong></label>
                            <input type="number" class="form-control" wire:model="percentage">
                            @error('percentage')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <br>
                        <br>
                        <div class="text-center">
                            <a href="{{ route('online-registration-sessionContent', ['id' => $this->session->id]) }}"
                                class="btn btn-danger">
                                <i class="fa fa-arrow-left "></i> Volver
                            </a>
                            <button class="btn btn-success" wire:click="store()"><i class="fa fa-save"></i>
                                Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
