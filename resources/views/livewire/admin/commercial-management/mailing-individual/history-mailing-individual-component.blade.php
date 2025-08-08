<div>
    <style>
        .sm-b {
            padding: 5px 10px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }
    </style>


    @section('page_title', 'Bandeja de salida individual | '.setting('admin.title'))

    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li>Bandeja de salida individual</li>
    </ol>
    @endsection

    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="fa fa-inbox"></i>&nbsp;Bandeja de salida individual
        </h1>
        <a href="{{ route('mailing.individual') }}" class="btn btn-success btn-add-new">
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
                                                    <th class="thwidth"><small>Fecha apertura</small></th>
                                                    <th class="thwidth"><small>Contacto</small></th>
                                                    <th class="thwidth"><small>Correo electrónico</small></th>
                                                    <th class="thwidth"><small>Asunto</small></th>
                                                    <th class="thwidth"><small>CC</small></th>
                                                    <th class="thwidth"><small>CCO</small></th>
                                                    <th class="thwidth"><small>Enviado por</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($emails as $email)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('mailing.individual',['id'=>$email->id]) }}" class="btn btn-success sm-b"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                    <td>{{ $email->id}}</td>
                                                    <td class="thwidth">
                                                        @if ($email->status == 'sent')
                                                        <span class="label label-primary">
                                                            Envíado
                                                        </span>
                                                        @elseif($email->status == 'received')
                                                        <span class="label label-success">
                                                            Leido
                                                        </span>
                                                        @elseif($email->status == 'draft')
                                                        <span class="label label-warning">
                                                            Borrador
                                                        </span>
                                                        @endif
                                                    </td>
                                                    <td class="thwidth">{{ \Carbon\Carbon::parse($email->send_date)->locale('es')->isoFormat('DD MMMM, YYYY h:mm:s A') }}</td>
                                                    <td class="thwidth">{{ $email->opening_date != '' ?\Carbon\Carbon::parse($email->opening_date)->locale('es')->isoFormat('DD MMMM, YYYY h:mm A') : ''}}</td>
                                                    <td class="thwidth">{{ $email->contact->name ?? 'No registrado' }}</td>
                                                    <td class="thwidth">{{ $email->to }}</td>
                                                    <td class="thwidth">{{ $email->subject }}</td>
                                                    <td class="thwidth">
                                                        @if($email->cc !='')
                                                            @foreach (json_decode($email->cc) as $item)
                                                                <ul>- {{ $item }}</ul>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td class="thwidth">
                                                        @if($email->cco !='')
                                                            @foreach (json_decode($email->cco) as $item)
                                                                <ul>- {{ $item }}</ul>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>{{ $email->user->name  ?? '' }}</td>
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