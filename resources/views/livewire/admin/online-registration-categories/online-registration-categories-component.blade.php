<div>
    @include('livewire.admin.online-registration-categories.modals.show')
    @include('livewire.admin.online-registration-categories.modals.create')
    @include('livewire.admin.online-registration-categories.modals.edit')
    @include('livewire.admin.online-registration-categories.modals.delete')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('online-registrations') }}">Controles de registro</a>
            </li>
            <li>Categorías de cursos</li>
        </ol>
    @endsection

    @section('page_title', 'Categorías de cursos | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-folder"></i>&nbsp;Categorías de cursos
            </h1>
            <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal"
                title="Clic para crear una categoría">
                <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
            </button>
        </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom" style="margin-bottom:12px">
                            <div class="col-lg-12">
                                <label><strong>Buscar categoría:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Ingresa el nombre de la categoría">
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            @foreach ($categories as $category)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($category->name, 26) }}
                                                <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                    <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                        data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-toggle="modal" data-target="#edit-modal"
                                                                title="Clic para editar una categoría"
                                                                wire:click="edit({{ $category->id }})"><i
                                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                        <li><a data-toggle="modal" data-target="#delete-modal"
                                                                title="Clic para eliminar una categoría"
                                                                wire:click="delete({{ $category->id }})"><i
                                                                    class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </h5>
                                        </div>
                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                            data-toggle="modal" data-target="#show-modal"
                                            title="Clic para mirar los detalles de la categoría"
                                            wire:click="show({{ $category->id }})">
                                            <div class="panel-body" style="height:120px">
                                                <p
                                                    style="  text-align: justify;
                                        text-justify: inter-word;">
                                                    {{ Str::limit($category->description, 150) }}</p>
                                            </div>
                                        </button>
                                        <div class="panel-footer">
                                            <div class="pull-right">
                                                <a class="btn btn-success sm-b"
                                                    title="Clic para ir a los cursos de la categoría"
                                                    href="{{ route('online-registration-courses', ['id' => $category->id]) }}"><i
                                                        class="fa fa-grav"></i>&nbsp;Cursos</a>
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
                                {{ $categories->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
