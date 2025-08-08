@extends('voyager::master')

@section('page_title', 'Innovacion | '.setting('admin.title'))

@section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li>


        </li>
        <li>Innovación</li>
    </ol>
@endsection

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="fa fa-lightbulb-o"></i>Innovación - {{ $project->title }}
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
                                <div class="panel-body">
                                    <div class="row no-margin-bottom">
                                        <div class="col-md-12">
                                            <div class="row no-margin-bottom">

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for=""><strong>Titulo:</strong></label>
                                                        <input type="text" class="form-control"
                                                            style="background-color:white" value="{{ $innovation->title }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for=""><strong>Descripcion:</strong></label>
                                                        <input type="text" class="form-control"
                                                            style="background-color:white"
                                                            value="{{ $innovation->description }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for=""><strong>Tecnologia:</strong></label>
                                                        <input type="text" class="form-control"
                                                            style="background-color:white"
                                                            value="{{ $innovation->technologies ? $innovation->technologies->name : '' }}"
                                                            readonly>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <label for=""><strong>Caracteristicas Técnicas:</strong></label>
                                                </div>

                                                @php
                                                    $tech = json_decode($innovation->technical_features);
                                                @endphp

                                                @if (is_array($tech))
                                                    @if (count($tech) > 0)
                                                        @foreach ($tech as $item)
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        style="background-color:white"
                                                                        value="{{ $item }}" readonly>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <h5>No registradas</h5>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif

                                                <div class="col-lg-12">
                                                    <label for=""><strong>Caracteristicas
                                                            Comerciales:</strong></label>
                                                </div>

                                                @php
                                                    $tech = json_decode($innovation->commercial_features);
                                                @endphp

                                                @if (is_array($tech))
                                                    @if (count($tech) > 0)
                                                        @foreach ($tech as $item)
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        style="background-color:white"
                                                                        value="{{ $item }}" readonly>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <h5>No registradas</h5>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif

                                                <div class="col-lg-12">
                                                    <label for=""><strong>Evaluacion Comparativa:</strong></label>
                                                    <br>
                                                        {!!  $innovation->benchmarking !!}
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
    </div>
@endsection
