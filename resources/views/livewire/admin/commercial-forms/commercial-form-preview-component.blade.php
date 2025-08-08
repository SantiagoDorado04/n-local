<div>
    @include('livewire.admin.commercial-forms.modals-questions.create')
    @include('livewire.admin.commercial-forms.modals-questions.edit')
    @include('livewire.admin.commercial-forms.modals-questions.delete')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('commercial.forms', ['form' => $form->id]) }}">Formularios</a>
            </li>
            <li>Demo</li>
        </ol>
    @endsection

    @section('page_title', 'Demo Formulario | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-browser"></i> Demo Formulario
            </h1>
        </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin: 0px">
                    <div class="panel-body" style="margin: 0px">
                        <ul>
                            <li><strong>Formulario: </strong> {{ $form->name }}<br></li>
                        </ul>
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
                            <div class="col-md-12">
                                <h5 class="text-center">{{ $form->name }}</h5>
                            </div>
                            <div class="col-md-12">
                                <p>{{ $form->description }}</p>
                            </div>
                            @foreach ($questions as $question)
                            <div class="col-md-12">
                                <div class="panel panel-bordered">
                                    <div class="panel-body">
                                        <div class="row no-margin-bottom">
                                            <div class="col-md-1">
                                                <strong>{{ $loop->iteration.'. ' }}</strong>
                                            </div>
                                            <div class="col-md-11">
                                                {!! nl2br($question->question) !!}
                                                @if ($question->type=='po')
                                                <br>
                                                <br>
                                                    @foreach ($options as $option)
                                                        @if($option->commercial_form_question_id==$question->id)
                                                        <input type="radio" id="html" name="fav_language" value="HTML">
                                                        <label for="html">{{ $option->option }}</label><br>
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
