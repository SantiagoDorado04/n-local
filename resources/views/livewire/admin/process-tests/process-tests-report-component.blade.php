<div>
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
                <a href="{{ route('stages', ['id' => $test->step->stage->process_id]) }}">Etapas</a>
            </li>
            <li>
                <a href="{{ route('steps', ['id' => $test->step->stage_id]) }}">Pasos</a>
            </li>
            <li>Reporte del test: {{ $test->name }}
            </li>
        </ol>
    @endsection

    @section('page_title', 'Reporte del Test | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-chart-bar"></i>&nbsp;Reporte del Test: {{ $test->name }}
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
                                <li><strong>Proceso:</strong>
                                    {{ $test->step->stage->process->name }}
                                </li>
                                <li><strong>Etapa:</strong>
                                    {{ $test->step->stage->name }}
                                </li>
                                <li><strong>Paso:</strong> {{ $test->step->name }}</li>
                                <li><strong>Test:</strong> {{ $test->name }}</li>
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
                        <div class="col-lg-12">

                            <!-- 🔹 Botón de exportar -->
                            <div class="mb-3 text-end">
                                <button id="btnExportar" class="btn btn-success">
                                    <i class="fa fa-file-excel-o"></i> Exportar a Excel
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table id="tablaReporte" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th><small>NIT / Cédula</small></th>
                                            <th><small>Nombre</small></th>
                                            <th><small>Correo electrónico</small></th>
                                            <th><small>Teléfono</small></th>
                                            @foreach ($questions as $question)
                                                <th><small>{{ $question->text }}</small></th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contactsWithAnswers as $contactData)
                                            <tr>
                                                <td>{{ $contactData['contact']->nit ?? $contactData['contact']->identification }}
                                                </td>
                                                <td>{{ $contactData['contact']->name }}</td>
                                                <td>{{ $contactData['contact']->email }}</td>
                                                <td>{{ $contactData['contact']->phone }}</td>
                                                @foreach ($questions as $question)
                                                    <td>
                                                        @if (isset($contactData['answers'][$question->id]))
                                                            {{ $contactData['answers'][$question->id]->option->text ?? $contactData['answers'][$question->id]->answer }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                @endforeach
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

<script src="https://unpkg.com/xlsx@0.16.9/dist/xlsx.full.min.js"></script>
<script src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
<script src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>

<script>
    document.addEventListener('livewire:load', function() {
        const $btnExportar = document.querySelector("#btnExportar"),
            $tabla = document.querySelector("#tablaReporte");

        if ($btnExportar) {
            $btnExportar.addEventListener("click", function() {
                let tableExport = new TableExport($tabla, {
                    exportButtons: false,
                    filename: "Reporte_{{ Str::slug($test->name, '_') }}",
                    sheetname: "Reporte del Test",
                });

                let datos = tableExport.getExportData();
                let preferencias = datos.tablaReporte.xlsx;
                tableExport.export2file(
                    preferencias.data,
                    preferencias.mimeType,
                    preferencias.filename,
                    preferencias.fileExtension,
                    preferencias.merges,
                    preferencias.RTL,
                    preferencias.sheetname
                );
            });
        }
    });
</script>
