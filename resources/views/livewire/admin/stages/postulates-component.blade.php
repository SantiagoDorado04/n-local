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
    @include('livewire.admin.stages.modals-postulates.create')
    @include('livewire.admin.stages.modals-postulates.edit')
    @include('livewire.admin.stages.modals-postulates.delete')
    @include('livewire.admin.stages.modals-postulates.upload')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}">
                    <i class="voyager-boat"></i> {{ __('voyager::generic.dashboard') }}
                </a>
            </li>
            @if ($form->stage_id == '')
                <li><a href="{{ route('processes') }}">Procesos</a></li>
                <li><a href="{{ route('stages', ['id' => $form->step->stage->process_id]) }}">Etapas</a></li>
                <li><a href="{{ route('steps', ['id' => $form->step->stage->id]) }}">Pasos</a></li>
                <li><a href="{{ route('information-forms', ['id' => $form->step_id]) }}">Formularios</a></li>
                <li>Respuestas</li>
            @else
                <li><a href="{{ route('processes') }}">Procesos</a></li>

                <li><a href="{{ route('stages', ['id' => $stage->process_id]) }}">Etapas</a></li>
                <li>Postulados</li>
            @endif
        </ol>
    @endsection

    @section('page_title', $form->stage_id == '' ? 'Respuestas | ' . setting('admin.title') : 'Postulados | ' .
        setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="{{ $form->stage_id == '' ? 'fa fa-check-square-o' : 'fa fa-users' }}"></i>&nbsp;
                {{ $form->stage_id == '' ? 'Respuestas Formulario' : 'Listado de postulados' }}
            </h1>
            @if ($form->stage_id != '')
                <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal-2">
                    <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
                </button>
            @endif
        </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin-bottom:0px">
                    <div class="panel-body" style="margin-bottom:0px">
                        <small>
                            <ul>
                                @if ($form->stage_id == '')
                                    <li><strong>Proceso:</strong> {{ $form->step->stage->process->name }}</li>
                                    <li><strong>Etapa:</strong> {{ $form->step->stage->name }}</li>
                                    <li><strong>Paso:</strong> {{ $form->step->name }}</li>
                                    <li><strong>Formulario:</strong> {{ $form->name }}</li>
                                @else
                                    <li><strong>Proceso: </strong> {{ $stage->process->name }}<br></li>
                                    <li><strong>Etapa: </strong> {{ $stage->name }}<br></li>
                                @endif
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
                                <button class="btn btn-success sm-b" wire:click="export()">
                                    <i class="fa fa-file-excel-o"></i>&nbsp;Exportar
                                </button>
                                <button class="btn btn-primary sm-b" data-toggle="modal" data-target="#info-modal-2"><i
                                        class="fa fa-file-excel-o"></i>&nbsp;Importar</button>
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Buscar por nombre, correo o NIT..." />
                            </div>
                            {{-- @if (!$form->stage_id == '')
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
                                                <th colspan="10" class="thwidth text-center">
                                                    <small>
                                                        <strong>Datos Postulado</strong>
                                                    </small>
                                                </th>
                                                <th colspan="{{ count($questions) > 0 ? count($questions) + 1 : 1 }}"
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
                                                <th class="thwidth"><small>Feedback</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($postulates as $postulate)
                                                <tr>
                                                    <td class="horizontal-layout">
                                                        <button class="btn btn-primary sm-b" data-toggle="modal"
                                                            data-target="#edit-modal-2"
                                                            wire:click="edit({{ $postulate->contact_id }})">
                                                            <i class="fa fa-pencil"></i>
                                                        </button>
                                                        <button class="btn btn-danger sm-b" data-toggle="modal"
                                                            data-target="#delete-modal-2"
                                                            wire:click="delete({{ $postulate->contact_id }})">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                        @if ($form->stage_id != '')
                                                            <div class="switch {{ $postulate->approved ? 'switch-on' : 'switch-off' }}"
                                                                wire:click="toggleApproval({{ $postulate->id }})">
                                                                <div></div>
                                                            </div>
                                                        @else
                                                            <div class="switch {{ $postulate->approved ? 'switch-on' : 'switch-off' }}"
                                                                wire:click="toggleApprovalForm({{ $postulate->id }})">
                                                                <div></div>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($form->stage_id != '')
                                                            <span
                                                                class="label {{ $postulate->approved ? 'label-success' : 'label-primary' }}">
                                                                {{ $postulate->approved ? 'Aprobado' : 'No Aprobado' }}
                                                            </span>
                                                        @else
                                                            <span
                                                                class="label {{ $postulate->approved ? 'label-success' : 'label-primary' }}">
                                                                {{ $postulate->approved ? 'Revisado' : 'Sin Revisar' }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td
                                                        style="text-align: center; vertical-align: middle; padding-top:0px">
                                                        <button class="btn btn-success sm-b" data-toggle="modal"
                                                            data-target="#create-modal"
                                                            wire:click="feedback({{ $postulate->id }})"
                                                            style="margin-top:0px">
                                                            <i class="fa fa-commenting-o"></i>
                                                        </button>
                                                    </td>
                                                    <td>{{ $postulate->contact->nit }}</td>
                                                    <td>{{ $postulate->contact->name }}</td>
                                                    <td>{{ $postulate->contact->email }}</td>
                                                    <td>{{ $postulate->contact->phone }}</td>
                                                    <td>{{ $postulate->contact->whatsapp }}</td>
                                                    <td>{{ $postulate->contact->contact_person_name }}</td>
                                                    <td>{{ $postulate->contact->points }}</td>
                                                    @if (count($questions) > 0)
                                                        @foreach ($questions as $question)
                                                            @php
                                                                $answer = $postulate->informationFormAnswers
                                                                    ->where('question_id', $question->id)
                                                                    ->first();
                                                            @endphp
                                                            <td>{{ $answer ? $answer->answer : '' }}</td>
                                                        @endforeach
                                                    @else
                                                        <td></td>
                                                    @endif
                                                    <td>{{ $postulate->feedback }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div>
                                        <p>Mostrando {{ $postulates->firstItem() }} a
                                            {{ $postulates->lastItem() }} de
                                            {{ $postulates->total() }} resultados</p>
                                        {{ $postulates->links() }}
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

<script>
    var fileInput = document.getElementById("filePostulates");
    fileInput.addEventListener("click", function() {
        Livewire.emit('resetFailures');
    });
</script>
