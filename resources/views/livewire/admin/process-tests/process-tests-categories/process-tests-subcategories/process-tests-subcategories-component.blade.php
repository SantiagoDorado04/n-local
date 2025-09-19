<div>
    @include('livewire.admin.process-tests.process-tests-categories.process-tests-subcategories.modals-subcategories.show')
    @include('livewire.admin.process-tests.process-tests-categories.process-tests-subcategories.modals-subcategories.create')
    @include('livewire.admin.process-tests.process-tests-categories.process-tests-subcategories.modals-subcategories.edit')
    @include('livewire.admin.process-tests.process-tests-categories.process-tests-subcategories.modals-subcategories.delete')

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
                <a href="{{ route('stages', ['id' => $category->processTest->step->stage->process_id]) }}">Etapas</a>
            </li>
            <li>
                <a href="{{ route('steps', ['id' => $category->processTest->step->stage->id]) }}">Pasos</a>
            </li>
            <li>
                <a href="{{ route('process-test-categories', ['id' => $category->processTest->step->id]) }}">Categorías</a>
            </li>
            <li>
                Subcategorías de la categoría: {{ $category->name ?? '' }}
            </li>
        </ol>
    @endsection

    @section('page_title', 'Subcategorías de evaluación | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-puzzle"></i> Subcategorías de la categoría: {{ $category->name ?? '' }}
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
                                <li><strong>Proceso:</strong> {{ $category->processTest->step->stage->process->name }}
                                </li>
                                <li><strong>Etapa:</strong> {{ $category->processTest->step->stage->name }}</li>
                                <li><strong>Paso:</strong> {{ $category->processTest->step->name }}</li>
                                <li><strong>Categoría:</strong> {{ $category->name }}</li>
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
                        <div class="row no-margin-bottom" style="margin-bottom:12px"></div>
                        <div class="row no-margin-bottom">
                            @foreach ($subcategories as $subcategory)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($subcategory->name, 26) }}
                                                <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                    <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                        data-toggle="dropdown" title="Opciones"><i
                                                            class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-toggle="modal" data-target="#edit-modal"
                                                                wire:click="edit({{ $subcategory->id }})"><i
                                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                        <li><a data-toggle="modal" data-target="#delete-modal"
                                                                wire:click="delete({{ $subcategory->id }})"><i
                                                                    class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </h5>
                                        </div>

                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                            data-toggle="modal" data-target="#show-modal"
                                            wire:click="show({{ $subcategory->id }})"
                                            title="Clic para más detalles...">
                                            <div class="panel-body" style="height:140px">
                                                <p style="text-align: justify; text-justify: inter-word;">
                                                    {{ Str::limit($subcategory->description, 150) }}
                                                </p>
                                            </div>
                                        </button>
                                        <div class="panel-footer">
                                            <div class="pull-right">
                                                <a class="btn btn-success sm-b"
                                                    href="{{ route('process-test-subcategories-appreciations', ['id' => $subcategory->id]) }}">
                                                    <i class="voyager-puzzle"></i>&nbsp;Apreciaciones
                                                </a>
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
                                {{ $subcategories->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
