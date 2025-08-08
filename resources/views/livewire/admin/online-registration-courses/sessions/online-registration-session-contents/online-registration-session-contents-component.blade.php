<div>
    @include('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.modals-contents.show')
    @include('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.modals-contents.delete')

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
                <a
                    href="{{ route('online-registration-categories', ['id' => $onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->id]) }}">Categorias</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-courses', ['id' => $onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->id]) }}">Cursos</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-courses-sessions', ['id' => $onlineRegistrationCourseSession->onlineRegistrationCourse->id]) }}">Sesiones</a>
            </li>
            <li>
                <a>Contenidos</a>
            </li>
        </ol>
    @endsection

    @section('page_title', 'Contenidos del curso | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid ">
            <div class="d-flex align-items-center justify-content-between">
                <h1 class="page-title mb-0">
                    <i class="fa fa-book"></i>&nbsp; Contenidos del curso
                </h1>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="dropdown">
                    <button class="btn btn-success btn-add-new dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="fa fa-plus-square"></i> Crear <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a title="Lesson"
                                href="{{ route('online-registration-lesson-content-create', ['id' => $session_id]) }}">

                                <span style="cursor: pointer;">
                                    <i class="voyager-book"></i> Lección
                                </span>
                            </a>
                        </li>
                        <li>
                            <a title="Slide"
                                href="{{ route('online-registration-slide-content-create', ['id' => $session_id]) }}">
                                <span style="cursor: pointer;">
                                    <i class="voyager-browser"></i> Slide
                                </span>
                            </a>
                        </li>
                        <li>

                            <a title="Video"
                                href="{{ route('online-registration-video-content-create', ['id' => $session_id]) }}">
                                <span style="cursor: pointer;">
                                    <i class="voyager-video"></i> Video
                                </span>
                            </a>
                        </li>
                        <li>
                            <a title="Test"
                                href="{{ route('online-registration-test-content-create', ['id' => $session_id]) }}">
                                <span style="cursor: pointer;">
                                    <i class=" voyager-documentation"></i> Test
                                </span>
                            </a>
                        </li>
                    </ul>
                    <a href="{{ route('online-registration-sessionContent-preview', ['id' => $session_id]) }}"
                        class="btn btn-warning"> <i class="fa fa-eye"></i>
                        Preview
                    </a>
                </div>
            </div>
        </div>

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
                                <label><strong>Buscar contenidos:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Nombre del contenido">
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            <div id="sortable-list" class="d-flex flex-nowrap overflow-auto">
                                @foreach ($contents as $content)
                                    <div class="col-lg-4 col-md-6 col-sm-12" data-id="{{ $content->id }}">
                                        <div class="panel panel-primary" style="height: 300px;">
                                            <div class="panel-heading panel-heading-custom">
                                                <h5 class="panel-title-custom">
                                                    {{ Str::limit($content->step) }} .
                                                    {{ Str::limit($content->title, 26) }}
                                                    <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                        <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                            data-toggle="dropdown" title="Acciones"><i
                                                                class="fa fa-ellipsis-v"></i></button>
                                                        <ul class="dropdown-menu">
                                                            @php
                                                                $editRoute = null;

                                                                if ($content->type === 'S') {
                                                                    $editRoute = route(
                                                                        'online-registration-slide-content-edit',
                                                                        ['id' => $content->id],
                                                                    );
                                                                } elseif ($content->type === 'V') {
                                                                    $editRoute = route(
                                                                        'online-registration-video-content-edit',
                                                                        ['id' => $content->id],
                                                                    );
                                                                } elseif ($content->type === 'L') {
                                                                    $editRoute = route(
                                                                        'online-registration-lesson-content-edit',
                                                                        ['id' => $content->id],
                                                                    );
                                                                } elseif ($content->type === 'T') {
                                                                    $editRoute = route(
                                                                        'online-registration-test-content-edit',
                                                                        ['id' => $content->id],
                                                                    );
                                                                }
                                                            @endphp
                                                            <li>
                                                                <a href="{{ $editRoute }}"
                                                                    title="Clic para editar contenido">
                                                                    <i class="fa fa-pencil"></i>&nbsp;&nbsp;Editar
                                                                </a>
                                                            </li>
                                                            <li><a data-toggle="modal" data-target="#delete-modal"
                                                                    title="Clic para eliminar contenido"
                                                                    wire:click="delete({{ $content->id }})"><i
                                                                        class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </h5>
                                            </div>
                                            <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                                data-toggle="modal" data-target="#show-modal"
                                                title="Clic para ver mas detalles..."
                                                wire:click="show({{ $content->id }})">
                                                <div class="panel-body" style="height:140px">
                                                    <p style="  text-align: justify; text-justify: inter-word;">
                                                        <strong>Descripcion:
                                                        </strong>{{ Str::limit($content->description, 100) }}
                                                        <br>
                                                        <br>
                                                        @if ($content->type == 'L')
                                                            <strong>Tipo:
                                                            </strong>Leccion
                                                        @elseif ($content->type == 'S')
                                                            <strong>Tipo:
                                                            </strong>Slide
                                                        @elseif ($content->type == 'V')
                                                            <strong>Tipo:
                                                            </strong>Video
                                                        @elseif ($content->type == 'T')
                                                            <strong>Tipo:
                                                            </strong>Test
                                                        @endif
                                                        <br>
                                                    </p>
                                                </div>
                                            </button>

                                            <div class="panel-footer ">
                                                <div class="pull-left">
                                                    @if ($content->type == 'L')
                                                        <div class="d-flex justify-content-between  mt-3">

                                                            <a href="{{ route('online-registration-lesson-content-preview', ['id' => $content->id]) }}"
                                                                class="btn btn-warning sm-b"
                                                                title="Clic para previsualizar contenido"> <i
                                                                    class="fa fa-eye"></i>
                                                                Previsualizar
                                                            </a>

                                                            <a href="{{ route('online-registration-lesson-content-detail', ['id' => $content->id]) }}"
                                                                class="btn btn-success sm-b"
                                                                title="Clic para ir a los detalles de las lecciones"> <i
                                                                    class="fa fa-list"></i>
                                                                Ir a detalles
                                                            </a>
                                                        </div>
                                                    @elseif ($content->type == 'S')
                                                        <a href="{{ route('online-registration-slide-content-preview', ['id' => $content->id]) }}"
                                                            class="btn btn-warning sm-b"
                                                            title="Clic para previsualizar contenido"> <i
                                                                class="fa fa-eye"></i>
                                                            Previsualizar
                                                        </a>
                                                        <a href="{{ route('online-registration-slide-content-edit', ['id' => $content->id]) }}"
                                                            class="btn btn-primary sm-b"
                                                            title="Clic para editar contenido"> <i
                                                                class="fa fa-pencil"></i>
                                                            Ir a slide
                                                        </a>
                                                    @elseif ($content->type == 'V')
                                                        <a href="{{ route('online-registration-video-content-preview', ['id' => $content->id]) }}"
                                                            class="btn btn-warning sm-b"
                                                            title="Clic para previsualizar contenido"> <i
                                                                class="fa fa-eye"></i>
                                                            Previsualizar
                                                        </a>
                                                        <a href="{{ route('online-registration-video-content-edit', ['id' => $content->id]) }}"
                                                            class="btn btn-success sm-b"
                                                            title="Clic para editar contenido"> <i
                                                                class="fa fa-pencil"></i>
                                                            Ir a video
                                                        </a>
                                                    @elseif ($content->type == 'T')
                                                        <a href="{{ route('online-registration-test-content-preview', ['id' => $content->test->id]) }}"
                                                            class="btn btn-warning sm-b"
                                                            title="Clic para previsualizar contenido"><i
                                                                class="fa fa-eye"></i>
                                                            Previsualizar
                                                        </a>

                                                        <a href="{{ route('online-registration-test-content-result', ['id' => $content->test->id]) }}"
                                                            class="btn btn-success sm-b"
                                                            title="Clic para ver resultados">
                                                            <i class=" fa fa-check"></i>
                                                            Resultados
                                                        </a>
                                                        <a href="{{ route('online-registration-test-items', ['id' => $content->test->id]) }}"
                                                            class="btn btn-danger sm-b"
                                                            title="Clic para ir a las preguntas y respuestas del contenido">
                                                            <i class=" fa fa-list"></i>
                                                            Ir a items
                                                        </a>
                                                        <a href="{{ route('online-registration-test-content-edit', ['id' => $content->id]) }}"
                                                            class="btn btn-primary sm-b"
                                                            title="Clic para editar contenido">
                                                            <i class=" fa fa-pencil"></i>
                                                            Editar test
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="clearfix">
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                        <div class="row no-margin-bottom">
                            <div class="col-lg-6" style="padding-top:22px">
                                <span>{!! $paginationText !!}</span>
                            </div>
                            <div class="col-lg-6 text-right">
                                {{ $contents->links() }}
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
                console.log(order);
                @this.call('updateOrder', order);
            }
        });
    });
</script>
