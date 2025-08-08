<div>
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('interviews') }}">Entrevistas</a>
            </li>
            <li>
                Crear Entrevista
            </li>
        </ol>
    @endsection

    @section('page_title', 'Crear Entrevista | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-video" aria-hidden="true"></i> Crear Entrevista
            </h1>
        </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <form wire:submit.prevent="createInterview">
                            <div class="form-group">
                                <label for="topic"><strong>Tema de la Entrevista:</strong></label>
                                <input type="text" id="topic" class="form-control" wire:model.defer="topic" placeholder="Ingrese el tema de la entrevista">
                                @error('topic') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <label for="newQuestion"><strong>Agregar Pregunta:</strong></label>
                                <div class="row no-margin-bottom">
                                    <div class="col-lg-10">
                                        <input type="text" id="newQuestion" class="form-control" wire:model.defer="newQuestion" placeholder="Ingrese el texto de la pregunta">
                                        @error('newQuestion') <small class="text-danger">{{ $message }}</small> @enderror
                                        @error('questions') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-success btn-block" wire:click="addQuestion" style="margin-top: 0px;"><i class="voyager-plus"></i> &nbsp;Agregar</button>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="form-group">
                                <label><strong>Listado de preguntas: <small>(Arrastrar las preguntas para cambiar orden)</small></strong></label>
                                <ul id="questionsList" class="list-group">
                                    @foreach ($questions as $index => $question)
                                        <li class="list-group-item" data-id="{{ $index }}">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" value="{{ $question }}" wire:change="updateQuestion({{ $index }}, $event.target.value)">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger sm-b" wire:click="removeQuestion({{ $index }})">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="submit" class="btn btn-success">Crear Entrevista</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function () {
            var el = document.getElementById('questionsList');
            var sortable = Sortable.create(el, {
                animation: 150,
                onEnd: function (evt) {
                    let orderedIds = Array.from(el.children).map((child, index) => child.getAttribute('data-id'));
                    @this.call('updateQuestionsOrder', orderedIds);
                }
            });
        });
    </script>
</div>
