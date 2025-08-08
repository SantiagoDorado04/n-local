<div>
    @include('livewire.admin.commercial-forms.modals-options.create')
    @include('livewire.admin.commercial-forms.modals-options.edit')
    @include('livewire.admin.commercial-forms.modals-options.delete')

    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li>
            <a href="{{ route('commercial.forms') }}">Formularios</a>
        </li>
        <li>
            <a href="{{ route('commercial.questions', ['form' => $form->id]) }}">Preguntas</a>
        </li>
        <li>Opciones</li>
    </ol>
    @endsection

    @section('page_title', 'Opciones de respuesta | '.setting('admin.title'))

    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-list"></i> Opciones de respuesta
        </h1>
        <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal">
            <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
        </button>
    </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin: 0px">
                    <div class="panel-body" style="margin: 0px">
                        <ul>
                            <li><strong>Formulario: </strong> {{ $form->name }}<br></li>
                            <li><strong>Pregunta: </strong> {{ $question->question }}<br></li>
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
                            @foreach ($options as $option)
                            <div class="col-md-12">
                                <div class="panel panel-info">
                                    <div class="panel-heading panel-heading-custom">
                                        <h5 class="panel-title-custom">
                                            Opción #{{ $loop->iteration }}
                                            <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                    data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                                <ul class="dropdown-menu">
                                                    <li><a data-toggle="modal" data-target="#edit-modal"
                                                            wire:click="edit({{ $option->id }})"><i
                                                                class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                    <li><a data-toggle="modal" data-target="#delete-modal"
                                                            wire:click="delete({{ $option->id }})"><i
                                                                class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a></li>
                                                </ul>
                                            </div>
                                        </h5>
                                    </div>
                                    <div class="panel-body" style="margin-top:20px">
                                        {!! nl2br($option->option) !!}
                                    </div>
                                    <div class="panel-footer">
                                        <span><strong>Value:</strong>
                                            {{ $option->value }}
                                        </span>
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