<div>
    @include('livewire.contacts.my-online-registration-courses.modals-courses.show')
    @include('livewire.contacts.my-online-registration-courses.modals-status.info')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                Mis registros en linea a cursos
            </li>
        </ol>
    @endsection

    @section('page_title', 'Cursos en linea | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-puzzle-piece"></i> Mis cursos
            </h1>
        </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom" style="margin-bottom:12px">
                            <div class="col-lg-12">
                                <label><strong>Buscar curso:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName" placeholder="curso">
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            @foreach ($registrations as $registration)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($registration->onlineRegistrationCourse->name, 26) }}
                                            </h5>
                                        </div>
                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                            data-toggle="modal" data-target="#show-modal"
                                            wire:click="show({{ $registration->onlineRegistrationCourse->id }})">
                                            <div class="panel-body" style="height:120px">
                                                <p
                                                    style="  text-align: justify;
                                        text-justify: inter-word;">
                                                    <strong>Proceso: </strong>
                                                </p>
                                                <p
                                                    style="  text-align: justify;
                                        text-justify: inter-word;">
                                                    {{ Str::limit($registration->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->name) }}
                                                </p>
                                                <p
                                                    style="  text-align: justify;
                                        text-justify: inter-word;">
                                                    <strong>Categoria: </strong>
                                                </p>
                                                <p
                                                    style="  text-align: justify;
                                        text-justify: inter-word;">
                                                    {{ Str::limit($registration->onlineRegistrationCourse->onlineRegistrationCategory->name) }}
                                                </p>
                                            </div>
                                        </button>
                                        <div class="panel-footer">
                                            <div class="pull-right">
                                                <button class="btn btn-primary sm-b" data-toggle="modal"
                                                    title="Clic para ver tu estado" data-target="#info-modal"
                                                    wire:click="status({{ $registration->onlineRegistrationCourse->id }})">
                                                    <i class="fa fa-list-alt"></i> Ver estado
                                                </button>
                                                <a class="btn btn-primary sm-b"
                                                    href="{{ route('my-course-sessions', ['id' => $registration->onlineRegistrationCourse->id]) }}"><i
                                                        class="fa fa-list-alt"></i>&nbsp;Ir al curso</a>
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
                                {{ $registrations->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
