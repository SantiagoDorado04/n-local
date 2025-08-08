<div wire:poll>

    @include('livewire.contacts.presential-activities.modals.confirm')
    @include('livewire.contacts.presential-activities.modals.cancel')

    <style>
        .panel-info.custom-panel {
            margin-top: 20px;
            border-radius: 8px;
            border-color: #5bc0de;
        }

        .panel-heading-custom {
            background-color: #5bc0de;
            color: #fff;
            padding: 10px 15px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .panel-title-custom {
            margin: 0;
            font-size: 16px;
        }

        .panel-body {
            padding: 15px;
        }

        .list-unstyled {
            padding-left: 0;
            list-style: none;
        }

        .list-unstyled li {
            padding: 5px 0;
            border-bottom: 1px solid #ddd;
        }
    </style>
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('processes.contact') }}">Procesos</a>
            </li>
            <li>
                <a href="{{ route('steps.contact', ['id' => $step->stage_id]) }}">Pasos</a>
            </li>
            <li>
                Actividades presenciales
            </li>
        </ol>
    @endsection

    @section('page_title', 'Actividades Presenciales | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-handshake-o"></i>&nbsp;Actividades Presenciales
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
                                <li><strong>Proceso:</strong> {{ $step->stage->process->name }}</li>
                                <li><strong>Etapa:</strong> {{ $step->stage->name }}</li>
                                <li><strong>Paso:</strong> {{ $step->name }}</li>
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
                            @foreach ($activities as $activity)
                                @php
                                    $requiredPoints = $activity->required_points ?? 0;
                                    $userPoints = Auth::user()->contact ? Auth::user()->contact->points : 0;
                                    $content = false;
                                @endphp

                                @if ($requiredPoints == 0)
                                    @php
                                        $content = true;
                                    @endphp
                                @elseif($userPoints >= $requiredPoints)
                                    @php
                                        $content = true;
                                    @endphp
                                @endif
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="panel panel-info">
                                        <div class="panel-heading panel-heading-custom">
                                            <h6 class="panel-title-custom">
                                                {{ $activity->name }}
                                            </h6>
                                        </div>
                                        @if ($content == true)
                                            <div class="panel-body">
                                                <div class="row no-margin-bottom">
                                                    @foreach ($activity->groups as $group)
                                                        <div class="col-lg-4">
                                                            <div class="panel panel-info custom-panel">
                                                                <div class="panel-heading panel-heading-custom">
                                                                    <h6 class="panel-title-custom">
                                                                        <strong>{{ $group->name }}</strong>
                                                                    </h6>
                                                                </div>
                                                                <div class="panel-body">
                                                                    <div class="row no-margin-bottom">
                                                                        <div class="col-lg-12">
                                                                            <ul class="list-unstyled">
                                                                                <li><strong>Fecha:</strong>
                                                                                    {{ $group->date }}</li>
                                                                                <li><strong>Hora:</strong>
                                                                                    {{ $group->hour }}</li>
                                                                                <li><strong>Cupos Disponibles:</strong>
                                                                                    {{ $group->quota - $group->registeredAttendees()->count() }}
                                                                                    / {{ $group->quota }}</li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="col-lg-12 text-center">
                                                                            @if ($group->registeredAttendees()->where('contact_id', $contactId)->exists())
                                                                                @if (!$stageActive)
                                                                                    <p><strong>La etapa
                                                                                            en la que te
                                                                                            encuentras
                                                                                            ya
                                                                                            no
                                                                                            esta activa
                                                                                            o ha
                                                                                            finalizado.</strong>
                                                                                    </p>
                                                                                @else
                                                                                    <button
                                                                                        wire:click="cancelAttendance({{ $group->id }})"
                                                                                        data-toggle="modal"
                                                                                        data-target="#delete-modal-2"
                                                                                        class="btn btn-danger sm-b">
                                                                                        <i class="fa fa-times-circle"
                                                                                            aria-hidden="true"></i>
                                                                                        Cancelar
                                                                                    </button>
                                                                                @endif
                                                                            @else
                                                                                @if ($group->quota - $group->registeredAttendees()->count() > 0)
                                                                                    @if (!$stageActive)
                                                                                        <p><strong>La etapa
                                                                                                en la que te
                                                                                                encuentras
                                                                                                ya
                                                                                                no
                                                                                                esta activa
                                                                                                o ha
                                                                                                finalizado.</strong>
                                                                                        </p>
                                                                                    @else
                                                                                        <button
                                                                                            wire:click="selectAttend('{{ $group->id }}')"
                                                                                            data-toggle="modal"
                                                                                            data-target="#delete-modal"
                                                                                            class="btn btn-success sm-b">
                                                                                            <i class="fa fa-calendar-check-o"
                                                                                                aria-hidden="true"></i>
                                                                                            Asistir
                                                                                        </button>
                                                                                    @endif
                                                                                @else
                                                                                    @if (!$stageActive)
                                                                                        <p><strong>La etapa
                                                                                                en la que te
                                                                                                encuentras
                                                                                                ya
                                                                                                no
                                                                                                esta activa
                                                                                                o ha
                                                                                                finalizado.</strong>
                                                                                        </p>
                                                                                    @else
                                                                                        <button
                                                                                            class="btn btn-disabled sm-b"
                                                                                            disabled>
                                                                                            <i class="fa fa-calendar-check-o"
                                                                                                aria-hidden="true"></i>
                                                                                            Cupo Lleno
                                                                                        </button>
                                                                                    @endif
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-12">
                                                <div class="panel panel-bordered">
                                                    <div class="panel-body">
                                                        <div class="row no-margin-bottom">
                                                            <p>No tienes suficientes puntos. Te faltan
                                                                {{ $requiredPoints - $userPoints }} puntos
                                                                para acceder a esta actividad presencial.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
