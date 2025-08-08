<div>
    <style>
        .wrap-message {
            max-width: 400px;
            /* o el valor que prefieras */
            word-wrap: break-word;
            white-space: pre-wrap;
        }
    </style>

    <div>
        @section('breadcrumbs')
            <ol class="breadcrumb hidden-xs">
                <li class="active">
                    <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                        {{ __('voyager::generic.dashboard') }}</a>
                </li>
                <li>
                    <a href="{{ route('online-registrations') }}">Controles de registro</a>
                </li>
                <li>Ejecuciones por API</li>
            </ol>
        @endsection

        @section('page_title', 'Request | ' . setting('admin.title'))

        @section('page_header')
            <div class="container-fluid">
                <h1 class="page-title">
                    <i class="voyager-compass"></i>&nbsp;Request
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
                                    <li><strong>Control de registro:</strong>
                                        Respuestas por API<br>
                                    </li>
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
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>

                                                <tr>
                                                    <th class="thwidth"><small>Metodo</small></th>
                                                    <th class="thwidth"><small>Url</small></th>
                                                    <th class="thwidth"><small>Request</small></th>
                                                    <th class="thwidth"><small>Estado</small></th>
                                                    <th class="thwidth"><small>Cuerpo</small></th>
                                                    <th class="thwidth"><small>Tipo</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($executions as $execution)
                                                    <tr>

                                                        <td>{{ $execution->method }}</td>
                                                        <td>{{ $execution->url }}</td>
                                                        <td>{{ $execution->request }}</td>
                                                        <td>{{ $execution->status }}</td>
                                                        <td class="wrap-message">{{ $execution->message }}</td>
                                                        <td>{{ $execution->type }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div>
                                            <p>Mostrando {{ $executions->firstItem() }} a
                                                {{ $executions->lastItem() }} de
                                                {{ $executions->total() }} resultados</p>
                                            {{ $executions->links() }}
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
</div>
