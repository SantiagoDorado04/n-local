<div>
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
                <a href="{{ route('steps.contact', ['id' => $step->stage_id]) }}">Pasos</a>
            </li>
            <li>
                Retos / Entregables
            </li>
        </ol>
    @endsection

    @section('page_title', 'Retos / Entregables | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title"><i class="fa fa-cloud-upload"></i>&nbsp;Retos / Entregables</h1>
        </div>
    @endsection

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin-bottom:0px">
                    <div class="panel-body" style="margin-bottom:0px">
                        <small>
                            <ul>
                                <li><strong>Proceso:</strong> {{ $step->stage->process->name }}</li>
                                <li><strong>Etapa:</strong> {{ $step->stage->name }}</li>
                                <li><strong>Paso:</strong> {{ $step->name }}</li>
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
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <div class="row no-margin-bottom">
                                    @php
                                        $findChallenge = false;
                                    @endphp
                                    @foreach ($challenges as $challenge)
                                        @php
                                            $findChallenge = false;
                                            $requiredPoints = $challenge->required_points ?? 0;
                                            $userPoints = Auth::user()->contact ? Auth::user()->contact->points : 0;
                                            $content = false;
                                        @endphp
                                        @php
                                            foreach ($challengesContact as $challengeContact) {
                                                if ($challengeContact->challenge_id == $challenge->id) {
                                                    $findChallenge = true;
                                                    break;
                                                }
                                            }
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
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="panel panel-primary">

                                                <div
                                                    class="panel-heading  {{ $findChallenge ? 'panel-heading-custom-success' : 'panel-heading-custom' }}">
                                                    <h5 class="panel-title-custom">
                                                        {{ Str::limit($challenge->title, 26) }}
                                                    </h5>
                                                </div>
                                                @if ($content == true)
                                                    @if ($findChallenge == false)
                                                        <div class="panel-body">
                                                            <ul class="list-group list-group-flush"
                                                                style="width: 100%;">
                                                                <li class="list-group-item" style="margin-top:20px">
                                                                    <p
                                                                        style="text-align: justify; text-justify: inter-word; margin:0px">
                                                                        <strong>Reto / Entregable:
                                                                        </strong> {{ $challenge->title }}
                                                                    </p>
                                                                </li>
                                                                <li class="list-group-item" style="margin-top:20px">
                                                                    <p
                                                                        style="text-align: justify; text-justify: inter-word; margin:0px">
                                                                        {{ $challenge->instructions }}
                                                                    </p>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <div class="form-group">
                                                                        <label><strong>Cargar archivo (Documentos:.pdf |
                                                                                .doc .docx | Imágenes:
                                                                                .jpg, jpeg, png):</strong></label>
                                                                        <br>
                                                                        {{-- <label><strong>Cargar archivo:</strong></label> --}}
                                                                        <input type="file" class="form-control"
                                                                            wire:model="files.{{ $challenge->id }}">
                                                                        @error("files.$challenge->id")
                                                                            <small
                                                                                class="text-danger">{{ $message }}</small>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label><strong>Observaciones:</strong></label>
                                                                        <textarea class="form-control" wire:model="observations.{{ $challenge->id }}"></textarea>
                                                                        @error("observations.$challenge->id")
                                                                            <small
                                                                                class="text-danger">{{ $message }}</small>
                                                                        @enderror
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="panel-footer" style="height:60px">
                                                            <div class="pull-right">
                                                                @if (!$stageActive)
                                                                    <p><strong>La etapa en la que te encuentras ya no
                                                                            esta activa o ha
                                                                            finalizado.</strong>
                                                                    </p>
                                                                @else
                                                                    <button class="btn btn-success sm-b"
                                                                        wire:click="submitForm({{ $challenge->id }})">
                                                                        <i class="fa fa-cloud-upload"></i> Enviar
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="panel-body">
                                                            <ul class="list-group list-group-flush"
                                                                style="width: 100%;">
                                                                <li class="list-group-item" style="margin-top:20px">
                                                                    <p
                                                                        style="text-align: justify; text-justify: inter-word; margin:0px">
                                                                        {{ $challenge->instructions }}
                                                                    </p>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <div class="form-group">
                                                                        <label><strong>Observaciones
                                                                                autor:</strong></label>
                                                                        @if ($challengeContact->text)
                                                                            <textarea class="form-control" style="background-color:white" readonly>{{ $challengeContact->text }}</textarea>
                                                                        @else
                                                                            <textarea class="form-control" style="background-color:white" readonly>
                                                            </textarea>
                                                                            <em><strong><small>No se han registrado
                                                                                        observaciones</small></strong></em>
                                                                        @endif
                                                                    </div>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <div class="form-group">
                                                                        <label><strong>Feedback:</strong></label>
                                                                        @if ($challengeContact->feedback)
                                                                            <textarea class="form-control" style="background-color:white" readonly>{{ $challengeContact->feedback }}</textarea>
                                                                        @else
                                                                            <textarea class="form-control" style="background-color:white" readonly>
                                                            </textarea>
                                                                            <em><strong><small>No se han registrado
                                                                                        algun
                                                                                        feedback</small></strong></em>
                                                                        @endif
                                                                    </div>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <a href="{{ Storage::url($challengeContact->file) }}"
                                                                        class="btn btn-primary sm-b" download>
                                                                        <i class="fa fa-download"></i> Descargar
                                                                    </a>
                                                                    @if (!$stageActive)
                                                                        <p><strong>La etapa en la que te encuentras ya
                                                                                no
                                                                                esta activa o ha
                                                                                finalizado.</strong>
                                                                        </p>
                                                                    @else
                                                                        <button class="btn btn-danger sm-b"
                                                                            wire:click="deleteFile({{ $challenge->id }})">
                                                                            <i class="fa fa-trash"></i> Eliminar
                                                                        </button>
                                                                    @endif
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="col-md-12">
                                                        <div class="panel panel-bordered">
                                                            <div class="panel-body">
                                                                <div class="row no-margin-bottom">
                                                                    <p>No tienes suficientes puntos. Te faltan
                                                                        {{ $requiredPoints - $userPoints }} puntos
                                                                        para acceder a este recurso.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

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
