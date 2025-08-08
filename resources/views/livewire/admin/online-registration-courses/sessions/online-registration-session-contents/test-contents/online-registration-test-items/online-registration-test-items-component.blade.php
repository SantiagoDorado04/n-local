<div>

    @include('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.test-contents.online-registration-test-items.modals-items.delete')
    @include('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.test-contents.online-registration-test-items.modals-items.edit')
    @include('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.test-contents.online-registration-test-items.modals-items.create')
    @include('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.test-contents.online-registration-test-items.modals-items.show')

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
                <a
                    href="{{ route('online-registration-categories', ['id' => $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->id]) }}">Categorias</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-courses', ['id' => $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->id]) }}">Cursos</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-courses-sessions', ['id' => $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->id]) }}">Sesiones</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-sessionContent', ['id' => $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->id]) }}">Contenidos</a>
            </li>
            <li>
                Items de leccion
            </li>
        </ol>
    @endsection

    @section('page_title', 'Items | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-question-circle"></i>&nbsp;Items
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
                                <li><strong>Control de registro:</strong>
                                    {{ $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->name }}
                                </li>
                                <li><strong>Categoria:</strong>
                                    {{ $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->name }}
                                </li>
                                <li><strong>Curso:</strong>
                                    {{ $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->name }}
                                </li>
                                <li><strong>Sesion:</strong>
                                    {{ $test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->name }}
                                </li>
                                <li><strong>Contenido/test:</strong>
                                    {{ $test->onlineRegistrationSessionContent->title }}</li>
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
                                <label><strong>Buscar item:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName" placeholder="item">
                            </div>
                        </div>
                        <div class="row no-margin-bottom" style="margin-bottom:12px">
                            <div class="col-lg-12">
                                <i><small>* Arrastra el item para cambiar su posición en el
                                        formulario.</small></i>
                            </div>
                        </div>
                        <div class="row no-margin-bottom" id="sortable-list">
                            @foreach ($items as $item)
                                <div class="col-lg-12 col-md-12 col-sm-12" data-id="{{ $item->id }}">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ $loop->iteration . '. ' . $item->text }}
                                                <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                    <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                        data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-toggle="modal" data-target="#edit-modal"
                                                                wire:click="edit({{ $item->id }})"><i
                                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a>
                                                        </li>
                                                        <li><a data-toggle="modal" data-target="#delete-modal"
                                                                wire:click="delete({{ $item->id }})"><i
                                                                    class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </h5>
                                        </div>
                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                            data-toggle="modal" data-target="#show-modal"
                                            wire:click="show({{ $item->id }})">
                                            <div class="panel-body" style="height:120px">
                                                <p style="text-align: justify; text-justify: inter-word;">
                                                    <strong>Item: </strong>{{ $item->text }}
                                                </p>
                                            </div>
                                        </button>
                                        <div class="panel-footer">
                                            <div class="pull-right">
                                                <a class="btn btn-success sm-b"
                                                    href="{{ route('online-registration-test-choices', ['id' => $item->id]) }}">
                                                    <i class="fa fa-check-square-o"></i>&nbsp;Elecciones del item
                                                </a>
                                            </div>
                                            <div class="clearfix"></div>
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
                                {{ $items->links() }}
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
                @this.call('updateItemOrder', orderedIds);
            }
        });
    });
</script>
