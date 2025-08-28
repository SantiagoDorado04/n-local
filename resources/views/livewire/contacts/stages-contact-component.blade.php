<div>
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}">
                    <i class="voyager-boat"></i> {{ __('voyager::generic.dashboard') }}
                </a>
            </li>
            <li>
                <a href="{{ route('processes.contact') }}">Procesos</a>
            </li>
            <li>Mis etapas</li>
        </ol>
    @endsection

    @section('page_title', 'Mis etapas | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-building-o"></i> Mis etapas
            </h1>
        </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            @forelse ($stages as $stage)
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="panel panel-primary" overflow: hidden;">
                                        <div class="panel-heading panel-heading-custom">
                                            <h4 class="panel-title-custom">
                                                {{ Str::limit($stage->name, 50) }}
                                            </h4>
                                        </div>

                                        @if ($stage->embebed_video)
                                            <div class="embed-responsive embed-responsive-16by9">
                                                {!! $stage->embebed_video !!}
                                            </div>
                                        @endif

                                        <div class="panel-body" style="background-color:#fff; min-height:120px;">
                                            <p style="text-align: justify; text-justify: inter-word; margin-bottom:0;">
                                                {{ Str::limit($stage->description, 200) }}
                                            </p>
                                        </div>

                                        <div class="panel-footer text-right">
                                            <a href="{{ route('steps.contact', $stage->id) }}"
                                                class="btn btn-primary btn-sm">
                                                Ir a pasos
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-md-12">
                                    <p class="text-center">No tienes etapas asignadas.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
