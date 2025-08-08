<div>
    @include('livewire.contacts.l-m-s.modals-lms.show')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('processes.contact') }}">Procesos</a>
            </li>
            <li>
                Pasos
            </li>
        </ol>
    @endsection

    @section('page_title', 'Pasos proceso | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-puzzle-piece"></i> Pasos proceso "{{ $stage->process->name }}"
            </h1>
        </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            @if (!$stage->embebed_video)
                <div class="col-md-12">
                    <div class="panel panel-bordered" style="margin-bottom:0px">
                        <div class="panel-body" style="margin-bottom:0px">
                            <small>
                                <ul>
                                    <li><strong>Proceso:</strong> {{ $stage->process->name }}</li>
                                    <li><strong>Etapa:</strong> {{ $stage->name }}</li>
                                </ul>
                            </small>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-7 d-flex">
                    <div class="panel panel-bordered" style="width: 100%;">
                        <div class="panel-body">
                            <small>
                                <ul>
                                    <li><strong>Proceso:</strong>
                                        {{ $stage->process->name }}</li>
                                    <li><strong>Etapa:</strong> {{ $stage->name }}</li>
                                </ul>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 d-flex">
                    <div class="panel panel-bordered" style="width: 100%;">
                        <div class="panel-body" style="margin-bottom:0px;">
                            <div class="embed-responsive embed-responsive-16by9">
                                @if ($stage->embebed_video)
                                    {!! $stage->embebed_video !!}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            @foreach ($steps as $step)
                                @if (\Carbon\Carbon::parse($step->available_from)->lessThan(\Carbon\Carbon::now()))
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading panel-heading-custom">
                                                <h5 class="panel-title-custom">
                                                    <strong>Paso {{ $loop->iteration }}.</strong>&nbsp;
                                                    {{ Str::limit($step->name, 55) }}
                                                </h5>
                                            </div>

                                            <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                                data-toggle="modal" data-target="#show-modal"
                                                wire:click="show({{ $step->id }})">
                                                <div class="panel-body" style="height:120px">
                                                    <p style="text-align: justify; text-justify: inter-word;">
                                                        <strong>Descripción: </strong>
                                                        {{ Str::limit($step->description, 145) }}
                                                    </p>
                                                </div>
                                            </button>
                                            <div class="panel-footer">
                                                <div class="pull-right">
                                                    @switch($step->step_type)
                                                        @case('F')
                                                            <a class="btn btn-success sm-b"
                                                                href="{{ route('information-forms.contact', ['id' => $step->id]) }}"><i
                                                                    class="fa fa-arrow-right"></i>&nbsp;Ver Formulario</a>
                                                        @break

                                                        @case('LMS')
                                                            <a class="btn btn-success sm-b"
                                                                href="{{ route('lms.contact', ['id' => $step->id]) }}"><i
                                                                    class="fa fa-arrow-right"></i>&nbsp;Cursos</a>
                                                        @break

                                                        @case('M')
                                                            <a class="btn btn-success sm-b"
                                                                href="{{ route('mentoring.contact', ['id' => $step->id]) }}"><i
                                                                    class="fa fa-arrow-right"></i>&nbsp;Ver Mentores</a>
                                                        @break

                                                        @case('FAA')
                                                            <a class="btn btn-success sm-b"
                                                                href="{{ route('presential-activities.contact', ['id' => $step->id]) }}"><i
                                                                    class="fa fa-arrow-right"></i>&nbsp;Ver Actividad</a>
                                                        @break

                                                        @case('VE')
                                                            <a class="btn btn-success sm-b"
                                                                href="{{ route('video-interviews.contact', ['id' => $step->id]) }}"><i
                                                                    class="fa fa-arrow-right"></i>&nbsp;Ver Entrevista</a>
                                                        @break

                                                        @case('CD')
                                                            <a class="btn btn-success sm-b"
                                                                href="{{ route('challenges.contact', ['id' => $step->id]) }}"><i
                                                                    class="fa fa-arrow-right"></i>&nbsp;Ver Reto / Entegable</a>
                                                        @break

                                                        @case('LZ')
                                                            <a class="btn btn-success sm-b"
                                                                href="{{ route('canvas.contact', ['id' => $step->id]) }}"><i
                                                                    class="fa fa-arrow-right"></i>&nbsp;Lienzo</a>
                                                        @break

                                                        @default
                                                    @endswitch
                                                </div>
                                                <div class="clearfix">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
