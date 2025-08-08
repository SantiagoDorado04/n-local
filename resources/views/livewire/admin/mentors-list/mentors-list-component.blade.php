<div>
    @include('livewire.admin.mentors-list.modals.create')
    @include('livewire.admin.mentors-list.modals.edit')
    @include('livewire.admin.mentors-list.modals.delete')
    @include('livewire.admin.mentors-list.modals.show')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}">
                    <i class="voyager-boat"></i> {{ __('voyager::generic.dashboard') }}
                </a>
            </li>
            {{-- <li><a href="{{ route('processes') }}">Procesos</a></li>
                <li><a href="{{ route('stages', ['id' => $form->step->stage->process_id]) }}">Etapas</a></li>
                <li><a href="{{ route('steps', ['id' => $form->step->stage->id]) }}">Pasos</a></li>
                <li><a href="{{ route('information-forms', ['id' => $form->step_id]) }}">Formularios</a></li>
                <li><a href="{{ route('processes') }}">Procesos</a></li>
                <li><a href="{{ route('stages', ['id' => $stage->process_id]) }}">Etapas</a></li> --}}
            <li>Mentores</li>
        </ol>
    @endsection

    @section('page_title', 'Mentores | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-rocket"></i>&nbsp;Mentores
            </h1>
            <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal">
                <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
            </button>
        </div>
    @stop

    {{-- <div class="page-content browse container-fluid">
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
    </div> --}}

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <label><strong>Buscar mentor:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Nombre del mentor">
                                <hr>
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><small>Acciones</small></th>
                                                <th><small>Identificación</small></th>
                                                <th><small>Nombre</small></th>
                                                <th><small>Email</small></th>
                                                <th><small>Teléfono</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mentors as $mentor)
                                                <tr>
                                                    <td class="horizontal-layout">
                                                        <button class="btn btn-primary sm-b" data-toggle="modal"
                                                            data-target="#edit-modal"
                                                            wire:click="edit({{ $mentor->id }})">
                                                            <i class="fa fa-pencil"></i>
                                                        </button>
                                                        <button class="btn btn-danger sm-b" data-toggle="modal"
                                                            data-target="#delete-modal"
                                                            wire:click="delete({{ $mentor->id }})">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                        <button class="btn btn-info sm-b" data-toggle="modal"
                                                            data-target="#show-modal"
                                                            wire:click="show({{ $mentor->id }})">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </td>
                                                    <td>{{ Str::limit($mentor->identification, 50) }}</td>
                                                    <td>{{ Str::limit($mentor->name, 50) }}</td>
                                                    <td>{{ Str::limit($mentor->email, 50) }}</td>
                                                    <td>{{ Str::limit($mentor->phone, 60) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $mentors->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
