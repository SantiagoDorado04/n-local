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

    @include('livewire.admin.challenges.modals-files.create')
    @include('livewire.admin.course-registration-forms.modals-attendee.create')
    @include('livewire.admin.course-registration-forms.modals-attendee.edit')
    @include('livewire.admin.course-registration-forms.modals-attendee.delete')
    @include('livewire.admin.course-registration-forms.modals-attendee.upload')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}">
                    <i class="voyager-boat"></i> {{ __('voyager::generic.dashboard') }}
                </a>
            </li>
            <li><a href="{{ route('online-registrations') }}">Controles de registros</a></li>

            <li><a href="{{ route('course-regisration-forms', ['id' => $courseRegistrationForm->online_registration_id]) }}">Formularios
                    de control de registro</a></li>
            <li>Registros de asistentes</li>
        </ol>
    @endsection

    @section('page_title', 'asistentes | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-users"></i>&nbsp;
                Listado de asistentes
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
                                <li><strong>Control de registro: </strong>
                                    {{ $courseRegistrationForm->onlineRegistration->name }}<br></li>
                                <li><strong>Formulario de control de registro: </strong>
                                    {{ $courseRegistrationForm->name }}<br></li>
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
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Buscar por nombre, correo o NIT..." />
                            </div>
                            {{-- @if (!$form->course_registration_form == '')
                                {
                                <div class="col-lg-12">
                                    <label for="orderBy">Ordenar por puntos:</label>
                                    <select id="orderBy" class="form-control" wire:model="orderBy">
                                        <option value="asc">Ascendente</option>
                                        <option value="desc">Descendente</option>
                                    </select>
                                </div>
                                }
                            @endif --}}
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="11" class="thwidth text-center">
                                                    <small>
                                                        <strong>Datos asistente</strong>
                                                    </small>
                                                </th>
                                                <th colspan="{{ count($questions) > 0 ? count($questions) : 1 }}"
                                                    class="thwidth text-center">
                                                    <small>
                                                        <strong>Respuestas Formulario</strong>
                                                    </small>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="thwidth"><small>Acciones</small></th>
                                                <th class="thwidth"><small>Estado</small></th>
                                                <th class="thwidth"><small>Feedback</small></th>
                                                <th class="thwidth"><small>Texto feedback</small></th>
                                                <th class="thwidth"><small>NIT / Cédula</small></th>
                                                <th class="thwidth"><small>Nombre de la empresa</small></th>
                                                <th class="thwidth"><small>Correo electrónico</small></th>
                                                <th class="thwidth"><small>Teléfono</small></th>
                                                <th class="thwidth"><small>WhatsApp</small></th>
                                                <th class="thwidth"><small>Persona contacto</small></th>
                                                <x-table-column field="points" sortField="{{ $sortField }}"
                                                    sortDirection="{{ $sortDirection }}" label="Puntos" />
                                                @foreach ($questions as $question)
                                                    <th class="thwidth"><small>{{ $question->text }}</small></th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($contactsCourseRegistrationForm as $contactCourseRegistrationForm)
                                                <tr>
                                                    <td class="horizontal-layout">
                                                        <button class="btn btn-primary sm-b" data-toggle="modal"
                                                            data-target="#edit-modal-2"
                                                            wire:click="edit({{ $contactCourseRegistrationForm->contact_id }})">
                                                            <i class="fa fa-pencil"></i>
                                                        </button>
                                                        <button class="btn btn-danger sm-b" data-toggle="modal"
                                                            data-target="#delete-modal-2"
                                                            wire:click="delete({{ $contactCourseRegistrationForm->contact_id }})">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                        <div class="switch {{ $contactCourseRegistrationForm->approved ? 'switch-on' : 'switch-off' }}"
                                                            wire:click="toggleApproval({{ $contactCourseRegistrationForm->id }})">
                                                            <div></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="label {{ $contactCourseRegistrationForm->approved ? 'label-success' : 'label-primary' }}">
                                                            {{ $contactCourseRegistrationForm->approved ? 'Asistió' : 'No Asistió' }}
                                                        </span>
                                                    </td>
                                                    <td
                                                        style="text-align: center; vertical-align: middle; padding-top:0px">
                                                        <button class="btn btn-success sm-b" data-toggle="modal"
                                                            data-target="#create-modal"
                                                            wire:click="feedback({{ $contactCourseRegistrationForm->id }})"
                                                            style="margin-top:0px">
                                                            <i class="fa fa-commenting-o"></i>
                                                        </button>
                                                    </td>
                                                    <td>{{ $contactCourseRegistrationForm->feedback }}</td>
                                                    <td>{{ $contactCourseRegistrationForm->contact->nit }}</td>
                                                    <td>{{ $contactCourseRegistrationForm->contact->name }}</td>
                                                    <td>{{ $contactCourseRegistrationForm->contact->email }}</td>
                                                    <td>{{ $contactCourseRegistrationForm->contact->phone }}</td>
                                                    <td>{{ $contactCourseRegistrationForm->contact->whatsapp }}</td>
                                                    <td>{{ $contactCourseRegistrationForm->contact->contact_person_name }}
                                                    </td>
                                                    <td>{{ $contactCourseRegistrationForm->contact->points }}</td>
                                                    @foreach ($questions as $question)
                                                        @php
                                                            $answer = $contactCourseRegistrationForm->informationFormAnswers
                                                                ->where('question_id', $question->id)
                                                                ->first();
                                                        @endphp
                                                        <td>{{ $answer ? $answer->answer : '' }}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div>
                                        <p>Mostrando {{ $contactsCourseRegistrationForm->firstItem() }} a
                                            {{ $contactsCourseRegistrationForm->lastItem() }} de
                                            {{ $contactsCourseRegistrationForm->total() }} resultados</p>
                                        {{ $contactsCourseRegistrationForm->links() }}
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
