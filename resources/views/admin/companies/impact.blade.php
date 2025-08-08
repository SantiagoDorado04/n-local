@extends('voyager::master')

@section('page_title', 'Impacto | '.setting('admin.title'))

@section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li>


        </li>
        <li>Impacto</li>
    </ol>
@endsection

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="fa fa-lightbulb-o"></i>Impacto - {{ $project->title }}
        </h1>
    </div>
@stop
@section('content')
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-8">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">

                                <div class="col-lg-12">
                                    <label for=""><strong>Impacto:</strong></label>
                                </div>

                                @php
                                    $metric = json_decode($impact->metrics);
                                @endphp

                                <div class="col-lg-12">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><small>Impacto</th>
                                                <th><small>2023</th>
                                                <th><small>2024</th>
                                                <th><small>Medicion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($metric as $item)
                                                <tr>
                                                    <td><small>(Ton CO2) Emisiones evitadas</td>
                                                    <td>{{ $item->last_year }}</td>
                                                    <td>{{ $item->current_year }}</td>
                                                    <td>{{ $item->measurement }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-lg-12">
                                    <label for=""><strong>Técnica recolección de datos:</strong></label>
                                    <br>
                                    {!! $impact->data_collection !!}
                                </div>


                                <div class="col-lg-12">
                                    <br>
                                    <label for=""><strong>Adjuntos:</strong></label>
                                    @php
                                        $attachments = $impact->attachments;
                                    @endphp

                                    <div class="panel-body">
                                        <div class="row no-margin-bottom">
                                            <div class="col-lg-12">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th width="80%">
                                                                <small>Archivo</small>
                                                            </th>
                                                            <th width="20%">
                                                                <small>Acciones</small>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (count($attachments) > 0)
                                                            @if ($attachments != [])
                                                                @if ($attachments != '')
                                                                    @foreach ($attachments as $attachment)
                                                                        <tr>
                                                                            <td><strong>{{ $attachment->name }}</strong>
                                                                            </td>
                                                                            <td>
                                                                                <a class="btn btn-success sm-b"
                                                                                    href="{{ url('storage/' . substr($attachment->url, 7)) }}"
                                                                                    target="_blank"><i
                                                                                        class="fa fa-cloud-download"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        @else
                                                            <tr>
                                                                <td colspan="2">
                                                                    <strong>Sin Adjuntos</strong>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
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
    </div>
@endsection
