<div>
    @include('livewire.admin.online-registration-characterizations.or-characterization-answers.modals.edit')
    @include('livewire.admin.online-registration-characterizations.or-characterization-answers.modals.delete')
    @include('livewire.admin.online-registration-characterizations.or-characterization-answers.modals.feedback')
    @include('livewire.admin.online-registration-characterizations.or-characterization-answers.modals.preview')
    @include('livewire.admin.online-registration-characterizations.or-characterization-answers.modals.info')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('online-registrations') }}">Controles de registros</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-categories', ['id' => $form->session->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->id]) }}">Categorias</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-courses', ['id' => $form->session->onlineRegistrationCourse->onlineRegistrationCategory->id]) }}">Cursos</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-courses-sessions', ['id' => $form->session->onlineRegistrationCourse->id]) }}">Sesiones</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-characterizations', ['id' => $form->session->id]) }}">Caracterizaciones</a>
            </li>
            <li>
                Respuestas
            </li>
        </ol>
    @endsection

    @section('page_title', 'Respuestas | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-question-circle"></i>&nbsp;Respuestas
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
                                    {{ $form->session->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->name }}
                                </li>
                                <li><strong>Categoria:</strong>
                                    {{ $form->session->onlineRegistrationCourse->onlineRegistrationCategory->name }}
                                </li>
                                <li><strong>Curso:</strong> {{ $form->session->onlineRegistrationCourse->name }}</li>
                                <li><strong>Sesion:</strong> {{ $form->session->name }}</li>
                                <li><strong>Formulario:</strong> {{ $form->name }}</li>
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
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom" style="margin-bottom:12px">
                            <div class="col-lg-12">
                                <label><strong>Buscar:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Ingresa una identificacion o el nombre">
                            </div>
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

                                            <th class="thwidth text-center" rowspan="2"><small>Acciones</small></th>

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
                                        @foreach ($registers as $CharacterizationAnswer)
                                            <tr>
                                                <td>{{ $CharacterizationAnswer->contact->nit }}</td>
                                                <td>{{ $CharacterizationAnswer->contact->name }}</td>
                                                <td>{{ $CharacterizationAnswer->contact->email }}</td>
                                                <td>{{ $CharacterizationAnswer->contact->phone }}</td>
                                                <td>
                                                    <a href="https://wa.me/+57{{ $CharacterizationAnswer->contact->phone }}"
                                                        target="_blank">
                                                        {{ $CharacterizationAnswer->contact->whatsapp }}
                                                    </a>
                                                </td>
                                                <td>{{ $CharacterizationAnswer->contact->contact_person_name }}</td>
                                                <td>{{ $contactCourseID->firstWhere('contact_id', $CharacterizationAnswer->contact_id)->feedback ?? '' }}
                                                </td>
                                                <td class="horizontal-layout">
                                                    @if ($CharacterizationAnswer->answered == 1)
                                                        <button class="btn btn-success sm-b" data-toggle="modal"
                                                            data-target="#create-modal"
                                                            wire:click="feedback({{ $CharacterizationAnswer->contact->id }})"
                                                            style="margin-top:0px">
                                                            <i class="fa fa-commenting-o"></i>
                                                        </button>
                                                        <button class="btn btn-primary sm-b" data-toggle="modal"
                                                            data-target="#info-modal"
                                                            wire:click='preview({{ $CharacterizationAnswer->id }}, {{ $CharacterizationAnswer->contact_id }})'>
                                                            <i class="fa fa-list"></i>
                                                        </button>
                                                        <button class="btn btn-primary sm-b" data-toggle="modal"
                                                            data-target="#edit-modal-2"
                                                            wire:click="edit({{ $CharacterizationAnswer->contact_id }})">
                                                            <i class="fa fa-pencil"></i>
                                                        </button>
                                                        <button class="btn btn-danger sm-b" data-toggle="modal"
                                                            data-target="#delete-modal"
                                                            wire:click="delete({{ $CharacterizationAnswer->contact_id }})">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    @elseif ($CharacterizationAnswer->answered == 0)
                                                        <a data-toggle="modal" data-target="#info-modal-2"
                                                            wire:click="info({{ $CharacterizationAnswer->contact->id }})">Click
                                                            para diligenciar</a>

                                                        <a href="https://wa.me/+57{{ $CharacterizationAnswer->contact->whatsapp }}"
                                                            target="_blank" class="btn btn-success">
                                                            <i class="fa fa-whatsapp"></i> Contactar
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
