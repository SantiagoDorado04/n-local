<div>

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>Verificación de viabilidad</li>
        </ol>
    @endsection

    @section('page_title', 'Verificación de viabilidad | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-check-square"></i>Verificación de viabilidad
            </h1>
        </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            @foreach ($projects as $project)
                                <div class="col-lg-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($project->title, 26) }}
                                            </h5>
                                        </div>
                                    </div>

                                    <div class="panel-body" style="height:120px">
                                        <div class="row no-margin-bottom">
                                            <div class="col-lg-12" style="margin-bottom:0px">
                                                <p><strong>Título: </strong>{{ $project->title }}</p>
                                            </div>
                                            <div class="col-lg-12" style="margin-bottom:0px">
                                                <p><strong>Descripción: </strong>{{ $project->description }}</p>
                                            </div>
                                            <div class="col-lg-12" style="margin-bottom:0px">
                                                <p><strong>Convocatoria: </strong>{{ $project->announcementContact->announcement->name ?? '' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel-footer">
                                        <div class="pull-right">
                                            <a class="btn btn-primary" href="{{ route('contacts.viability.innovation',['project'=>$project->id]) }}"><i class="fa fa-lightbulb-o"></i>&nbsp;Innovación</a>
                                            <a class="btn btn-warning" href="{{ route('contacts.viability.scale',['project'=>$project->id]) }}"><i class="fa fa-bar-chart"></i>&nbsp;Escala</a>
                                            <a class="btn btn-success" href="{{ route('contacts.viability.impact',['project'=>$project->id]) }}"><i class="fa fa-bolt"></i>&nbsp;Impacto</a>
                                        </div>
                                        <div class="clearfix">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
