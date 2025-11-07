<div>
    @include('livewire.admin.process-compliance-verification.modals-answers.preview')
    @include('livewire.admin.process-compliance-verification.modals-answers.delete')

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
                <a href="{{ route('stages', ['id' => $compliance->step->stage->process_id]) }}">Etapas</a>
            </li>
            <li>
                <a href="{{ route('steps', ['id' => $compliance->step->stage_id]) }}">Pasos</a>
            </li>
            <li>Respuestas del formulario: {{ $compliance->name }}
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
                                <li><strong>Proceso:</strong>
                                    {{ $compliance->step->stage->process->name }}
                                </li>
                                <li><strong>Estapa:</strong>
                                    {{ $compliance->step->stage->name }}
                                </li>
                                <li><strong>Paso:</strong> {{ $compliance->step->name }}</li>
                                <li><strong>Verificacicon:</strong> {{ $compliance->name }}</li>
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
                                            <th colspan="6" class="thwidth text-center">
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

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($registers as $register)
                                            @php
                                                $contact = $register->contact;
                                                $pContactComplianceVerification = $contact
                                                    ->pContactComplianceVerificationFor($compliance->id)
                                                    ->first();
                                            @endphp

                                            <tr>
                                                <td>{{ $contact->nit }}</td>
                                                <td>{{ $contact->name }}</td>
                                                <td>{{ $contact->email }}</td>
                                                <td>{{ $contact->phone }}</td>
                                                <td>
                                                    <a href="https://wa.me/+57{{ $contact->phone }}" target="_blank">
                                                        {{ $contact->whatsapp }}
                                                    </a>
                                                </td>
                                                <td>{{ $contact->contact_person_name }}</td>

                                                <td class="horizontal-layout">
                                                    @if ($pContactComplianceVerification)
                                                        <button class="btn btn-primary sm-b" data-toggle="modal"
                                                            data-target="#info-modal"
                                                            wire:click='preview({{ $contact->id }})'>
                                                            <i class="fa fa-list"></i>
                                                        </button>
                                                        <button class="btn btn-danger sm-b" data-toggle="modal"
                                                            data-target="#delete-modal"
                                                            wire:click="delete({{ $contact->id }})">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    @else
                                                        <p><strong>Aún no ha diligenciado el formulario</strong></p>
                                                        <a href="https://wa.me/+57{{ $contact->whatsapp }}"
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
