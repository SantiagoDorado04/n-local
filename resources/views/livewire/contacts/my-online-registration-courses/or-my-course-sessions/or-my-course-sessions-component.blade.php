<div>
    @include('livewire.contacts.my-online-registration-courses.or-my-course-sessions.modals-sessions.show')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('my-registrations', ['id' => $courseId]) }}">Cursos</a>
            </li>
            <li>
                Sesiones
            </li>
        </ol>
    @endsection

    @section('page_title', 'Sesiones | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-puzzle-piece"></i> Sesiones
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
                                <li><strong>Curso:</strong> {{ $courseId->name }}</li>
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
                                <label><strong>Buscar sesion:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName" placeholder="sesion">
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            @foreach ($sessions as $session)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($session->name, 26) }}
                                            </h5>
                                        </div>
                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                            data-toggle="modal" data-target="#show-modal"
                                            wire:click="show({{ $session->id }})">
                                            <div class="panel-body" style="height:120px">
                                                <p
                                                    style="  text-align: justify;
                                        text-justify: inter-word;">
                                                    <strong>Curso: </strong>
                                                </p>
                                                <p
                                                    style="  text-align: justify;
                                        text-justify: inter-word;">
                                                    {{ Str::limit($session->onlineRegistrationCourse->name) }}
                                                </p>
                                                <p
                                                    style="  text-align: justify;
                                        text-justify: inter-word;">
                                                    <strong>Descripcion: </strong>
                                                </p>
                                                <p
                                                    style="  text-align: justify;
                                        text-justify: inter-word;">
                                                    {{ Str::limit($session->description) }}
                                                </p>
                                            </div>
                                        </button>
                                        <div class="panel-footer">
                                            <div class="pull-right">
                                                @if (\Carbon\Carbon::parse($session->start_date)->lessThan(\Carbon\Carbon::now()))
                                                    <a class="btn btn-primary sm-b"
                                                        href="{{ route('my-or-characterizations', ['id' => $session->id]) }}">
                                                        <i class="fa fa-user-circle"></i>&nbsp;Caracterizaciones
                                                    </a>
                                                    <a class="btn btn-success sm-b"
                                                        href="{{ route('my-or-session-contents', ['id' => $session->id]) }}">
                                                        <i class="fa fa-list"></i>&nbsp;Contenido
                                                    </a>
                                                @else
                                                    <a class="btn btn-light sm-b" disabled> <i
                                                            class="fa fa-warning"></i><strong><span> Disponible desde:
                                                                {{ \Carbon\Carbon::parse($session->start_date)->format('d/m/Y H:i') }}
                                                            </span></strong>
                                                    </a>
                                                @endif
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
                                {{ $sessions->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
