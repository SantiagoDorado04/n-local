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

    @include('livewire.admin.online-registration-courses.modals-contacts.create')
    @include('livewire.admin.online-registration-courses.modals-contacts.feedback')
    @include('livewire.admin.online-registration-courses.modals-contacts.delete')
    @include('livewire.admin.online-registration-courses.modals-contacts.edit')
    @include('livewire.admin.online-registration-courses.modals-contacts.list')
    @include('livewire.admin.online-registration-courses.modals-contacts.show')
    @include('livewire.admin.online-registration-courses.modals-contacts.preview')


    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}">
                    <i class="voyager-boat"></i> {{ __('voyager::generic.dashboard') }}
                </a>
            </li>
            <li><a href="{{ route('online-registrations') }}">Controles de registros</a></li>
            <li><a
                    href="{{ route('online-registration-categories', ['id' => $onlineRegistrationCourse->onlineRegistrationCategory->online_registration_id]) }}">Categorias</a>
            </li>
            <li><a
                    href="{{ route('online-registration-courses', ['id' => $onlineRegistrationCourse->or_category_id]) }}">cursos</a>
            </li>
            <li>Registros de asistentes</li>

        </ol>
    @endsection

    @section('page_title', 'asistentes | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-users"></i>&nbsp;
                Usuarios registrados al curso
            </h1>
            <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal-2"
                title="Clic para crear un nuevo registro">
                <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
            </button>
        </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin-bottom:0px">
                    <div class="panel-body" style="margin-bottom:0px">
                        <small>
                            <ul>
                                <li><strong>Control de registro: </strong>
                                    {{ $onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->name }}<br>
                                </li>
                                <li><strong>Categoria: </strong>
                                    {{ $onlineRegistrationCourse->onlineRegistrationCategory->name }}<br></li>
                                <li><strong>Curso: </strong>
                                    {{ $onlineRegistrationCourse->name }}<br></li>
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
                            {{-- <div class="col-lg-12">
                                <button class="btn btn-success sm-b" wire:click="export()">
                                    <i class="fa fa-file-excel-o"></i>&nbsp;Exportar
                                </button>
                                <button class="btn btn-primary sm-b" data-toggle="modal" data-target="#info-modal-2"><i
                                        class="fa fa-file-excel-o"></i>&nbsp;Importar</button>
                            </div> --}}
                            <div class="col-lg-12">
                                <label><strong>Buscar:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Buscar por nombre, correo o NIT..." />
                            </div>
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="7" class="thwidth text-center">
                                                    <small>
                                                        <strong>Datos registrado</strong>
                                                    </small>
                                                </th>

                                                <th class="thwidth text-center" rowspan="2"><small>Acciones</small>
                                                </th>

                                            </tr>
                                            <tr>
                                                <th class="thwidth"><small>NIT / Cédula</small></th>
                                                <th class="thwidth"><small>Nombre</small></th>
                                                <th class="thwidth"><small>Correo electrónico</small></th>
                                                <th class="thwidth"><small>Teléfono</small></th>
                                                <th class="thwidth"><small>WhatsApp</small></th>
                                                <th class="thwidth"><small>Persona contacto</small></th>
                                                <th class="thwidth"><small>Feedback</small></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($onlineRegistrationContactsCourse as $contactCourse)
                                                <tr>

                                                    <td>{{ $contactCourse->contact->nit }}</td>
                                                    <td>{{ $contactCourse->contact->name }}</td>
                                                    <td>{{ $contactCourse->contact->email }}</td>
                                                    <td>{{ $contactCourse->contact->phone }}</td>

                                                    <td>
                                                        <a href="https://wa.me/+57{{ $contactCourse->contact->phone }}"
                                                            target="_blank">
                                                            {{ $contactCourse->contact->whatsapp }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $contactCourse->contact->contact_person_name }}</td>
                                                    <td>{{ $contactCourse->feedback }}</td>

                                                    <td class="horizontal-layout ">

                                                        <button class="btn btn-success sm-b" data-toggle="modal"
                                                            title="Clic para agregar un feedback"
                                                            data-target="#create-modal"
                                                            wire:click="feedback({{ $contactCourse->id }})"
                                                            style="margin-top:0px">
                                                            <i class="fa fa-commenting-o"></i>
                                                        </button>

                                                        <button class="btn btn-primary sm-b" data-toggle="modal"
                                                            title="Clic para ver las respuestas del formulario"
                                                            data-target="#info-modal"
                                                            wire:click='preview({{ $contactCourse->or_course_id }}, {{ $contactCourse->contact_id }})'>
                                                            <i class="fa fa-list"></i>
                                                        </button>

                                                        <button class="btn btn-primary sm-b" data-toggle="modal"
                                                            title="Clic para editar el registro"
                                                            data-target="#edit-modal-2"
                                                            wire:click="edit({{ $contactCourse->contact_id }})">
                                                            <i class="fa fa-pencil"></i>
                                                        </button>
                                                        <button class="btn btn-danger sm-b" data-toggle="modal"
                                                            title="Clic para eliminar el registro"
                                                            data-target="#delete-modal"
                                                            wire:click="delete({{ $contactCourse->contact_id }})">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="row no-margin-bottom">
                                        <div class="col-lg-6" style="padding-top:22px">
                                            <p>Mostrando {{ $onlineRegistrationContactsCourse->firstItem() }} a
                                                {{ $onlineRegistrationContactsCourse->lastItem() }} de
                                                {{ $onlineRegistrationContactsCourse->total() }} resultados</p>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            {{ $onlineRegistrationContactsCourse->links() }}
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

{{-- <script>
    var fileInput = document.getElementById("filePostulates");
    fileInput.addEventListener("click", function() {
        Livewire.emit('resetFailures');
    });
</script> --}}
