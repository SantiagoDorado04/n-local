<div>
    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard')}}"><i class="voyager-boat"></i> {{ __('voyager::generic.dashboard')
                }}</a>
        </li>
        <li>Proyectos</li>
    </ol>
    @endsection

    @section('page_title', 'Proyectos | '.setting('admin.title'))

    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="fa fa-briefcase"></i>Proyectos
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
                                <div id="jsmind_container"></div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <div wire:ignore>
                                        <table id="myTable" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th><small>#</small></th>
                                                    <th><small>Título</small></th>
                                                    <th>Empresa</th>
                                                    <th class="thwidth text-center"><small>Acciones</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($projects as $project)
                                                <tr>
                                                    <td width="5%">{{ $loop->iteration }}</td>
                                                    <td>{{ $project->title }}</td>
                                                    <td>{{ $project->announcementContact->contact->name ?? '' }}</td>
                                                    <td class="thwidth text-center">
                                                        <a href="{{ route('projects.user',['announcement'=>$project->id,'project'=>$project]) }}" class="btn btn-primary sm-b" style="text-decoration: none"><i class="fa fa-pencil-square"></i>&nbsp;Pathway Autogestion</a>
                                                        <a href="{{ route('viability',['id'=>$project->id]) }}" class="btn btn-success sm-b" style="text-decoration: none"><i class="fa fa-pencil-square"></i>&nbsp;Viabilidad</a>
                                                        <a href="{{ route('projects.map',['project'=>$project->id]) }}" class="btn btn-success sm-b" style="text-decoration: none">
                                                            <i class="fa fa-sitemap"></i>&nbsp;Visualizar
                                                        </a>
                                                    </td>
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
                    [0, ""],
                    [1, "desc"],
                ],
            });

            table.order([0, ""],[1, "desc"]).draw();

            Livewire.on('refreshData', function() {
                table.clear();
                table.draw();
            });
        });
    </script>
</div>
