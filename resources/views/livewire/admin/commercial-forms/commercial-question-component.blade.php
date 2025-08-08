<div>
    @include('livewire.admin.commercial-forms.modals-questions.create')
    @include('livewire.admin.commercial-forms.modals-questions.edit')
    @include('livewire.admin.commercial-forms.modals-questions.delete')

    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li>
            <a href="{{ route('commercial.forms') }}">Formularios</a>
        </li>
        <li>Preguntas</li>
    </ol>
    @endsection

    @section('page_title', 'Formularios Widgets | '.setting('admin.title'))

    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-question"></i> Preguntas Formulario Widget
        </h1>
        <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal">
            <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
        </button>
    </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered"  style="margin-bottom:0px">
                    <div class="panel-body" style="margin-bottom:0px">
                        <ul>
                            <li><strong>Formulario: </strong> {{ $form->name }}<br></li>
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
                            @foreach ($questions as $question)
                            <div class="col-md-12">
                                <div class="panel panel-info">
                                    <div class="panel-heading panel-heading-custom">
                                        <h5 class="panel-title-custom">
                                            Pregunta #{{ $loop->iteration }}
                                            <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                    data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                                <ul class="dropdown-menu">
                                                    <li><a data-toggle="modal" data-target="#edit-modal"
                                                            wire:click="edit({{ $question->id }})"><i
                                                                class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                    <li><a data-toggle="modal" data-target="#delete-modal"
                                                            wire:click="delete({{ $question->id }})"><i
                                                                class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </h5>
                                    </div>
                                    <div class="panel-body" style="margin-top:20px">
                                        {!! nl2br($question->question) !!}
                                    </div>
                                    <div class="panel-footer">
                                        <span><strong>Tipo:</strong>
                                            {{ $question->type == 'pa'
                                            ? 'Pregunta abierta'
                                            : 'Pregunta de opción
                                            simple' }}
                                        </span>
                                        <br>
                                        <span><strong>Visibilidad:</strong>
                                            {{ $question->visibility == '1' ? 'Visible' : 'Oculta' }}
                                        </span>
                                        <div class="pull-right">
                                            @if ($question->type == 'po')
                                            <a href="{{ route('commercial.options', ['question' => $question->id]) }}"
                                                class="btn btn-success sm-b"><i class="fa fa-list-ul"></i>&nbsp;Opciones</a>
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