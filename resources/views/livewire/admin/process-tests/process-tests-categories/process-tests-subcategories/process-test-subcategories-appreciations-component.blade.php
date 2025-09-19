<div>
    @include('livewire.admin.process-tests.process-tests-categories.process-tests-subcategories.modals-subcategory-appreciations.show')
    @include('livewire.admin.process-tests.process-tests-categories.process-tests-subcategories.modals-subcategory-appreciations.create')
    @include('livewire.admin.process-tests.process-tests-categories.process-tests-subcategories.modals-subcategory-appreciations.edit')
    @include('livewire.admin.process-tests.process-tests-categories.process-tests-subcategories.modals-subcategory-appreciations.delete')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li><a href="{{ route('processes') }}">Procesos</a></li>
            <li><a href="{{ route('stages', ['id' => $subcategory->category->process_test_id]) }}">Etapas</a></li>
            <li><a href="{{ route('steps', ['id' => $subcategory->category->ProcessTest->step->stage_id]) }}">Pasos</a></li>
            <li>Apreciaciones de la subcategoría: {{ $subcategory->name ?? '' }}</li>
        </ol>
    @endsection

    @section('page_title', 'Apreciaciones de subcategoría | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-clipboard"></i> Apreciaciones de la subcategoría: {{ $subcategory->name ?? '' }}
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
                                <li><strong>Proceso:</strong>
                                    {{ $subcategory->category->processTest->step->stage->process->name }}
                                </li>
                                <li><strong>Etapa:</strong> {{ $subcategory->category->processTest->step->stage->name }}
                                </li>
                                <li><strong>Paso:</strong> {{ $subcategory->category->processTest->step->name }}</li>
                                <li><strong>Test:</strong> {{ $subcategory->category->processTest->name }}</li>
                                <li><strong>Categoría:</strong> {{ $subcategory->category->name }}</li>
                                <li><strong>Subcategoria:</strong> {{ $subcategory->name }}</li>
                            </ul>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- LISTADO DE APRECIACIONES --}}
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom" style="margin-bottom:12px"></div>

                        <div class="row no-margin-bottom">
                            @foreach ($appreciations as $appreciation)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($appreciation->title, 26) }}
                                                <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                    <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                        data-toggle="dropdown" title="Opciones"><i
                                                            class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a data-toggle="modal" data-target="#edit-modal"
                                                                wire:click="edit({{ $appreciation->id }})"><i
                                                                    class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                        <li><a data-toggle="modal" data-target="#delete-modal"
                                                                wire:click="delete({{ $appreciation->id }})"><i
                                                                    class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </h5>
                                        </div>
                                        <button style="background-color:#fff; border:0" data-toggle="modal"
                                            data-target="#show-modal" wire:click="show({{ $appreciation->id }})">
                                            <div class="panel-body" style="height:140px">
                                                <p style="text-align: justify">
                                                    {{ Str::limit($appreciation->appreciation, 150) }}</p>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- PAGINACIÓN --}}
                        <div class="row no-margin-bottom">
                            <div class="col-lg-6" style="padding-top:22px">
                                <span>{!! $paginationText !!}</span>
                            </div>
                            <div class="col-lg-6 text-right">
                                {{ $appreciations->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
