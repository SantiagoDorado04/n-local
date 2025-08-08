<div>

    @include('livewire.contacts.l-m-s.modals-lms.show')

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
                Cursos
            </li>
        </ol>
    @endsection

    @section('page_title', 'Cursos | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-book"></i>&nbsp;Listado De Cursos
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
                            @foreach ($courses as $course)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($course->name, 26) }}
                                            </h5>
                                        </div>
                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                            data-toggle="modal" data-target="#show-modal"
                                            wire:click="show({{ $course->id }})">
                                            <div class="panel-body" style="height: 140px">
                                                <p style="  text-align: justify; text-justify: inter-word;">
                                                    <strong>Descripción:
                                                    </strong>{{ Str::limit($course->description, 145) }}
                                                </p>
                                            </div>
                                        </button>
                                        <div class="panel-footer">
                                            <div class="pull-right">
                                                @if (count($course->lessons) > 0)
                                                    <a class="btn btn-success sm-b"
                                                        href="{{ route('lms-content.contact', ['id' => $course->id]) }}">
                                                        <i class="fa fa-book"></i> Ver Contenido
                                                    </a>
                                                @else
                                                    <a class="btn btn-light sm-b"  disabled> <i class="fa fa-warning"></i><strong><span> Aún no hay
                                                            contenido</span></strong>
                                                    </a>
                                                @endif
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
            </div>
        </div>
    </div>
</div>
