<div>
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
            background-color: #ccc;
            border-radius: 20px;
            padding: 2px;
            cursor: pointer;
        }

        .switch::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: white;
            top: 1px;
            left: 1px;
            transition: transform 0.3s ease-in-out;
        }

        .switch-on {
            background-color: #4CAF50;
        }

        .switch-off {
            background-color: #2196F3;
        }

        .switch-on::after {
            transform: translateX(20px);
        }

        .horizontal-layout {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .horizontal-layout .btn,
        .horizontal-layout .switch,
        .horizontal-layout .label {
            margin: 0;
        }
    </style>

    {{-- @include('livewire.admin.challenges.modals-files.create')
    @include('livewire.admin.stages.modals-postulates.create')
    @include('livewire.admin.stages.modals-postulates.edit')
    @include('livewire.admin.stages.modals-postulates.delete')
    @include('livewire.admin.stages.modals-postulates.upload') --}}

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}">
                    <i class="voyager-boat"></i> {{ __('voyager::generic.dashboard') }}
                </a>
            </li>
            <li><a href="{{ route('online-registrations') }}">Controles de registro</a></li>
            <li><a
                    href="{{ route('online-registration-categories', ['id' => $course->onlineRegistrationCategory->onlineRegistration->id]) }}">Categorias</a>
            </li>
            <li><a
                    href="{{ route('online-registration-courses', ['id' => $course->onlineRegistrationCategory->id]) }}">Cursos</a>
            </li>
            <li>Asistencias</li>
        </ol>
    @endsection

    @section('page_title', 'Asistentes | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-users"></i>&nbsp; Respuestas Del Formulario
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
                                <li><strong>Control de registro:</strong>
                                    {{ $course->onlineRegistrationCategory->onlineRegistration->name }}</li>
                                <li><strong>Categoria:</strong> {{ $course->onlineRegistrationCategory->name }}</li>
                                <li><strong>Curso:</strong> {{ $course->name }}</li>
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
                <div class="panel panel-bordered" style="margin: 0px">
                    <div class="panel-body" style="margin: 0px">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12 text-left mb-3">
                                <button class="btn btn-primary" wire:click="saveAttendances()" title="Clic para guardar cambios">Guardar cambios</button>
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Buscar por nombre o cédula..." />
                            </div>
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="thwidth text-center">
                                                    <small><strong>Datos registrados</strong></small>
                                                </th>
                                                <th colspan="{{ count($sessions) > 0 ? count($sessions) + 1 : 1 }}"
                                                    class="thwidth text-center">
                                                    <small><strong>Sesiones</strong></small>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="thwidth"><small>NIT / Cédula</small></th>
                                                <th class="thwidth"><small>Nombre de la empresa</small></th>
                                                @foreach ($sessions as $session)
                                                    <th class="thwidth"><small>{{ $session->name }}</small></th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ContactsCourse as $contact)
                                                <tr>
                                                    <td>{{ $contact->contact->nit }}</td>
                                                    <td>{{ $contact->contact->name }}</td>
                                                    @if (count($sessions) > 0)
                                                        @foreach ($sessions as $session)
                                                            <td class="text-center">
                                                                <input type="checkbox" {{-- wire:click="toggleAttendance({{ $contact->id }}, {{ $session->id }})" // Desactivado temporalmente --}}
                                                                    wire:model="attendances.{{ $contact->contact_id }}.{{ $session->id }}"
                                                                    @if (isset($attendances[$contact->contact_id][$session->id]) && $attendances[$contact->contact_id][$session->id]) checked @endif>
                                                            </td>
                                                        @endforeach
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-12 text-center mt-3">
                                <button class="btn btn-primary" wire:click="saveAttendances()" title="Clic para guardar cambios">Guardar cambios</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
