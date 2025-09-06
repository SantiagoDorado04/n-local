<div>
    @include('livewire.admin.l-m-s.courses.modals.show')
    @include('livewire.admin.l-m-s.courses.modals.create')
    @include('livewire.admin.l-m-s.courses.modals.edit')
    @include('livewire.admin.l-m-s.courses.modals.delete')

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
                <a href="{{ route('stages', ['id' => $step->stage->process_id]) }}">Etapas</a>
            </li>
            <li>
                <a href="{{ route('steps', ['id' => $step->stage_id]) }}">Pasos</a>
            </li>
            <li>
                Cursos
            </li>
        </ol>
    @endsection

    @section('page_title', 'Cursos | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-book"></i>&nbsp;Cursos
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
                        <ul>
                            <li><strong>Proceso:</strong> {{ $step->stage->process->name }}</li>
                            <li><strong>Etapa:</strong> {{ $step->stage->name }}</li>
                            <li><strong>Paso:</strong> {{ $step->name }}</li>
                        </ul>
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
                                <label><strong>Buscar cursos:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName" placeholder="Cursos">
                                <hr>
                            </div>
                            <div class="row no-margin-bottom">
                                @foreach ($courses as $course)
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading panel-heading-custom">
                                                <h5 class="panel-title-custom">
                                                    {{ Str::limit($course->name, 26) }}
                                                    <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                        <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                            data-toggle="dropdown"><i
                                                                class="fa fa-ellipsis-v"></i></button>
                                                        <ul class="dropdown-menu">
                                                            <li><a data-toggle="modal" data-target="#edit-modal"
                                                                    wire:click="edit({{ $course->id }})"><i
                                                                        class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a>
                                                            </li>
                                                            <li><a data-toggle="modal" data-target="#delete-modal"
                                                                    wire:click="delete({{ $course->id }})"><i
                                                                        class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </h5>
                                            </div>
                                            <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                                data-toggle="modal" data-target="#show-modal"
                                                wire:click="show({{ $course->id }})">
                                                <div class="panel-body" style="height:250px">
                                                    <p style="  text-align: justify; text-justify: inter-word;">
                                                        <strong>Descripcion:
                                                        </strong>{{ Str::limit($course->description, 150) }}
                                                    </p>
                                                    <p style="  text-align: justify; text-justify: inter-word;">
                                                        <strong>Curso anterior:
                                                        </strong>{{ $course->previousCourse ? $course->previousCourse->name : 'Ninguno' }}
                                                    </p>
                                                    <p style="  text-align: justify; text-justify: inter-word;">
                                                        <strong>Siguiente curso:
                                                        </strong>{{ $course->nextCourse ? $course->nextCourse->name : 'Ninguno' }}
                                                    </p>
                                                    <p style="  text-align: justify; text-justify: inter-word;">
                                                        <strong>Fecha de inicio: </strong>{{ $course->start_date }}
                                                    </p>
                                                    <p style="  text-align: justify; text-justify: inter-word;">
                                                        <strong>Fecha final: </strong>{{ $course->end_date }}
                                                    </p>
                                                </div>
                                            </button>
                                            <div class="panel-footer">
                                                <div class="pull-right">
                                                    <a class="btn btn-primary sm-b"
                                                        href="{{ route('courses.participants', ['id' => $course->id]) }}"><i
                                                            class="voyager-people"></i>&nbsp;Participantes</a>
                                                    <a class="btn btn-success sm-b"
                                                        href="{{ route('topics', ['id' => $course->id]) }}"><i
                                                            class="voyager-puzzle"></i> Tematicas</a>
                                                </div>
                                                <div class="clearfix">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row no-margin-bottom">
                                <div class="col-lg-6" style="padding-top:22px">
                                    <span>{!! $paginationText !!}</span>
                                </div>
                                <div class="col-lg-6 text-right">
                                    {{ $courses->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
