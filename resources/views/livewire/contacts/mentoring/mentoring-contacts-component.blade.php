<div wire:poll>
    @include('livewire.contacts.mentoring.modals.confirm')
    @include('livewire.contacts.mentoring.modals.cancel')

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
                Agenda Mentorias
            </li>
        </ol>
    @endsection

    @section('page_title', 'Mentorias | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-calendar"></i> Agenda de Mentorias
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
                            @foreach ($mentors as $mentor)
                                @php
                                    $requiredPoints = $mentor->required_points ?? 0;
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
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="panel panel-info">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ $mentor->mentorList->name }}
                                            </h5>
                                        </div>
                                        @if ($content == true)
                                            <div class="panel-body">
                                                <div class="row no-margin-bottom">
                                                    <div class="col-lg-12">
                                                        @foreach ($mentor->availabilities as $availability)
                                                            @if (!$stageActive)
                                                                <p><strong>La etapa en la que te encuentras ya
                                                                        no
                                                                        esta activa o ha
                                                                        finalizado.</strong>
                                                                </p>
                                                            @else
                                                                <div class="panel panel-info" style="margin-top: 20px">
                                                                    <div class="panel-heading panel-heading-custom">
                                                                        <h5 class="panel-title-custom">
                                                                            <strong>{{ $availability->date }}</strong> |
                                                                            {{ $availability->start_time }} -
                                                                            {{ $availability->end_time }}
                                                                        </h5>
                                                                    </div>
                                                                    <div class="panel-body">
                                                                        <div class="row">
                                                                            <div class="col-lg-12"
                                                                                style="margin-top: 20px">
                                                                                <div class="row no-margin-bottom">
                                                                                    @php
                                                                                        $start = explode(
                                                                                            ':',
                                                                                            $availability->start_time,
                                                                                        );
                                                                                        $end = explode(
                                                                                            ':',
                                                                                            $availability->end_time,
                                                                                        );
                                                                                        $interval = intval(
                                                                                            $mentor->session_duration,
                                                                                        );
                                                                                        $start_minutes =
                                                                                            intval($start[0]) * 60 +
                                                                                            intval($start[1]);
                                                                                        $end_minutes =
                                                                                            intval($end[0]) * 60 +
                                                                                            intval($end[1]);
                                                                                    @endphp
                                                                                    @for ($minutes = $start_minutes; $minutes < $end_minutes; $minutes += $interval)
                                                                                        @php
                                                                                            $hour = floor(
                                                                                                $minutes / 60,
                                                                                            );
                                                                                            $minute = $minutes % 60;
                                                                                            $str =
                                                                                                sprintf('%02d', $hour) .
                                                                                                ':' .
                                                                                                sprintf(
                                                                                                    '%02d',
                                                                                                    $minute,
                                                                                                );

                                                                                            $next_minutes =
                                                                                                $minutes + $interval;
                                                                                            $next_hour = floor(
                                                                                                $next_minutes / 60,
                                                                                            );
                                                                                            $next_minute =
                                                                                                $next_minutes % 60;
                                                                                            $nd =
                                                                                                sprintf(
                                                                                                    '%02d',
                                                                                                    $next_hour,
                                                                                                ) .
                                                                                                ':' .
                                                                                                sprintf(
                                                                                                    '%02d',
                                                                                                    $next_minute,
                                                                                                );
                                                                                        @endphp
                                                                                        <div class="col-md-2">
                                                                                            @php
                                                                                                $find = false;
                                                                                                $findContact = '';
                                                                                                $bookingFind = '';
                                                                                            @endphp
                                                                                            @foreach ($bookings as $booking)
                                                                                                @php
                                                                                                    if (
                                                                                                        $booking->mentor_id ===
                                                                                                            $mentor->id &&
                                                                                                        $booking->start ===
                                                                                                            $str .
                                                                                                                ':00' &&
                                                                                                        $booking->end ===
                                                                                                            $nd .
                                                                                                                ':00' &&
                                                                                                        $booking->date ===
                                                                                                            $availability->date
                                                                                                    ) {
                                                                                                        $find = true;
                                                                                                        $bookingFind =
                                                                                                            $booking->id;
                                                                                                        $findContact =
                                                                                                            $booking->contact_id;
                                                                                                        break;
                                                                                                    }
                                                                                                @endphp
                                                                                            @endforeach

                                                                                            @if ($find == true)
                                                                                                @if ($findContact == $contactId)
                                                                                                    <button
                                                                                                        style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                                                                                        wire:click="cancelBooking({{ $bookingFind }})"
                                                                                                        data-toggle="modal"
                                                                                                        data-target="#delete-modal-2"
                                                                                                        @if (!$stageActive) disabled
                                                                                                    data-bs-toggle="tooltip"
                                                                                                    data-bs-placement="top"
                                                                                                    title="No puede agendar, esta etapa ha finalizado" @endif>
                                                                                                        <div
                                                                                                            class="panel panel-danger">
                                                                                                            <div
                                                                                                                class="panel-body">
                                                                                                                {{ $str . ' - ' . $nd }}
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </button>
                                                                                                @else
                                                                                                    <button
                                                                                                        style="background-color: #fff; border:0px; margin:0px; padding:0px">
                                                                                                        <div class="panel panel-info"
                                                                                                            @if (!$stageActive) disabled
                                                                                                        data-bs-toggle="tooltip"
                                                                                                        data-bs-placement="top"
                                                                                                        title="No puede agendar, esta etapa ha finalizado" @endif>
                                                                                                            <div
                                                                                                                class="panel-body">
                                                                                                                {{ $str . ' - ' . $nd }}
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </button>
                                                                                                @endif
                                                                                            @else
                                                                                                <button
                                                                                                    style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                                                                                    wire:click="selectTimeRange('{{ $str . ' - ' . $nd . ' - ' . $availability->date . ' - ' . $mentor->id }}')"
                                                                                                    data-toggle="modal"
                                                                                                    data-target="#delete-modal"
                                                                                                    @if (!$stageActive) disabled
                                                                                                data-bs-toggle="tooltip"
                                                                                                data-bs-placement="top"
                                                                                                title="No puede agendar, esta etapa ha finalizado" @endif>
                                                                                                    <div
                                                                                                        class="panel panel-success">
                                                                                                        <div
                                                                                                            class="panel-body">
                                                                                                            {{ $str . ' - ' . $nd }}
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </button>
                                                                                            @endif
                                                                                        </div>
                                                                                    @endfor
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-12">
                                                <div class="panel panel-bordered">
                                                    <div class="panel-body">
                                                        <div class="row no-margin-bottom">
                                                            <p>No tienes suficientes puntos. Te faltan
                                                                {{ $requiredPoints - $userPoints }} puntos
                                                                para acceder a esta mentoria.</p>
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
