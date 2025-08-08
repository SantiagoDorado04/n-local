<div>
    @include('livewire.admin.l-m-s.topics.modals.show')
    @include('livewire.admin.l-m-s.topics.modals.create')
    @include('livewire.admin.l-m-s.topics.modals.edit')
    @include('livewire.admin.l-m-s.topics.modals.delete')

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
                Tematicas
            </li>
        </ol>
    @endsection

    @section('page_title', 'Tematicas | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-list-alt"></i>&nbsp;Tematicas
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
                                <li><strong>Proceso:</strong> {{ $course->step->stage->process->name }}</li>
                                <li><strong>Etapa:</strong> {{ $course->step->stage->name }}</li>
                                <li><strong>Paso:</strong> {{ $course->name }}</li>
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
                                <label><strong>Buscar tematica:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Tematica">
                                <hr>
                            </div>
                            <div class="col-lg-12">
                                <div class="row no-margin-bottom">
                                    @foreach ($topics as $topic)
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="panel panel-primary">
                                                <div class="panel-heading panel-heading-custom">
                                                    <h5 class="panel-title-custom">
                                                        {{ Str::limit($topic->name, 26) }}
                                                        <div
                                                            class="btn-group pull-right navbar-right panel-navbar-custom">
                                                            <button class="btn btn-link dropdown-toggle"
                                                                style="color:#fff" data-toggle="dropdown"><i
                                                                    class="fa fa-ellipsis-v"></i></button>
                                                            <ul class="dropdown-menu">
                                                                <li><a data-toggle="modal" data-target="#edit-modal"
                                                                        wire:click="edit({{ $topic->id }})"><i
                                                                            class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a>
                                                                </li>
                                                                <li><a data-toggle="modal" data-target="#delete-modal"
                                                                        wire:click="delete({{ $topic->id }})"><i
                                                                            class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </h5>
                                                </div>
                                                <button
                                                    style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                                    data-toggle="modal" data-target="#show-modal"
                                                    wire:click="show({{ $topic->id }})">
                                                    <div class="panel-body" style="height:120px">
                                                        <p style="  text-align: justify; text-justify: inter-word;">
                                                            <strong>Descripcion:
                                                            </strong>{{ Str::limit($topic->description, 150) }}
                                                        </p>
                                                    </div>
                                                </button>
                                                <div class="panel-footer">
                                                    <div class="pull-right">
                                                        <a class="btn btn-success sm-b"
                                                            href="{{ route('lessons', ['id' => $topic->id]) }}"><i
                                                                class="fa fa-file-video-o"></i> Lecciones</a>
                                                    </div>
                                                    <div class="clearfix">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-lg-6" style="padding-top:22px">
                                <span>{!! $paginationText !!}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


