<div>
    @php
    $dias = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado'];
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    @endphp
    @include('livewire.admin.contact-schedules.modals.edit')
    @include('livewire.admin.contact-schedules.modals.show')

    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li><a href="{{ route('contacts-schedules') }}">Planificación Contacto</a>
        </li>
        <li>Calendario</li>
    </ol>
    @endsection

    @section('page_title', 'Planificación Contacto | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-calendar"></i><b>Planificación de contacto - </b>Calendario
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

        <script>
            document.addEventListener('livewire:load', function() {
                var data = @this.events;

                var Calendar = FullCalendar.Calendar;
                var calendarEl = document.getElementById('calendar');

                var calendar = new Calendar(calendarEl, {
                    height: 700,
                    slotMinTime: "07:00:00",
                    slotMaxTime: "19:00:00",
                    initialView: "timeGridWeek",
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
                    eventClick: function({
                    event
                    }) {
                        if(event.extendedProps.status!='completed'){
                            Livewire.emit('editSchedule',event.extendedProps.schedule_id);
                            $('#edit-modal').modal('show');
                        }else{
                            Livewire.emit('getSchedule',event.extendedProps.schedule_id);
                            $('#show-modal').modal('show');
                        }
                       
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

                calendar.render();
                @this.on(`refreshCalendar`, () => {
                    calendar.refetchEvents()
                });
            });
        </script>
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.css' rel='stylesheet' />
    @endpush
</div>
