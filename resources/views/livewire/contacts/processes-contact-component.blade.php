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

        .badge-approved {
            background-color: #4CAF50;
        }

        .badge-not-approved {
            background-color: #FF5722;
        }
    </style>

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>Mis procesos</li>
        </ol>
    @endsection

    @section('page_title', 'Mis procesos | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-rocket"></i> Mis procesos
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
                                    <table id="myTable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><small>Video</small></th>
                                                <th><small>Proceso</small></th>
                                                <th><small>Etapa</small></th>
                                                <th><small>Estado</small></th>
                                                <th><small>Acciones</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($postulations as $item)
                                                <tr>
                                                    <td style="height: 160px;"
                                                        class="embed-responsive embed-responsive-16by9">
                                                        @if ($item->stage->embebed_video)
                                                            {!! $item->stage->embebed_video !!}
                                                        @else
                                                            Sin video Introductorio
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->stage->process->name }}</td>
                                                    <td>{{ $item->stage->name }}</td>
                                                    <td class="text-center">
                                                        @if ($item->approved === null)
                                                            <span class="label label-warning">Pendiente</span>
                                                        @else
                                                            <span
                                                                class="label {{ $item->approved ? 'label-success' : 'label-danger' }}">
                                                                {{ $item->approved ? 'Aprobado' : 'No Aprobado' }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($item->approved === 1)
                                                            <a href="{{ route('steps.contact', ['id' => $item->stage_id]) }}"
                                                                class="btn btn-success sm-b"
                                                                style="text-decoration: none; margin: 0px">
                                                                <i class="fa fa-arrow-right"></i>&nbsp;Proceso
                                                            </a>
                                                        @endif
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
