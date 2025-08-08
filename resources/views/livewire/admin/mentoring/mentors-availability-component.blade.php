<div>

    @include('livewire.admin.mentoring.modals-availability.show')
    @include('livewire.admin.mentoring.modals-availability.create')
    @include('livewire.admin.mentoring.modals-availability.edit')
    @include('livewire.admin.mentoring.modals-availability.delete')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard')}}"><i class="voyager-boat"></i> {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('processes')}}">Procesos</a>
            </li>
            <li>
                <a href="{{ route('stages',['id'=>$mentor->step->stage->process_id])}}">Etapas</a>
            </li>
            <li>
                <a href="{{ route('steps',['id'=>$mentor->step->stage->id])}}">Pasos</a>
            </li>
            <li>
                <a href="{{ route('mentoring',['id'=>$mentor->step->id])}}">Mentores</a>
            </li>
            <li>
                Disponibilidades
            </li>
        </ol>
    @endsection

    @section('page_title', 'Disponibilidades | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-calendar"></i> Disponibilidades
            </h1>
            <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal">
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
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nombre del Mentor</th>
                                                <th>Fecha</th>
                                                <th>Hora de inicio</th>
                                                <th>Hora de fin</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mentorAvailabilities as $mentorAvailability)
                                                <tr>
                                                    <td>{{ $mentorAvailability->mentor->mentorList->name }}</td>
                                                    <td>{{ $mentorAvailability->date }}</td>
                                                    <td>{{ $mentorAvailability->start_time }}</td>
                                                    <td>{{ $mentorAvailability->end_time }}</td>
                                                    <td>
                                                        <button class="btn btn-primary sm-b" wire:click="edit({{ $mentorAvailability->id }})" data-toggle="modal" data-target="#edit-modal">Editar</button>
                                                        <button class="btn btn-danger sm-b" wire:click="delete({{ $mentorAvailability->id }})" data-toggle="modal" data-target="#delete-modal">Eliminar</button>
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

</div>
