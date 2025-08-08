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
            background-color: #4CAF50;
        }

        .badge-not-approved {
            background-color: #FF5722;
        }
    </style>

    @include('livewire.admin.challenges.modals-files.create')

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
                <a href="{{ route('stages', ['id' => $mentor->step->stage->process_id]) }}">Etapas</a>
            </li>
            <li>
                <a href="{{ route('steps', ['id' => $mentor->step->stage->id]) }}">Pasos</a>
            </li>
            <li>
                <a href="{{ route('mentoring', ['id' => $mentor->step->id]) }}">Mentores</a>
            </li>
            <li>
                Asistencia Mentorias
            </li>
        </ol>
    @endsection

    @section('page_title', 'Mentorias | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-calendar-check-o"></i> Mentorias
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
                                <li><strong>Proceso: </strong> {{ $mentor->step->stage->process->name }}<br></li>
                                <li><strong>Etapa: </strong> {{ $mentor->step->stage->name }}<br></li>
                                <li><strong>Paso: </strong> {{ $mentor->step->name }}<br></li>
                                <li><strong>Mentor: </strong> {{ $mentor->name }}<br></li>
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
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Buscar por nombre, correo o NIT..." />
                            </div>
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th><small>Acciones</small></th>
                                                <th><small>Estado</small></th>
                                                <th><small>Feedback</small></th>
                                                <th><small>NIT / Cédula</small></th>
                                                <th><small>Nombre de la empresa</small></th>
                                                <th><small>Correo electrónico</small></th>
                                                <th><small>Teléfono</small></th>
                                                <th><small>WhatsApp</small></th>
                                                <th><small>Persona contacto</small></th>
                                                <th><small>Fecha</small></th>
                                                <th><small>Desde</small></th>
                                                <th><small>Hasta</small></th>
                                                <th><small>Acciones</small></th>
                                                <th><small>Feedback</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mentoring as $item)
                                                <tr>
                                                    <td>
                                                        <div class="switch {{ $item->attended ? 'switch-on' : 'switch-off' }}"
                                                            wire:click="toggleAttended({{ $item->id }})">
                                                            <div></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $labelClass = '';
                                                            $labelText = '';

                                                            if ($item->attended === 1) {
                                                                $labelClass = 'label-success';
                                                                $labelText = 'Asistió';
                                                            } elseif ($item->attended === 0) {
                                                                $labelClass = 'label-danger';
                                                                $labelText = 'No Asistió';
                                                            } else {
                                                                $labelClass = 'label-primary';
                                                                $labelText = 'Pendiente';
                                                            }
                                                        @endphp
                                                        <span
                                                            class="label {{ $labelClass }}">{{ $labelText }}</span>
                                                    </td>
                                                    <td
                                                        style="text-align: center; vertical-align: middle; padding-top:0px">
                                                        <button class="btn btn-success sm-b" data-toggle="modal"
                                                            data-target="#create-modal"
                                                            wire:click="feedback({{ $item->id }})"
                                                            style="margin-top:0px">
                                                            <i class="fa fa-commenting-o"></i>
                                                        </button>
                                                    </td>
                                                    <td>{{ $item->contact->nit }}</td>
                                                    <td>{{ $item->contact->name }}</td>
                                                    <td>{{ $item->contact->email }}</td>
                                                    <td>{{ $item->contact->phone }}</td>
                                                    <td>{{ $item->contact->whatsapp }}</td>
                                                    <td>{{ $item->contact->contact_person_name }}</td>
                                                    <td>{{ $item->date }}</td>
                                                    <td>{{ $item->start }}</td>
                                                    <td>{{ $item->end }}</td>
                                                    <td>
                                                        <button wire:click="confirmDelete({{ $item->id }})"
                                                            class="btn btn-danger sm-b"
                                                            onclick="return confirm('¿Estás seguro de que deseas eliminar esta mentoria?')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>

                                                    <td>{{ $item->feedback }}</td>
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
</div>
