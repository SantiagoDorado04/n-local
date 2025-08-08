<div>
    @include('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.lessons-contents.details-lessons.modals.delete')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li><a href="{{ route('online-registrations') }}">Controles de registro</a></li>
            <li><a
                    href="{{ route('online-registration-categories', ['id' => $session_id->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->id]) }}">Categorias</a>
            </li>
            <li><a
                    href="{{ route('online-registration-courses', ['id' => $session_id->onlineRegistrationCourse->onlineRegistrationCategory->id]) }}">Cursos</a>
            </li>
            <li><a
                    href="{{ route('online-registration-courses-sessions', ['id' => $session_id->onlineRegistrationCourse->id]) }}">Sesiones</a>
            </li>
            <li><a href="{{ route('online-registration-sessionContent', ['id' => $session_id->id]) }}">Contenidos</a>
            </li>
            <li><a>Lección</a></li>
        </ol>
    @endsection

    @section('page_title', 'Video | ' . setting('admin.title'))
    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-book"></i>&nbsp; Detalles De La Lección
            </h1>
            <a href="{{ route('online-registration-lesson-content-detail-create', ['id' => $lesson->id]) }}" title="Clic para adicionar un nuevo detalle de lección"
                class="btn btn-success "> <i class="fa fa-plus-square"></i>
                Crear
            </a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin-bottom:0px">
                    <div class="panel-body" style="margin-bottom:0px">
                        <ul>
                            <li><strong>Control de registro: </strong>
                                {{ $onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->name }}<br>
                            </li>
                            <li><strong>Categoria: </strong>
                                {{ $onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->name }}<br>
                            </li>
                            <li><strong>Curso: </strong>
                                {{ $onlineRegistrationCourseSession->onlineRegistrationCourse->name }}<br></li>
                            <li><strong>Sesión: </strong> {{ $onlineRegistrationCourseSession->name }}<br></li>
                            <li><strong>Contenido de cursos: </strong> {{ $lesson->title }}<br></li>

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
                                <label><strong>Buscar curso:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Nombre del curso">
                            </div>
                        </div> -
                        <div class="row no-margin-bottom">
                            <div id="sortable-list" class="d-flex flex-nowrap overflow-auto">
                                @foreach ($lessonForm as $lesson)
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading panel-heading-custom">
                                                <h5 class="panel-title-custom">{{ Str::limit($lesson->order, 100) }}.
                                                    {{ Str::limit($lesson->title, 100) }}
                                                    <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                        <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                            data-toggle="dropdown" title="Acciones"><i
                                                                class="fa fa-ellipsis-v"></i></button>
                                                        <ul class="dropdown-menu">
                                                            <li><a title="Clic para editar el detalle de la lección"
                                                                    href="{{ route('online-registration-lesson-content-detail-edit', ['id' => $lesson->id]) }}">
                                                                    <i class="fa fa-pencil"></i>
                                                                    Editar
                                                                </a></li>
                                                            <li><a data-toggle="modal" data-target="#delete-modal" title="Clic para eliminar el detalle de la lección"
                                                                    wire:click="delete({{ $lesson->id }})"><i
                                                                        class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </h5>

                                            </div>
                                            <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                                data-toggle="modal" data-target="#show-modal"
                                                title="Clic para ver mas detalles..." {{--   wire:click="show({{ $course->id }})" --}}>

                                            </button>
                                            <div class="panel-footer">
                                                <strong>Orden:</strong> {{ Str::limit($lesson->order, 100) }}
                                                <div class="text-right">
                                                    <a href="{{ route('online-registration-lesson-content-detail-edit', ['id' => $lesson->id]) }}" title="Clic para editar detalle de lección"
                                                        class="btn btn-success"> <i class="fa fa-pencil"> </i>
                                                         Ir a detalle
                                                    </a>
                                                    <div class="clearfix"></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-lg-6" style="padding-top:22px">
                                {{-- <span>{!! $paginationText !!}</span> --}}
                            </div>
                            <div class="col-lg-6 text-right">
                                {{--   {{ $onlineRegistrationCourses->links() }} --}}
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
            animation: 150,
            onEnd: function(evt) {
                var order = [];
                document.querySelectorAll('#sortable-list .col-lg-4').forEach((item) => {
                    order.push(item.getAttribute('data-id')); // Ahora envía los ID reales
                });
                @this.call('updateOrder', order);
            }
        });
    });
</script>
