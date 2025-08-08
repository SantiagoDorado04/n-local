<div>
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('announcements') }}">Convocatorias</a>
            </li>
            <li>
                <a href="{{ route('announcement.forms', ['announcement' => $announcement->id]) }}">Formularios</a>
            </li>
            <li>Configuración</li>
        </ol>
    @endsection

    @section('page_title', 'Configuración Opciones | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-settings"></i> Configuración opciones de respuesta
            </h1>
        </div>
    @stop

    <div class="row no-margin-bottom">
        <div class="col-md-12">
            <div class="panel panel-bordered" style="margin: 0px">
                <div class="panel-body" style="margin: 0px">
                    <ul>
                        <li><strong>Convocatoria: </strong> {{ $announcement->name }}<br></li>
                        <li><strong>Formulario: </strong> {{ $formx->name }}<br></li>
                    </ul>
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
                            <div class="col-md-12">
                                <h5 class="text-center">{{ $formx->name }}</h5>
                            </div>
                            <div class="col-md-12">
                                <p>{{ $formx->description }}</p>
                            </div>
                            @foreach ($questions as $question)
                                <div class="col-md-12">
                                    <div class="panel panel-bordered">
                                        <div class="panel-body">
                                            <div class="row no-margin-bottom">
                                                <div class="col-md-1">
                                                    <strong>{{ $loop->iteration . '. ' }}</strong>
                                                </div>
                                                <div class="col-md-11">
                                                    {!! nl2br($question->question) !!}
                                                    @if ($question->type == 'po')
                                                        <br>
                                                        <br>

                                                        @foreach ($options as $option)
                                                            @php
                                                                $find = false;
                                                            @endphp
                                                            @if ($option->commercial_form_question_id == $question->id)
                                                                <input type="checkbox"
                                                                    name="{{ $question->id . '' . $option->id }}"
                                                                    id="option"
                                                                    onchange="changeOption(
                                                            [{{ $question->id }},{{ $option->id }}]
                                                        )"
                                                                    @foreach ($opQuestions as $opQuestion)
                                                        
                                                        @if ($opQuestion->commercial_question_id == $question->id && $opQuestion->commercial_question_option_id == $option->id)
                                                        @php
                                                            $find=true;
                                                        @endphp
                                                            checked
                                                        @endif @endforeach>
                                                                <span
                                                                    @if ($find == true) style="background-color:rgb(180, 255, 196)" @endif>
                                                                    <label><strong>{{ $option->option }}</strong></label>
                                                                </span>
                                                                <br>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <br>
                                                        <br>
                                                        <textarea class="form-control"></textarea>
                                                    @endif
                                                </div>
                                            </div>
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
@push('javascript')
    <script>
        function changeOption(identify) {

            var valcheck = 0;
            let checkboxes = document.querySelectorAll("input[type='checkbox'][name='" + identify[0] + identify[1] + "']");
            for (let checkbox of checkboxes) {
                if (checkbox.checked) {
                    @this.chValue = checkbox.value
                    let value = checkbox.value;
                }
            }

            @this.chQuestion = identify[0];
            @this.chOption = identify[1];

            Livewire.emit('updateOption')
        }
    </script>
@endpush
