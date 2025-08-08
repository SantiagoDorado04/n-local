<div>
    @include('livewire.admin.information-forms.modals-options.show')
    @include('livewire.admin.information-forms.modals-options.create')
    @include('livewire.admin.information-forms.modals-options.edit')
    @include('livewire.admin.information-forms.modals-options.delete')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            @if ($question->informationForm->stage_id !='')
            <li class="active">
                <a href="{{ route('voyager.dashboard')}}"><i class="voyager-boat"></i> {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('processes')}}">Procesos</a>
            </li>
            <li>
                <a href="{{ route('stages',['id'=>$question->informationForm->stage->process->id])}}">Etapas</a>
            </li>
            <li>
                <a href="{{ route('information-forms-questions',['id'=>$question->informationForm->id])}}">Preguntas</a>
            </li>
            <li>
                Opciones
            </li>
            @else
            <li class="active">
                <a href="{{ route('voyager.dashboard')}}"><i class="voyager-boat"></i> {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('processes')}}">Procesos</a>
            </li>
            <li>
                <a href="{{ route('stages',['id'=>$question->informationForm->step->stage->process->id])}}">Etapas</a>
            </li>
            <li>
                <a href="{{ route('steps',['id'=>$question->informationForm->step->stage_id])}}">Pasos</a>
            </li>
            <li>
                <a href="{{ route('information-forms',['id'=>$question->informationForm->step_id])}}">Formularios</a>
            </li>
            <li>
                <a href="{{ route('information-forms-questions',['id'=>$question->informationForm->id])}}">Preguntas</a>
            </li>
            <li>
                Opciones
            </li>
            @endif
        </ol>
    @endsection

    @section('page_title', 'Opciones | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-list-ul" aria-hidden="true"></i>Opciones de respuesta
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
                            <small>
                            @if ($question->informationForm->stage_id !='')
                                <li><strong>Proceso:</strong> {{ $question->informationForm->stage->process->name }}</li>
                                <li><strong>Etapa:</strong> {{ $question->informationForm->stage->name }}</li>
                                <li><strong>Formulario:</strong> {{ $question->informationForm->name }}</li>
                                <li><strong>Pregunta: </strong> {{ $question->text }}<br></li>
                            @else
                                <li><strong>Proceso:</strong> {{ $question->informationForm->step->stage->process->name }}</li>
                                <li><strong>Etapa:</strong> {{ $question->informationForm->step->stage->name }}</li>
                                <li><strong>Paso:</strong> {{ $question->informationForm->step->name }}</li>
                                <li><strong>Formulario:</strong> {{ $question->informationForm->name }}</li>
                                <li><strong>Pregunta: </strong> {{ $question->text }}<br></li>
                            @endif
                            </small>
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
                                <label><strong>Buscar opciones:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Opciones">
                            </div> 
                        </div>
                        <div class="row no-margin-bottom" id="sortable-list">
                            @foreach ($options as $option)
                            <div class="col-lg-12 col-md-12 col-sm-12" data-id="{{ $option->id }}">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ $loop->iteration .'. '.Str::limit($option->text, 26) }}
                                                <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                    <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                        data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-toggle="modal" data-target="#edit-modal"
                                                                wire:click="edit({{ $option->id }})"><i
                                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                        <li><a data-toggle="modal" data-target="#delete-modal"
                                                                wire:click="delete({{ $option->id }})"><i
                                                                    class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </h5>
                                        </div>
                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                            data-toggle="modal" data-target="#show-modal"
                                            wire:click="show({{ $option->id }})">
                                            <div class="panel-body" style="height:120px">
                                                <p
                                                    style="  text-align: justify;
                                        text-justify: inter-word;">
                                                    <strong>Valor: </strong>{{ $option->value }}
                                                </p>
                                                <p
                                                    style="  text-align: justify;
                                        text-justify: inter-word;">
                                                    <strong>Posicion: </strong>{{ $option->position }}
                                                </p>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-lg-6" style="padding-top:22px">
                                <span>{!! $paginationText !!}</span>
                            </div>
                            <div class="col-lg-6 text-right">
                                {{ $options->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    document.addEventListener('livewire:load', function() {
        var el = document.getElementById('sortable-list');
        var sortable = Sortable.create(el, {
            onEnd: function(evt) {
                var orderedIds = Array.from(el.children).map(child => child.dataset.id);
                @this.call('updateOptionOrder', orderedIds);
            }
        });
    });
</script>
