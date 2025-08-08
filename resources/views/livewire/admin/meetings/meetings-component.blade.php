<div>
    @include('livewire.admin.meetings.modals.create')

    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li>Registro de agendamientos</li>
    </ol>
    @endsection

    @section('page_title', 'Registro de agendamientos | '.setting('admin.title'))

    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="fa fa-calendar"></i><b>Registro de agendamientos - </b>Calendario
        </h1>
    </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin: 0px">
                    <div class="panel-body" style="margin: 0px">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <div id='calendar-container' wire:ignore>
                                    <div id='calendar'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('javascript')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/locale/es.js'></script>

        <script>
            document.addEventListener('livewire:load', function() {
                var today = new Date();
                var data = @this.events;

                var Calendar = FullCalendar.Calendar;
                var calendarEl = document.getElementById('calendar');

                var calendar = new Calendar(calendarEl, {
                    initialView: "timeGridWeek",
                    themeSystem: 'bootstrap',
                    height: 700,
                    slotMinTime: "07:00:00",
                    slotMaxTime: "19:00:00",
                    slotLabelFormat: [{
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    }],
                    allDaySlot: false,
                    slotEventOverlap: false,
                    titleFormat: {
                        month: 'long',
                        year: '2-digit',
                        day: 'numeric',
                        weekday: 'long',
                    },
                    slotDuration: '00:10',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    locale: 'es',
                    scrollTime: '07:00:00',
                    events: (data),
                    selectable: true,
                    displayEventTime: true,
                    eventTimeFormat: { // like '14:30:00'
                        hour: '2-digit',
                        minute: '2-digit'
                    },
                    dateClick(info) {
                        var currentDate = new Date(); // Obtiene la fecha actual
                        if (info.date < currentDate) {
                            // Si la fecha seleccionada es anterior a la fecha actual, no se permite el clic
                            return false;
                        }
                        @this.meetDate = info.dateStr;
                        @this.allDay = info.allDay;
                        $('#create-modal').modal('show');
                    },
                    eventClick: function(info) {
                        @this.getEvent(info.event.id);
                        $('#show-modal').modal('show');
                    },

                    loading: function(isLoading) {
                        if (!isLoading) {
                            this.getEvents().forEach(function(e) {
                                if (e.source === null) {
                                    e.remove();
                                }
                            });
                        }
                    }
                });

                document.addEventListener('clearEventCalendar', ({
                    detail
                }) => {
                    if (detail.refresh) {
                        //Limpiar eventos
                        var eventSources = calendar.getEventSources();
                        var len = eventSources.length;
                        for (var i = 0; i < len; i++) {
                            eventSources[i].remove();
                        }
                    }
                });

                document.addEventListener('refreshEventCalendar', ({
                    detail
                }) => {
                    if (detail.refresh) {
                        //Limpiar eventos
                        var eventSources = calendar.getEventSources();
                        var len = eventSources.length;
                        for (var i = 0; i < len; i++) {
                            eventSources[i].remove();
                        }
                        calendar.addEventSource(@this.events);

                        calendar.refetchEvents();
                    }
                })

                calendar.render();
            });
        </script>
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.css' rel='stylesheet' />
    @endpush
</div>