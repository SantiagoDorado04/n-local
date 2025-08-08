@extends('voyager::master')

@section('page_title', 'Respuestas formulario | '.setting('admin.title'))

@section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li>
            <a href="{{ route('commercial.contacts-cloud') }}">
                Listado Empresas
            </a>
        </li>
        <li>
            <a href="{{ route('companies.assigned-forms', ['id' => $company->id]) }}">
                Formularios asignados
            </a>
        </li>
        <li>Respuestas Formulario</li>
    </ol>
@endsection

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="fa fa-folder"></i>&nbsp;Respuestas Formulario
        </h1>
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin-bottom:0px">
                    <div class="panel-body" style="margin-bottom:0px">
                        <ul>
                            <li><strong>Empresa: </strong> {{ $company->name }}<br></li>
                            <li><strong>Formulario: </strong> {{ $form->name }}<br></li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row no-margin-bottom">
        <div class="col-md-12">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <div class="row no-margin-bottom">
                        <div class="col-md-12">
                            <h5 class="text-center">{{ $form ? $form->name : '' }}</h5>
                        </div>
                        <div class="col-md-12">
                            <p>{{ $form ? $form->description : '' }}</p>
                        </div>
                        @if ($result)
                            @foreach ($form->questions as $question)
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
                                                        @foreach ($question->options as $option)
                                                            @php
                                                                $find = false;
                                                            @endphp
                                                            @if ($option->commercial_form_question_id == $question->id)
                                                                <input type="radio"
                                                                    {{ $option->value == $result[0]->{'question_' . $question->id} ? 'checked' : '' }}
                                                                    disabled>
                                                                <label for="html">
                                                                    <span
                                                                        {{ $option->value == $result[0]->{'question_' . $question->id} ? 'style=background-color:rgb(180, 255, 196)' : '' }}>
                                                                        {{ $option->option }}
                                                                    </span>
                                                                </label><br>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <br>
                                                        <br>
                                                        <textarea class="form-control" disabled>{{ $result[0]->{'question_' . $question->id} }}</textarea>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
