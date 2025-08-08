<div>
    
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>Pathway Autogestión</li>
        </ol>
    @endsection

    @section('page_title', 'Pathway Autogestión | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-cogs"></i>Pathway Autogestión
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
                                <div class="col-lg-6">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($project->announcement->name ?? '', 26) }}
                                            </h5>
                                        </div>
                                    </div>
                                    <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                        data-toggle="modal" data-target="#show-modal"
                                        wire:click="show({{ $project->id }})">
                                        <div class="panel-body" style="height:120px">
                                            <p
                                                style="  text-align: justify;
                                        text-justify: inter-word;">
                                                {{ Str::limit($project->announcement->description ?? '', 150) }}</p>
                                        </div>
                                    </button>
                                    <div class="panel-footer">
                                        <div class="pull-right">
                                            <a class="btn btn-primary" href="{{ route('projects.user',['announcement'=>$project->id]) }}"><i class="fa fa-briefcase"></i>&nbsp;Proyectos</a>
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
