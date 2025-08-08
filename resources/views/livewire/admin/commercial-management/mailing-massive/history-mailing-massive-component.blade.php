<div>
    <style>
        .sm-b {
            padding: 5px 10px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }
    </style>


    @section('page_title', 'Bandeja de salida masiva | '.setting('admin.title'))

    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li>Bandeja de salida masiva</li>
    </ol>
    @endsection

    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="fa fa-inbox"></i>&nbsp;Bandeja De Salida Masiva
        </h1>
        <a href="{{ route('mailing.massive') }}" class="btn btn-success btn-add-new">
            <i class="fa fa-plus-square"></i>&nbsp;{{ __('voyager::generic.add_new') }}
        </a>
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
                                                    <th class="thwidth"><small>Actions</th>
                                                    <th class="thwidth"><small>ID</th>
                                                    <th class="thwidth"><small>Estado</small></th>
                                                    <th class="thwidth"><small>Fecha envío</small></th>
                                                    <th class="thwidth"><small>Nombre campaña</small></th>
                                                    <th class="thwidth"><small>Asunto</small></th>
                                                    <th class="thwidth"><small>Enviado por</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($campaigns as $campaign)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('mailing.massive',['id'=>$campaign->id]) }}" class="btn btn-success sm-b"><i class="fa fa-eye"></i></a>
                                                        <a href="{{ route('mailing.massive.contacts',['id'=>$campaign->id]) }}" class="btn btn-primary sm-b"><i class="fa fa-address-book-o"></i></a>
                                                    </td>
                                                    <td>{{ $campaign->id}}</td>
                                                    <td class="thwidth">
                                                        @if ($campaign->status == 'sent')
                                                        <span class="label label-primary">
                                                            Envíado
                                                        </span>
                                                        @elseif($campaign->status == 'received')
                                                        <span class="label label-success">
                                                            Leido
                                                        </span>
                                                        @elseif($campaign->status == 'draft')
                                                        <span class="label label-warning">
                                                            Borrador
                                                        </span>
                                                        @endif
                                                    </td>
                                                    <td class="thwidth">{{ \Carbon\Carbon::parse($campaign->send_date)->locale('es')->isoFormat('DD MMMM, YYYY h:mm:ss A') }}</td>
                                                    <td class="thwidth">{{ $campaign->name }}</td>
                                                    <td class="thwidth">{{ $campaign->subject }}</td>
                                                    <td>{{ $campaign->user->name  ?? '' }}</td>
                                                </tr>
                                                @endforeach
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