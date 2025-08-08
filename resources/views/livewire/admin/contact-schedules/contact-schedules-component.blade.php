<div>
    @php
        $dias = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado'];
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    @endphp

    @include('livewire.admin.contact-schedules.modals.edit')
    @include('livewire.admin.contact-schedules.modals.info')
    @include('livewire.admin.contact-schedules.modals.show')


    <style>
        .panel-heading-nav {
            border-bottom: 0;
            padding: 10px 0 0;
        }

        .panel-heading-nav .nav {
            padding-left: 10px;
            padding-right: 10px;
        }
    </style>
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>Planificación Contacto</li>
        </ol>
    @endsection

    @section('page_title', 'Planificación Contacto | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-calendar"></i> Planificación Contacto
            </h1>
        </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin: 0px">
                    <div class="panel-body" style="margin: 0px">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading panel-heading-nav" wire:ignore>
                                        <ul class="nav nav-tabs">
                                            <li role="presentation" class="active">
                                                <a href="#one" aria-controls="one" role="tab"
                                                    data-toggle="tab"><i class="voyager-list"></i>&nbsp;Contactos pendientes</a>
                                            </li>
                                            <li role="presentation">
                                                <a href="#two" aria-controls="two" role="tab"
                                                    data-toggle="tab"><i class="voyager-check"></i>&nbsp;Contactos completados</a>
                                            </li>
                                            <li role="presentation">
                                                <a href="{{ route('contacts-schedules.calendar') }}" target="_blank"><i class="voyager-calendar"></i>&nbsp;Calendario</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="panel-body">
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="one">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th><small>NIT</small></th>
                                                            <th><small>Nombre</small></th>
                                                            <th><small>Correo electrónico</small></th>
                                                            <th><small>Teléfono</small></th>
                                                            <th><small>Prioridad</small></th>
                                                            <th><small>Fecha a contactar</small></th>
                                                            <th><small>Hora a contactar</small></th>
                                                            <th><small>Asignado por</small></th>
                                                            <th><small>Accciones</small></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($pendingTasks as $item)
                                                            <tr
                                                                @if ($item->priority == '1') style="background-color:#FFEEEE" @endif>
                                                                <td>{{ $item->contact_nit }}</td>
                                                                <td>{{ $item->contact_name }}</td>
                                                                <td>{{ $item->contact_email }}</td>
                                                                <td>{{ $item->contact_phone }}</td>
                                                                <td>{{ $item->priority == '1' ? 'Prioritario' : 'No prioritario' }}
                                                                </td>
                                                                <td>
                                                                    @if ($item->time_to_contact != '')
                                                                        @php
                                                                            echo $dias[date('w', strtotime($item->date_to_contact))] . ', ' . date('d', strtotime($item->date_to_contact)) . ' ' . $meses[date('n', strtotime($item->date_to_contact)) - 1] . ' ' . date('Y', strtotime($item->date_to_contact));
                                                                        @endphp
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($item->time_to_contact != '')
                                                                        {{ date('h:i A', strtotime($item->time_to_contact)) }}
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td>{{ \App\Models\User::find($item->assigned_by)->name }}
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-primary" data-toggle="modal"
                                                                        data-target="#info-modal"
                                                                        wire:click="getContact({{ $item->contact_id }})"><i
                                                                            class="fa fa-address-card-o"></i></button>
                                                                    <button class="btn btn-success" data-toggle="modal"
                                                                        data-target="#edit-modal"
                                                                        wire:click="edit({{ $item->schedule_id }})"><i
                                                                            class="fa fa-refresh"></i></button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div role="tabpanel" class="tab-pane fade" id="two">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th><small>NIT</small></th>
                                                            <th><small>Nombre</small></th>
                                                            <th><small>Correo electrónico</small></th>
                                                            <th><small>Teléfono</small></th>
                                                            <th><small>Prioridad</small></th>
                                                            <th><small>Fecha a contactar</small></th>
                                                            <th><small>Hora a contactar</small></th>
                                                            <th><small>Asignado por</small></th>
                                                            <th><small>Fecha cuando se contacto</small></th>
                                                            <th><small>Hora cuando se contacto</small></th>
                                                            <th><small>Accciones</small></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($completedTasks as $item)
                                                            <tr>
                                                                <td>{{ $item->contact_nit }}</td>
                                                                <td>{{ $item->contact_name }}</td>
                                                                <td>{{ $item->contact_email }}</td>
                                                                <td>{{ $item->contact_phone }}</td>
                                                                <td>{{ $item->priority == '1' ? 'Prioritario' : 'No prioritario' }}
                                                                </td>
                                                                <td>
                                                                    @if ($item->time_to_contact != '')
                                                                        @php
                                                                            echo $dias[date('w', strtotime($item->date_to_contact))] . ', ' . date('d', strtotime($item->date_to_contact)) . ' ' . $meses[date('n', strtotime($item->date_to_contact)) - 1] . ' ' . date('Y', strtotime($item->date_to_contact));
                                                                        @endphp
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($item->time_to_contact != '')
                                                                        {{ date('h:i A', strtotime($item->time_to_contact)) }}
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td>{{ \App\Models\User::find($item->assigned_by)->name }}
                                                                </td>
                                                                <td>
                                                                    @if ($item->time_to_contact != '')
                                                                        @php
                                                                            echo $dias[date('w', strtotime($item->date_contact))] . ', ' . date('d', strtotime($item->date_contact)) . ' ' . $meses[date('n', strtotime($item->date_contact)) - 1] . ' ' . date('Y', strtotime($item->date_contact));
                                                                        @endphp
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($item->time_to_contact != '')
                                                                        {{ date('h:i A', strtotime($item->time_contact)) }}
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-primary" data-toggle="modal"
                                                                        data-target="#info-modal"
                                                                        wire:click="getContact({{ $item->contact_id }})"><i
                                                                            class="fa fa-address-card-o"></i></button>
                                                                    <button class="btn btn-primary" data-toggle="modal"
                                                                        data-target="#show-modal"
                                                                        wire:click="getSchedule({{ $item->contact_id }})"><i
                                                                            class="fa fa-phone"></i></button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </dv>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
