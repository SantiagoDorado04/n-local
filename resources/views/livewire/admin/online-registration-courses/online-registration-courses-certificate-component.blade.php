<div>
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
            background-color: #ccc;
            border-radius: 20px;
            padding: 2px;
            cursor: pointer;
        }

        .switch::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: white;
            top: 1px;
            left: 1px;
            transition: transform 0.3s ease-in-out;
        }

        .switch-on {
            background-color: #4CAF50;
        }

        .switch-off {
            background-color: #2196F3;
        }

        .switch-on::after {
            transform: translateX(20px);
        }

        .horizontal-layout {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .horizontal-layout .btn,
        .horizontal-layout .switch,
        .horizontal-layout .label {
            margin: 0;
        }
    </style>
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
            <li>Definicion de certificaciones</li>

        </ol>
    @endsection

    @section('page_title', 'Certificaciones | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-users"></i>&nbsp;
                Definicion de certificaciones
            </h1>
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
                                    placeholder="Buscar por nombre, correo o NIT..." />
                            </div>
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="4" class="text-center"><small><strong>Información del
                                                            usuario</strong></small></th>
                                                <th colspan="2" class="text-center">
                                                    <small><strong>Asistencias</strong></small>
                                                </th>

                                                @if (!empty($requiredDocuments) && count($requiredDocuments) > 0)
                                                    <th colspan="{{ count($requiredDocuments) }}" class="text-center">
                                                        <small><strong>Entradas</strong></small>
                                                    </th>
                                                @endif
                                                @if (!empty($outputDocuments) && $outputDocuments->count() > 0)
                                                    <th colspan="{{ $outputDocuments->count() }}" class="text-center">
                                                        <small><strong>Salidas</strong></small>
                                                    </th>
                                                @endif

                                                <th colspan="1" class="text-center">
                                                    <small><strong>Acciones</strong></small>
                                                </th>
                                            </tr>

                                            <tr>
                                                <th><small>NIT / Cédula</small></th>
                                                <th><small>Nombre</small></th>
                                                <th><small>Correo electrónico</small></th>
                                                <th><small>Teléfono</small></th>
                                                <th><small>No. de asistencias</small></th>
                                                <th><small>% de asistencias</small></th>

                                                @if (!empty($requiredDocuments) && count($requiredDocuments) > 0)
                                                    @foreach ($requiredDocuments as $document)
                                                        <th><small>{{ $document->name }}</small></th>
                                                    @endforeach
                                                @endif

                                                @if (!empty($outputDocuments) && count($outputDocuments) > 0)
                                                    @foreach ($outputDocuments as $document)
                                                        <th><small>{{ $document->name }}</small></th>
                                                    @endforeach
                                                @endif

                                                <th><small>Acciones</small></th>
                                            </tr>


                                        </thead>
                                        <tbody>
                                            @foreach ($contactsStats as $stat)
                                                <tr>
                                                    <td>{{ $stat['contact']->contact->nit }}</td>
                                                    <td>{{ $stat['contact']->contact->name }}</td>
                                                    <td>{{ $stat['contact']->contact->email }}</td>
                                                    <td>
                                                        <a href="https://wa.me/+57{{ $stat['contact']->contact->phone }}"
                                                            target="_blank">
                                                            {{ $stat['contact']->contact->whatsapp }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $stat['assistance_count'] }} / {{ $totalSessions }}</td>
                                                    <td>{{ number_format($stat['percentage'], 0) }} %</td>

                                                    @if (!empty($requiredDocuments))
                                                        @foreach ($requiredDocuments as $document)
                                                            <td>
                                                                @php
                                                                    $uploadedDoc = $stat['submitted_documents']->get(
                                                                        $document->id,
                                                                    );
                                                                @endphp

                                                                @if ($uploadedDoc)
                                                                    <a href="{{ Storage::url($uploadedDoc->url) }}"
                                                                        class="btn btn-success" data-bs-toggle="tooltip"
                                                                        title="Descargar documento" download
                                                                        target="_blank">
                                                                        <i class="fa fa-download"></i>
                                                                    </a>
                                                                @else
                                                                    <span class="text-danger small">No subido</span>
                                                                @endif
                                                                <a href="{{ route('or-certificate-email', ['courseId' => $onlineRegistrationCourse->id, 'id' => $stat['contact']->contact->id]) }}"
                                                                    class="btn btn-warning" data-bs-toggle="tooltip"
                                                                    title="Enviar correo">
                                                                    <i class="fa fa-envelope"></i>
                                                                </a>
                                                            </td>
                                                        @endforeach
                                                    @endif
                                                    @if (!empty($outputDocuments))
                                                        @foreach ($outputDocuments as $document)
                                                            <td>

                                                                <a href="{{ route('descargar.certificado', ['id' => $document->id, 'contactId' => $stat['contact']->contact->id]) }}"
                                                                    class="btn btn-success" data-bs-toggle="tooltip"
                                                                    title="Descargar documento">
                                                                    <i class="fa fa-download"></i>
                                                                </a>


                                                                <a href="{{ route('or-certificate-email', ['courseId' => $onlineRegistrationCourse->id, 'id' => $stat['contact']->contact->id]) }}"
                                                                    class="btn btn-warning" data-bs-toggle="tooltip"
                                                                    title="Enviar correo">
                                                                    <i class="fa fa-envelope"></i>
                                                                </a>

                                                                <button class="btn btn-info" data-bs-toggle="tooltip"
                                                                    title="Detalle documento">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </button>
                                                            </td>
                                                        @endforeach
                                                    @endif

                                                    <td>
                                                        <div class="horizontal-layout">
                                                            <div class="switch {{ $stat['contact']->certificate ? 'switch-on' : 'switch-off' }}"
                                                                wire:click="toggleApproval({{ $stat['contact']->id }})">
                                                            </div>
                                                            <div>
                                                                {{ $stat['contact']->certificate ? 'Aprobado' : 'No aprobado' }}
                                                            </div>

                                                            {{-- <button class="btn btn-success" data-bs-toggle="tooltip" title="Reenviar certificado">
                                                                <i class="fa fa-paper-plane"></i>
                                                            </button> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                    <div>
                                        <p>Mostrando {{ $contactsCourse->firstItem() }} a
                                            {{ $contactsCourse->lastItem() }} de
                                            {{ $contactsCourse->total() }} resultados</p>
                                        {{ $contactsCourse->links() }}
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
