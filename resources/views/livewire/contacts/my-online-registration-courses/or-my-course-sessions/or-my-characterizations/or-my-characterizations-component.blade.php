<div>
    @include('livewire.contacts.my-online-registration-courses.or-my-course-sessions.or-my-characterizations.modals-characterizations.show')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('my-registrations') }}">Cursos</a>
            </li>
            <li>
                <a href="{{ route('my-course-sessions', ['id' => $session->id]) }}">Sesiones</a>
            </li>
            <li>
                Caracterizaciones
            </li>
        </ol>
    @endsection

    @section('page_title', 'Caracterizaciones | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-puzzle-piece"></i> Caracterizaciones
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
                                <li><strong>Curso:</strong> {{ $session->onlineRegistrationCourse->name }}</li>
                                <li><strong>Sesion:</strong> {{ $session->name }}</li>
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
                                <label><strong>Buscar caracterizacion:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="caracterizacion">
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            @foreach ($assignments as $assignment)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($assignment->characterization->name, 50) }}
                                            </h5>
                                        </div>
                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                            data-toggle="modal" data-target="#show-modal"
                                            wire:click="show({{ $assignment->characterization->id }})">
                                            <div class="panel-body" style="height:120px">
                                                <p
                                                    style="  text-align: justify;
                                        text-justify: inter-word;">
                                                    <strong>Descripcion: </strong>
                                                </p>
                                                <p
                                                    style="  text-align: justify;
                                        text-justify: inter-word;">
                                                    {{ Str::limit($assignment->characterization->description) }}
                                                </p>
                                            </div>
                                        </button>
                                        <div class="panel-footer">
                                            <div class="pull-right">
                                                <a class="btn btn-success sm-b"
                                                    href="{{ route('my-or-characterization-diligence', ['id' => $assignment->characterization->id]) }}">
                                                    <i class="fa fa-list"></i>&nbsp;Diligenciar formulario
                                                </a>
                                            </div>
                                            <div class="clearfix"></div>
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
                                {{ $assignments->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
