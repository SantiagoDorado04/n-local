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
            <a href="{{ route('steps.contact', ['id' => $course->step->stage_id]) }}">Pasos</a>
        </li>
        <li>
            <a href="{{ route('lms.contact', ['id' => $course->step_id]) }}">Cursos</a>
        </li>
        <li>Contenido</li>
    </ol>
@endsection

@section('page_title', 'Cursos | ' . setting('admin.title'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="fa fa-book"></i>&nbsp;Curso "{{ $course->name }}"
        </h1>
    </div>
@stop

@php
    $requiredPoints = $course->required_points ?? 0;
    $userPoints = Auth::user()->contact ? Auth::user()->contact->points : 0;
    $content = false;
@endphp

@if ($requiredPoints == 0)
    @php
        $content = true;
    @endphp
@elseif($userPoints >= $requiredPoints)
    @php
        $content = true;
    @endphp
@endif

@if ($course->topics->isNotEmpty() && $currentLesson)

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            @if ($content == true)
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <div class="row no-margin-bottom">
                                <div class="col-md-8">
                                    <div class="panel panel-bordered">
                                        <div class="panel-body">
                                            <div class="row no-margin-bottom">
                                                <div class="col-lg-12" style="margin-bottom: 0px">
                                                    <ul class="list-group list-group-flush" style="width: 100%;">
                                                        <li class="list-group-item">
                                                            <h4>{{ $currentLesson->topic->name . ' : ' . $currentLesson->title }}
                                                                @if (in_array($currentLesson->id, $progressUser))
                                                                    <span class="badge badge-success"><i
                                                                            class="fa fa-check"></i>&nbsp;Completada</span>
                                                                @endif
                                                            </h4>
                                                        </li>
                                                    </ul>
                                                </div>
                                                @if (!in_array($currentLesson->id, $progressUser))
                                                    <div class="col-lg-12" style="margin-bottom: 0px">
                                                        <div class="row no-margin-bottom">
                                                            <div class="col-lg-12" style="margin-bottom: 0px">
                                                                @if (!$stageActive)
                                                                    <p><strong>La etapa en la que te encuentras ya
                                                                            no
                                                                            esta activa o ha
                                                                            finalizado.</strong>
                                                                    </p>
                                                                @else
                                                                    <button wire:click="startLesson"
                                                                        class="btn btn-primary sm-b">
                                                                        Iniciar
                                                                        Lección</button>
                                                                        {{-- <button wire:click="lessonCompleted"
                                                                        class="btn btn-success sm-b">
                                                                        Marcar como completada</button> --}}
                                                                @endif
                                                            </div>
                                                            <div class="col-lg-10"
                                                                style="margin-bottom: 0px; padding-top:12px">
                                                                <div class="progress flex-grow-1 ml-3">
                                                                    <div class="progress-bar progress-bar-success"
                                                                        role="progressbar"
                                                                        style="width: {{ $progress }}%;"
                                                                        aria-valuenow="{{ $progress }}"
                                                                        aria-valuemin="0" aria-valuemax="100">
                                                                        {{ intval($progress) }}%
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="col-lg-12" style="margin-bottom: 0px">
                                                    <div class="row no-margin-bottom">
                                                        @if ($currentLesson->file)
                                                            <div class="col-lg-12">
                                                                <div class="embed-responsive embed-responsive-16by9">
                                                                    @if (pathinfo($currentLesson->file, PATHINFO_EXTENSION) === 'pdf')
                                                                        <iframe
                                                                            src="https://docs.google.com/gview?url={{ asset($currentLesson->file) }}&embedded=true"
                                                                            style="width:600px; height:500px;"
                                                                            frameborder="0"></iframe>

                                                                        <iframe class="embed-responsive-item"
                                                                            src="{{ asset($currentLesson->file) }}"
                                                                            frameborder="0"></iframe>
                                                                    @elseif(in_array(pathinfo($currentLesson->file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                                        <img class="embed-responsive-item"
                                                                            src="{{ asset($currentLesson->file) }}"
                                                                            alt="Imagen de la lección">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <a href="{{ asset($currentLesson->file) }}"
                                                                    class="btn btn-success" download>Descargar
                                                                    Recurso</a>
                                                            </div>
                                                            <div class="col-lg-6" style="margin-bottom: 0px">
                                                                <p class="pull-right"><i class="fa fa-clock-o"></i>
                                                                    Duración:
                                                                    {{ $currentLesson->duration }} minutos</p>
                                                            </div>
                                                        @endif
                                                        @if ($currentLesson->video)
                                                            <div class="col-lg-12">
                                                                <div class="embed-responsive embed-responsive-16by9">
                                                                    {!! $currentLesson->video !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12" style="margin-bottom: 0px">
                                                                <p class="pull-right"><i class="fa fa-clock-o"></i>
                                                                    Duración:
                                                                    {{ $currentLesson->duration }} minutos</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12" style="margin-bottom: 0px">
                                                <ul class="list-group list-group-flush" style="width: 100%;">
                                                    <li class="list-group-item">

                                                        <p>{!! $currentLesson->content !!}</p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="panel panel-bordered">
                                        <div class="panel-body">
                                            <div class="row no-margin-bottom">
                                                <div class="col-lg-12">
                                                    <div class="panel-group" id="accordion">
                                                        @foreach ($course->topics as $index => $topic)
                                                            <div class="panel panel-primary">
                                                                <a data-toggle="collapse" data-parent="#accordion"
                                                                    href="#collapse{{ $index }}"
                                                                    style="text-decoration:none">
                                                                    <div class="panel-heading panel-heading-custom"
                                                                        id="heading{{ $index }}"
                                                                        style="padding: 4px">
                                                                        <p style="padding: 5px; margin-bottom:0px">
                                                                            <strong>{{ $topic->name }} </strong>
                                                                        </p>
                                                                    </div>
                                                                </a>
                                                                <div id="collapse{{ $index }}"
                                                                    class="panel-collapse collapse in">
                                                                    <div class="panel-body">
                                                                        <ul class="list-group">
                                                                            @foreach ($topic->lessons as $lesson)
                                                                                <li
                                                                                    class="list-group-item @if (in_array($lesson->id, $progressUser)) completed @endif">
                                                                                    <a href="#"
                                                                                        wire:click="loadLesson({{ $lesson->id }})">
                                                                                        {{ $lesson->title }}
                                                                                    </a>
                                                                                    @if (in_array($lesson->id, $progressUser))
                                                                                        <span
                                                                                            class="badge badge-success"><i
                                                                                                class="fa fa-check"></i></span>
                                                                                    @endif
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
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
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <div class="row no-margin-bottom">
                                <p>No tienes suficientes puntos. Te faltan {{ $requiredPoints - $userPoints }} puntos
                                    para acceder a este recurso.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@else
    <div class="alert alert-warning" role="alert">
        No hay lecciones disponibles para este curso.
    </div>
@endif
<script>
    document.addEventListener('livewire:load', function() {
        let timer;
        let startTime;
        let endTime;
        let duration;

        function startTimer() {
            startTime = new Date().getTime();
            endTime = startTime + (duration * 1000);
            timer = setInterval(updateProgress, 1000);
        }

        function updateProgress() {
            let now = new Date().getTime();
            let elapsedTime = now - startTime;
            let progress = (elapsedTime / (duration * 1000)) * 100;
            Livewire.emit('updateProgress', progress);
            if (now >= endTime) {
                clearInterval(timer);
                Livewire.emit('lessonCompleted');
            }
        }

        function stopTimer() {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
        }

        Livewire.on('lessonStarted', dur => {
            duration = dur;
            startTimer();
        });

        Livewire.on('restart', () => {
            stopTimer();
            Livewire.emit('resetProgress');
        });
    });
</script>
