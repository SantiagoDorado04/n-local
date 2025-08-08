<div>

    @include('livewire.admin.commercial-management.mailing-massive.modals.info')

    @section('page_title', 'Contactos Campaña | '.setting('admin.title'))

    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li>Contactos Campaña </li>
    </ol>
    @endsection

    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="fa fa-address-book-o"></i>&nbsp;Contactos Campaña  "{{ $campaign->name ?? '' }}"
        </h1>
    </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <div wire:ignore>
                                        <table id="myTable" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="thwidth"><small>Acciones</small></th>
                                                    <th class="thwidth"><small>Nombre</small></th>
                                                    <th class="thwidth"><small>Correo electrónico</small></th>
                                                    <th class="thwidth"><small>Estado</small></th>
                                                    <th class="thwidth"><small>Fecha de apertura</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($campaign!=[])
                                                @foreach ($campaign->contacts as $contact)
                                                    <tr>
                                                        <td>
                                                            <button class="btn btn-primary sm-b" data-toggle="modal" data-target="#info-modal" wire:click="getLinks({{ $contact->id }})">
                                                                <i class="fa fa-link"></i>
                                                            </button>
                                                        </td>
                                                        <td>{{ $contact->contact->name }}</td>
                                                        <td>{{ $contact->contact->email }}</td>
                                                        <td class="thwidth">
                                                            @if ($contact->opening_date!='')
                                                            <span class="label label-success">
                                                                Leido
                                                            </span>
                                                            @else
                                                            <span class="label label-warning">
                                                                Sin Leer
                                                            </span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $contact->opening_date }}</td>
                                                    </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
                    [1, "desc"]
                ],
                columnDefs: [{
                    targets: [
                        0,
                    ],
                    orderable: false
                }]
            });

            table.order([1, "desc"]).draw();

            Livewire.on('refreshData', function() {
                table.clear();
                table.draw();
            });
        });
    </script>
</div>
