<div>

    @include('livewire.admin.commercial-forms.modals-contacts.info')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('commercial.forms') }}">Formularios</a>
            </li>
            <li>
                <a href="{{ route('commercial.form-action',['form'=>$form->id]) }}">Acciones</a>
            </li>
            <li>Contactos</li>
        </ol>
    @endsection

    @section('page_title', 'Contactos | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-address-card"></i>Contactos
            </h1>
        </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-3">
                                <label><strong>Buscar empresa:</strong></label>
                                <input type="text" class="form-control" wire:model='searchName'
                                    placeholder="Nombre de la empresa">
                            </div>
                        </div>
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
                        <div class="table-responsive">
                            <div wire:ignore>
                                <table class="table table-hover" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th class="thwidth"><small>NIT</small></th>
                                            <th class="thwidth"><small>Empresa</small></th>
                                            <th class="thwidth"><small>Correo elelctrónico</small></th>
                                            <th class="thwidth"><small>Teléfono</small></th>
                                            <th class="thwidth"><small>WhatsApp</small></th>
                                            <th class="thwidth"><small>Persona de contacto</small></th>
                                            <th class="thwidth"><small>Página Web</small></th>
                                            <th class="thwidth"><small>Acción Comercial</small></th>
                                            <th class="thwidth"><small>Estrategia comercía</small></th>
                                            <th class="thwidth"><small>Terreno Comercial</small></th>
                                            <th class="thwidth"><small>Formulario</small></th>
                                            <th class="thwidth" class="actions text-right dt-not-orderable">
                                                <small>{{ __('voyager::generic.actions') }}</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($contacts) > 0)
                                            @foreach ($contacts as $contact)
                                                <tr>
                                                    <td>{{ $contact->id }}</td>
                                                    <td>{{ $contact->nit }}</td>
                                                    <td>{{ $contact->name }}</td>
                                                    <td>{{ $contact->email }}</td>
                                                    <td>{{ $contact->phone }}</td>
                                                    <td>{{ $contact->whatsapp }}</td>
                                                    <td>{{ $contact->contact_person_name }}</td>
                                                    <td>{{ $contact->website }}</td>
                                                    <td>{{ $contact->commercial_action_name }}</td>
                                                    <td>{{ $contact->commercial_strategy_name }}</td>
                                                    <td>{{ $contact->commercial_land_name }}</td>
                                                    <td>{{ $contact->commercial_form_name }}</td>
                                                    <td class="no-sort no-click bread-actions">
                                                        <button class="btn btn-success sm-b" data-toggle="modal"
                                                            data-target="#info-modal"
                                                            wire:click="getResult({{ $contact->contact_id }})"><i
                                                                class="fa fa-check-square"></i>&nbsp;Resultado</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <th class="text-center" colspan="11">No se encontraron resultados</th>
                                            </tr>
                                        @endif()
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        document.addEventListener('livewire:load', function() {
            var table = $('#myTable').DataTable({
                language: {
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    zeroRecords: "No se encontraron registros",
                    info: "Página _PAGE_ de _PAGES_",
                    infoEmpty: "No hay registros disponibles",
                    infoFiltered: "(Filtrando página _MAX_ total de registros)",
                    search: "Buscar",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Previo"
                    }
                },
                "order": [
                    [0, "desc"]
                ],
                columnDefs: [{
                    targets: [
                        0,
                    ],
                    orderable: false
                }]
            });

            table.order([0, "desc"]).draw();

            Livewire.on('refreshData', function() {
                table.clear();
                table.draw();
            });
        });
    </script>
</div>
