@extends('voyager::master')

@section('page_title', 'Escala | '.setting('admin.title'))

@section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li>


        </li>
        <li>Escala</li>
    </ol>
@endsection

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="fa fa-lightbulb-o"></i>Escala - {{ $project->title }}
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
                                <label for=""><strong>Regulaciones:</strong></label>
                                <br>
                                {!! $scale->regulations !!}
                            </div>

                            <div class="col-lg-12">
                                <label for=""><strong>Mercado:</strong></label>
                            </div>
                            @php
                                $market = json_decode($scale->market);
                            @endphp

                            <div class="col-lg-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Mercado</th>
                                            <th>Territorio</th>
                                            <th>USD</th>
                                            <th>(#) Usuarios</th>
                                            <th>Segmento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>TAM</td>
                                            <td>{{ $market->tam->territory }}</td>
                                            <td>{{ $market->tam->usd }}</td>
                                            <td>{{ $market->tam->users }}</td>
                                            <td>{{ $market->tam->segment }}</td>
                                        </tr>
                                        <tr>
                                            <td>SAM</td>
                                            <td>{{ $market->sam->territory }}</td>
                                            <td>{{ $market->sam->usd }}</td>
                                            <td>{{ $market->sam->users }}</td>
                                            <td>{{ $market->sam->segment }}</td>
                                        </tr>
                                        <tr>
                                            <td>SOM</td>
                                            <td>{{ $market->som->territory }}</td>
                                            <td>{{ $market->som->usd }}</td>
                                            <td>{{ $market->som->users }}</td>
                                            <td>{{ $market->som->segment }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-lg-12">
                                <label for=""><strong>Traccion:</strong></label>
                            </div>
                            @php
                                $traction = json_decode($scale->traction);
                            @endphp

                            <div class="col-lg-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>IndicadoresKPI</th>
                                            <th>2023</th>
                                            <th>2024</th>
                                            <th>Medicion
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{--  <tr>
                                            <td>(#) Clientes</td>
                                            <td>{{ $traction[0]->last_year }}</td>
                                            <td>{{ $traction[0]->current_year }}</td>
                                            <td>{{ $traction[0]->measurement }}</td>
                                        </tr>--}}

                                        @foreach ($traction as $item)
                                            <tr>
                                                <td><small>(#) Clientes</small></td>
                                                <td>{{ $item->last_year }}</td>
                                                <td>{{ $item->current_year }}</td>
                                                <td>{{ $item->measurement }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
