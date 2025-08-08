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

        .badge-approved {
            margin-top: 8px;
            background-color: #4CAF50;
            font-weight: normal;
        }

        .badge-not-approved {
            margin-top: 8px;
            background-color: #FF5722;
            font-weight: normal;
        }
    </style>

    @include('livewire.admin.challenges.modals-files.create')

    @section('page_title', 'Listado Participantes | ' . setting('admin.title'))

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('processes') }}">Procesos</a>
            </li>
            <li>
                <a href="{{ route('stages', ['id' => $course->step->stage->process_id]) }}">Etapas</a>
            </li>
            <li>
                <a href="{{ route('steps', ['id' => $course->step->stage_id]) }}">Pasos</a>
            </li>
            <li>
                <a href="{{ route('courses', ['id' => $course->step_id]) }}">Cursos</a>
            </li>
            <li>
                Listado Participantes Curso
            </li>
        </ol>
    @endsection

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-people"></i>&nbsp;Listado Participantes Curso {{ "' " . $course->name . " '" }}
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
                                <li><strong>Proceso:</strong> {{ $course->step->stage->process->name }}</li>
                                <li><strong>Etapa:</strong> {{ $course->step->stage->name }}</li>
                                <li><strong>Paso:</strong> {{ $course->step->name }}</li>
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
                            <div class="col-lg-12">
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Buscar por nombre, correo o NIT..." />
                            </div>
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="thwidth"><small>Aprobación</small></th>
                                                <th class="thwidth"><small>Feedback</small></th>
                                                <th class="thwidth"><small>Estado</small></th>
                                                <th class="thwidth"><small>NIT / Cédula</small></th>
                                                <th class="thwidth"><small>Nombre de la empresa</small></th>
                                                <th class="thwidth"><small>Correo electrónico</small></th>
                                                <th class="thwidth"><small>Teléfono</small></th>
                                                <th class="thwidth"><small>WhatsApp</small></th>
                                                <th class="thwidth"><small>Persona contacto</small></th>
                                                <th class="thwidth"><small>Lecciones vistas</small></th>
                                                <th class="thwidth"><small>Total Lecciones</small></th>
                                                <th class="thwidth"><small>Completado</small></th>
                                                <th style="min-width:300px"><small>Feedback</small></th>
                                                <th style="min-width:300px"><small>Puntos</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{--  participants->feedback
                                            participants->contact... --}}
                                            @foreach ($contactsStage as $contactStage)
                                                @php
                                                    $foundChallengeContact = $coursesContacts
                                                        ->where('contact_id', $contactStage->contact_id)
                                                        ->first();
                                                @endphp
                                                <tr>
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        @if ($foundChallengeContact)
                                                            <div class="switch {{ $foundChallengeContact->approved ? 'switch-on' : 'switch-off' }}"
                                                                style="margin-top:5px"
                                                                wire:click="toggleApproval({{ $foundChallengeContact->id }})">
                                                                <div></div>
                                                            </div>
                                                        @endif
                                                    </td>

                                                    <td style="text-align: center; vertical-align: middle;">
                                                        @if ($foundChallengeContact)
                                                            <button class="btn btn-success sm-b" data-toggle="modal"
                                                                data-target="#create-modal"
                                                                wire:click="feedback({{ $foundChallengeContact->id }})">
                                                                <i class="fa fa-commenting-o"></i> &nbsp;Feedback
                                                            </button>
                                                        @endif
                                                    </td>

                                                    <td style="text-align: center; vertical-align: middle;">
                                                        @if ($foundChallengeContact)
                                                            @if ($foundChallengeContact->approved === 1)
                                                                <h5 style="margin-top:1px">
                                                                    <span class="label label-success">Aprobado</span>
                                                                </h5>
                                                            @elseif ($foundChallengeContact->approved === 0)
                                                                <h5 style="margin-top:1px">
                                                                    <span class="label label-danger">No Aprobado</span>
                                                                </h5>
                                                            @elseif ($foundChallengeContact->approved == '')
                                                                <h5 style="margin-top:1px">
                                                                    <span class="label label-warning">Sin
                                                                        Verificar</span>
                                                                </h5>
                                                            @endif
                                                        @else
                                                            <span class="label label-danger">Sin Iniciar</span>
                                                        @endif
                                                    </td>

                                                    <td>{{ $contactStage->contact->nit }}</td>
                                                    <td>{{ $contactStage->contact->name }}</td>
                                                    <td>{{ $contactStage->contact->email }}</td>
                                                    <td>{{ $contactStage->contact->phone }}</td>
                                                    <td>{{ $contactStage->contact->whatsapp }}</td>
                                                    <td>{{ $contactStage->contact->contact_person_name }}</td>
                                                    </td>
                                                    <td>{{ $foundChallengeContact ? $foundChallengeContact->lessons_number : '' }}
                                                    </td>
                                                    <td>{{ $foundChallengeContact ? $foundChallengeContact->total_lessons : '' }}
                                                    </td>
                                                    {{-- <td>{{ $foundChallengeContact ? $foundChallengeContact->complete : '' }}</td> --}}
                                                    <td style="text-align: center; vertical-align: middle;">
                                                        @if ($foundChallengeContact)
                                                            @if ($foundChallengeContact->complete === 1)
                                                                <h5 style="margin-top:1px">
                                                                    <span class="label label-success">Completado</span>
                                                                </h5>
                                                            @elseif ($foundChallengeContact->complete === 0)
                                                                <h5 style="margin-top:1px">
                                                                    <span class="label label-danger">No
                                                                        Completado</span>
                                                                </h5>
                                                            @endif
                                                        @else
                                                            <span class="label label-warning">Sin Iniciar</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $foundChallengeContact ? $foundChallengeContact->feedback : '' }}
                                                    </td>
                                                    <td>{{ $contactStage->contact->points }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div>
                                        <p>Mostrando {{ $contactsStage->firstItem() }} a
                                            {{ $contactsStage->lastItem() }} de
                                            {{ $contactsStage->total() }} resultados</p>
                                        {{ $contactsStage->links() }}
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
