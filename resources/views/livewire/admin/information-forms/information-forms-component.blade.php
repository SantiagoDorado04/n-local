<div>
    @include('livewire.admin.information-forms.modals.show')
    @include('livewire.admin.information-forms.modals.create')
    @include('livewire.admin.information-forms.modals.edit')
    @include('livewire.admin.information-forms.modals.delete')
    @include('livewire.admin.information-forms.modals.preview')

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
                <a href="{{ route('steps', ['id' => $step->stage->id]) }}">Pasos</a>
            </li>
            <li>
                Formularios
            </li>
        </ol>
    @endsection

    @section('page_title', 'Formularios | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-clipboard"></i> Formulario Recoleccion de información
            </h1>
            @if (count($forms) == 0)
                <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal">
                    <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
                </button>
            @endif
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
                        <div class="row no-margin-bottom" style="margin-bottom:12px">
                            <div class="col-lg-12">
                                <label><strong>Buscar formulario:</strong></label>
                                <input type="text" class="form-control mb-2" wire:model="searchName"
                                    placeholder="Nombre del formulario">
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            @foreach ($forms as $form)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($form->name, 26) }}
                                                <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                    <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                        data-toggle="dropdown" title="Opciones"><i class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-toggle="modal" data-target="#edit-modal"
                                                                wire:click="edit({{ $form->id }})"><i
                                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                        <li><a data-toggle="modal" data-target="#delete-modal"
                                                                wire:click="delete({{ $form->id }})"><i
                                                                    class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </h5>
                                        </div>

                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                            data-toggle="modal" data-target="#show-modal"
                                            wire:click="show({{ $form->id }})" title="Clic para mas detalles...">
                                            <div class="panel-body" style="height:140px">
                                                <p style="text-align: justify; text-justify: inter-word;">
                                                    {{ Str::limit($form->description, 150) }}
                                                    <br>
                                                    <br>
                                                    <small><strong>Formulario:
                                                        </strong>{{ $form->embebed != '' ? 'Externo' : 'Interno' }}
                                                    </small>
                                                </p>
                                            </div>
                                        </button>
                                        <div class="panel-footer">
                                            <div class="pull-right">
                                                <a data-toggle="modal" data-target="#info-modal"
                                                    wire:click="preview({{ $form->id }})"
                                                    class="btn btn-primary sm-b" title="Visualizar formulario">
                                                    <i class="fa fa-eye"></i>
                                                    &nbsp;Visualizar
                                                </a>
                                                <a href="{{ route('information-forms.answers', ['id' => $form->id]) }}"
                                                    class="btn btn-warning sm-b" title="Respuestas formulario">
                                                    <i class="fa fa-check-square-o"></i>
                                                    &nbsp;Respuestas
                                                </a>
                                                <a href="{{ route('information-forms-questions', ['id' => $form->id]) }}"
                                                    class="btn btn-success sm-b" title="Preguntas formulario">
                                                    <i class="fa fa-question"></i>
                                                    &nbsp;Preguntas
                                                </a>
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
                                {{ $forms->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
