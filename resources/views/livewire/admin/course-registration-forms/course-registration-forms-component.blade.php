<div>
    @include('livewire.admin.course-registration-forms.modals.show')
    @include('livewire.admin.course-registration-forms.modals.create')
    @include('livewire.admin.course-registration-forms.modals.edit')
    @include('livewire.admin.course-registration-forms.modals.info')
    @include('livewire.admin.course-registration-forms.modals.preview')

    @include('livewire.admin.course-registration-forms.modals.delete')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('online-registrations') }}">Controles de registros</a>
            </li>
            <li>
                Formularios de control de registros
            </li>
        </ol>
    @endsection

    @section('page_title', 'Formularios de control de registros | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-building-o"></i>&nbsp;Formularios de control de registros
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
                            <li><strong>Control de registro: </strong> {{ $onlineRegistration->name }}<br></li>
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
                        <div class="row no-margin-bottom" style="margin-bottom:12px">
                            <div class="col-lg-12">
                                <label><strong>Buscar Formularios:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Nombre del formulario">
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            @foreach ($coursesRegistrationForms as $coursesRegistrationForm)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($coursesRegistrationForm->name, 26) }}
                                                <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                    <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                        data-toggle="dropdown" title="Acciones"><i
                                                            class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-toggle="modal" data-target="#edit-modal"
                                                                wire:click="edit({{ $coursesRegistrationForm->id }})"><i
                                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                        <li><a data-toggle="modal" data-target="#delete-modal"
                                                                wire:click="delete({{ $coursesRegistrationForm->id }})"><i
                                                                    class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </h5>
                                        </div>
                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                            data-toggle="modal" data-target="#show-modal"
                                            title="Clic para ver mas detalles..."
                                            wire:click="show({{ $coursesRegistrationForm->id }})">
                                            <div class="panel-body" style="height:140px">
                                                <p style="  text-align: justify; text-justify: inter-word;">
                                                    {{ Str::limit($coursesRegistrationForm->description, 150) }}
                                                    <br>
                                                    <br>
                                                    <small><strong>Activo:
                                                        </strong>{{ $coursesRegistrationForm->active == 1 ? 'Si' : 'No' }}
                                                    </small>
                                                </p>

                                            </div>
                                        </button>
                                        <div class="panel-footer">
                                            <div class="pull-right">
                                                <a data-toggle="modal" data-target="#info-modal"
                                                    wire:click="preview({{ $coursesRegistrationForm->id }})"
                                                    class="btn btn-primary sm-b" title="Visualizar formulario">
                                                    <i class="fa fa-eye"></i>
                                                    &nbsp;Visualizar
                                                </a>
                                                <a title="Formulario de inscripción"class="btn btn-warning sm-b"
                                                    href="{{ route('information-forms-questions', ['id' => $coursesRegistrationForm->form->id]) }}"><i
                                                        class="fa fa-clipboard"></i>Preguntas</a>
                                                <button title="Enlace forulario de inscripción"
                                                    class="btn btn-primary sm-b" data-toggle="modal"
                                                    data-target="#info-modal-2"
                                                    wire:click='getToken({{ $coursesRegistrationForm->id }})'>
                                                    <i class="fa fa-link"></i>
                                                    &nbsp;Link
                                                </button>
                                                <a title="Listado de respuestas de registrados" class="btn btn-success sm-b"
                                                    href="{{ route('attendees.registrations', ['id' => $coursesRegistrationForm->id]) }}"><i
                                                        class="fa fa-user-plus"></i> Respuestas</a>
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
                                {{ $coursesRegistrationForms->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
