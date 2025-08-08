<div>

    {{--     @include('livewire.admin.l-m-s.lessons.modals.show') --}}
    @include('livewire.admin.l-m-s.lessons.modals.create')
    @include('livewire.admin.l-m-s.lessons.modals.edit')
    @include('livewire.admin.l-m-s.lessons.modals.delete')

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
                <a href="{{ route('stages', ['id' => $topic->course->step->stage->process_id]) }}">Etapas</a>
            </li>
            <li>
                <a href="{{ route('steps', ['id' => $topic->course->step->stage_id]) }}">Pasos</a>
            </li>
            <li>
                <a href="{{ route('courses', ['id' => $topic->course->step_id]) }}">Cursos</a>
            </li>
            <li>
                <a href="{{ route('topics', ['id' => $topic->course_id]) }}">Tematicas</a>
            </li>
            <li>
                Lecciones
            </li>
        </ol>
    @endsection

    @section('page_title', 'Lecciones | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-list-alt"></i>&nbsp;Lecciones
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
                        <small>
                            <ul>
                                <li><strong>Proceso:</strong> {{ $topic->course->step->stage->process->name }}</li>
                                <li><strong>Etapa:</strong> {{ $topic->course->step->stage->name }}</li>
                                <li><strong>Paso:</strong> {{ $topic->course->name }}</li>
                                <li><strong>Curso:</strong> {{ $topic->course->name }}</li>
                                <li><strong>Tematica:</strong> {{ $topic->name }}</li>
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
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><small>Título</small></th>
                                                <th><small>Descripción</small></th>
                                                <th><small>Video</small></th>
                                                <th><small>Archivo</small></th>
                                                <th><small>Contenido</small></th>
                                                <th><small>Tema</small></th>
                                                <th><small>Duración</small></th>
                                                <th><small>Orden</small></th>
                                                <th><small>Acciones</small></th>
                                            </tr>
                                        </thead>
                                        <tbody id="sortable-list">
                                            @foreach ($lessons as $lesson)
                                                <tr class="sortable-item" data-id="{{ $lesson->id }}">
                                                    <td>{{ $lesson->title }}</td>
                                                    <td>{{ $lesson->description }}</td>
                                                    <td>{{ $lesson->video }}</td>
                                                    <td>{{ $lesson->file }}</td>
                                                    <td>
                                                        @if ($lesson->content)
                                                            <a class="btn btn-info sm-b" style="text-decoration:none"
                                                                href="{{ route('lessons.content', ['id' => $lesson->id]) }}">Mostar
                                                                contenido</a>
                                                        @endif
                                                    </td>
                                                    <td>{{ $lesson->topic->name }}</td>
                                                    <td>{{ $lesson->duration }}</td>
                                                    <td>{{ $lesson->order }}</td>
                                                    <td>
                                                        <button class="btn btn-primary sm-b" data-toggle="modal"
                                                            data-target="#edit-modal"
                                                            wire:click="edit({{ $lesson->id }})">Editar</button>
                                                        <button class="btn btn-danger sm-b" data-toggle="modal"
                                                            data-target="#delete-modal"
                                                            wire:click="delete({{ $lesson->id }})">Eliminar</button>
                                                        <a class="btn btn-success sm-b" style="text-decoration:none"
                                                            href="{{ route('lessons.content', ['id' => $lesson->id]) }}">Crear
                                                            contenido</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
                @this.call('updateOrder', orderedIds);
            }
        });
    });
</script>
