<div>
    @include('livewire.admin.online-registration-courses.online-registration-documents.modals.create')
    @include('livewire.admin.online-registration-courses.online-registration-documents.modals.edit')
    @include('livewire.admin.online-registration-courses.online-registration-documents.modals.delete')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}">
                    <i class="voyager-boat"></i> {{ __('voyager::generic.dashboard') }}
                </a>
            </li>
            <li><a href="{{ route('online-registrations') }}">Controles de registros</a></li>
            <li><a
                    href="{{ route('online-registration-categories', ['id' => $onlineRegistrationCourse->onlineRegistrationCategory->online_registration_id]) }}">Categorias</a>
            </li>
            <li><a
                    href="{{ route('online-registration-courses', ['id' => $onlineRegistrationCourse->or_category_id]) }}">cursos</a>
            </li>
            <li>Documentos del curso</li>

        </ol>
    @endsection

    @section('page_title', 'Documentos | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-users"></i>&nbsp;
                Documentos del curso
            </h1>
            <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal"
                title="Clic para crear un nuevo registro">
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
                                <li><strong>Control de registro: </strong>
                                    {{ $onlineRegistrationCourse->onlineRegistrationCategory->onlineRegistration->name }}<br>
                                </li>
                                <li><strong>Categoria: </strong>
                                    {{ $onlineRegistrationCourse->onlineRegistrationCategory->name }}<br></li>
                                <li><strong>Curso: </strong>
                                    {{ $onlineRegistrationCourse->name }}<br></li>
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
                <div class="panel panel-bordered" style="margin: 0px">
                    <div class="panel-body" style="margin: 0px">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <label><strong>Buscar:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName"
                                    placeholder="Buscar por nombre de documento..." />
                            </div>
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="5" class="text-center"><small><strong>Información del
                                                            documento</strong></small></th>
                                                <th colspan="5" class="text-center">
                                                    <small><strong>Detalles de creacion y actualizacion</strong></small>
                                                </th>
                                            </tr>

                                            <tr>
                                                <th><small>Nombre</small></th>
                                                <th><small>Url</small></th>
                                                <th><small>Tipo</small></th>
                                                <th><small>Requerido</small></th>
                                                <th><small>Video</small></th>
                                                <th><small>Usuario creador</small></th>
                                                <th><small>Usuario modificador</small></th>
                                                <th><small>Fecha de creacion</small></th>
                                                <th><small>Fecha de modificacion</small></th>
                                                <th><small>Acciones</small></th>
                                            </tr>


                                        </thead>
                                        <tbody>
                                            @foreach ($documents as $document)
                                                <tr>
                                                    <td><small>{{ $document->name }}</small></td>
                                                    <td><small>{{ $document->url }}</small></td>
                                                    <td><small>{{ $document->type == 'I' ? 'Entrada' : 'Salida' }}</small>
                                                    </td>
                                                    <td><small>{{ $document->required ? 'Si' : 'No' }}</small></td>
                                                    <td style="width: 15%">
                                                        @if ($document->video_embebed)
                                                            <div class="embed-responsive embed-responsive-16by9">
                                                                <div class="video-container">
                                                                    {!! $document ? $document->video_embebed : '' !!}
                                                                </div>
                                                            </div>
                                                        @else
                                                            <small>Sin video explicativo</small>
                                                        @endif
                                                    </td>
                                                    <td><small>{{ $document->userCreated->name ?? '' }}</small></td>
                                                    <td><small>{{ $document->userUpdated->name ?? 'Sin modificaciones' }}</small>
                                                    </td>
                                                    <td><small>{{ $document->created_at }}</small></td>
                                                    <td><small>{{ $document->updated_at }}</small></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-primary sm-b" data-toggle="modal"
                                                            title="Clic para editar el registro"
                                                            data-target="#edit-modal"
                                                            wire:click="edit({{ $document->id }})">Editar
                                                        </button>

                                                        <button class="btn btn-danger sm-b" data-toggle="modal"
                                                            data-target="#delete-modal"
                                                            wire:click="delete({{ $document->id }})">Eliminar</button>

                                                        <a wire:click='downloadDocument(@json($document->url))'
                                                            class="btn btn-success sm-b">
                                                            Descargar
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                    <div>
                                        <p>Mostrando {{ $documents->firstItem() }} a
                                            {{ $documents->lastItem() }} de
                                            {{ $documents->total() }} resultados</p>
                                        {{ $documents->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
