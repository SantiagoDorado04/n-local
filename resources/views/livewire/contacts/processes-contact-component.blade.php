<div>
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}">
                    <i class="voyager-boat"></i> {{ __('voyager::generic.dashboard') }}
                </a>
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
                            @forelse ($processes as $process)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($process->name, 26) }}
                                            </h5>
                                        </div>
                                        <div class="panel-body" style="height:120px; background-color: #fff;">
                                            <p style="text-align: justify; text-justify: inter-word;">
                                                {{ Str::limit($process->description, 150) }}
                                            </p>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="pull-right">
                                                <a href="{{ route('stages.contact', $process->id) }}"
                                                    class="btn btn-primary sm-b">
                                                    <i class="fa fa-grav"></i>&nbsp;Ir a etapas
                                                </a>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-md-12">
                                    <p class="text-center">No tienes procesos asignados.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
