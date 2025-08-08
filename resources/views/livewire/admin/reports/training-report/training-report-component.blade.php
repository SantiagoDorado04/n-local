<div>
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('online-registrations') }}">Controles de registro</a>
            </li>
            <li>
                Reporte capacitados
            </li>
        </ol>
    @endsection

    @section('page_title', 'reporte capacitados | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-building-o"></i>&nbsp;Reporte capacitados
            </h1>
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
                                <label><strong>Buscar capacitados:</strong></label>
                                <p>Aqui iran las fechas para el reporte</p>
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            @foreach ($capacitados as $capacitado)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($capacitado->name, 26) }}
                                                <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                    <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                        data-toggle="dropdown" title="Acciones"><i class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-toggle="modal" data-target="#edit-modal"
                                                                wire:click="edit({{ $stage->id }})"><i
                                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                        <li><a data-toggle="modal" data-target="#delete-modal"
                                                                wire:click="delete({{ $stage->id }})"><i
                                                                    class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </h5>
                                        </div>
                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                            data-toggle="modal" data-target="#show-modal" title="Clic para ver mas detalles..."
                                            wire:click="show({{ $stage->id }})">
                                            <div class="panel-body" style="height:140px">
                                                <p style="  text-align: justify; text-justify: inter-word;">
                                                    {{ Str::limit($stage->description, 150) }}
                                                    <br>
                                                    <br>
                                                    <small><strong>Formulario Inscripción: </strong>{{ $stage->embebed != '' ? 'Externo' : 'Interno' }} </small>
                                                    <br>
                                                    <small><strong>Activo: </strong>{{ $stage->active == 1 ? 'Si' : 'No' }} </small>
                                                </p>

                                            </div>
                                        </button>
                                        <div class="panel-footer">
                                            <div class="pull-right">
                                                <a data-toggle="modal" data-target="#info-modal"
                                                    wire:click="preview({{ $stage->id }})"
                                                    class="btn btn-primary sm-b" title="Visualizar formulario">
                                                    <i class="fa fa-eye"></i>
                                                    &nbsp;Visualizar
                                                </a>
                                                <a title="Formulario de inscripción"class="btn btn-warning sm-b"
                                                    href="{{ route('information-forms-questions', ['id' => $stage->form->id]) }}"><i
                                                        class="fa fa-clipboard"></i> F. Inscr</a>
                                                <button title="Enlace forulario de inscripción"
                                                    class="btn btn-primary sm-b" data-toggle="modal"
                                                    data-target="#info-modal-2"
                                                    wire:click='getToken({{ $stage->id }})'>
                                                    <i class="fa fa-link"></i>
                                                    &nbsp;Link
                                                </button>
                                                <a title="Listado de postulados" class="btn btn-success sm-b"
                                                    href="{{ route('stages.postulates', ['id' => $stage->id]) }}"><i
                                                        class="fa fa-user-plus"></i> Postulados</a>
                                                <a title="Listado de pasos"class="btn btn-primary sm-b"
                                                    href="{{ route('steps', ['id' => $stage->id]) }}"><i
                                                        class="fa fa-cogs"></i> Pasos</a>
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
