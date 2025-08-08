<div>
    @include('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.test-contents.online-registration-test-choices.modals-choices.create')
    @include('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.test-contents.online-registration-test-choices.modals-choices.show')
    @include('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.test-contents.online-registration-test-choices.modals-choices.edit')
    @include('livewire.admin.online-registration-courses.sessions.online-registration-session-contents.test-contents.online-registration-test-choices.modals-choices.delete')

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
                    href="{{ route('online-registration-categories', ['id' => $item->test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->id]) }}">Categorias</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-courses', ['id' => $item->test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->id]) }}">Cursos</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-courses-sessions', ['id' => $item->test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->id]) }}">Sesiones</a>
            </li>
            <li>
                <a
                    href="{{ route('online-registration-sessionContent', ['id' => $item->test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->id]) }}">Contenidos</a>
            </li>
            <li>
                <a href="{{ route('online-registration-test-items', ['id' => $item->test->id]) }}">Items</a>
            </li>
            <li>
                Elecciones
            </li>
        </ol>
    @endsection

    @section('page_title', 'Elecciones | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-list-ul" aria-hidden="true"></i>Elecciones del item
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
                                <li><strong>Control de registro:</strong>
                                    {{ $item->test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->name }}
                                </li>
                                <li><strong>Categoria:</strong>
                                    {{ $item->test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->onlineRegistrationCategory->name }}
                                </li>
                                <li><strong>Curso:</strong>
                                    {{ $item->test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->onlineRegistrationCourse->name }}
                                </li>
                                <li><strong>Sesion:</strong>
                                    {{ $item->test->onlineRegistrationSessionContent->onlineRegistrationCourseSession->name }}
                                </li>
                                <li><strong>Contenido/test:</strong>
                                    {{ $item->test->onlineRegistrationSessionContent->name }}
                                </li>
                                <li><strong>Item: </strong> {{ $item->text }}<br></li>
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
                                <h3>Item: <strong>{{ $item->text }}</strong></h3>
                                @if (!$existingCorrectChoice)
                                    <h5 class="text-danger">¡Cuidado! Aun no tienes una eleccion correcta para este
                                        item del test.</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom" style="margin-bottom:12px">
                            <div class="col-lg-12">
                                <label><strong>Buscar elecciones:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Eleccion">
                            </div>
                        </div>
                        <div class="row no-margin-bottom" id="sortable-list">
                            @foreach ($choices as $choice)
                                <div class="col-lg-12 col-md-12 col-sm-12" data-id="{{ $choice->id }}">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ $loop->iteration . '. ' . Str::limit($choice->text, 26) }}
                                                <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                    <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                        data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-toggle="modal" data-target="#edit-modal"
                                                                wire:click="edit({{ $choice->id }})"><i
                                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                        <li><a data-toggle="modal" data-target="#delete-modal"
                                                                wire:click="delete({{ $choice->id }})"><i
                                                                    class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </h5>
                                        </div>
                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                            data-toggle="modal" data-target="#show-modal"
                                            wire:click="show({{ $choice->id }})">
                                            <div class="panel-body" style="height:120px">
                                                <p
                                                    style="  text-align: justify;
                                        text-justify: inter-word;">
                                                    <strong>Valor: </strong>{{ $choice->value }}
                                                </p>
                                                <p
                                                    style="  text-align: justify;
                                        text-justify: inter-word;">
                                                    <strong>Posicion: </strong>{{ $choice->position }}
                                                </p>
                                                <p
                                                    style="  text-align: justify;
                                        text-justify: inter-word;">
                                                    <strong>Correcta:
                                                    </strong>{{ $choice->is_correct == 1 ? 'Si' : 'No' }}
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
                                {{ $choices->links() }}
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
                @this.call('updateChoiceOrder', orderedIds);
            }
        });
    });
</script>
