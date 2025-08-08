@extends('voyager::master')

@section('page_title', 'Modelos de negocios | '.setting('admin.title'))

@section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li>
            <a href="{{ route('commercial.contacts-cloud') }}">
                Listado Empresas</a>
        </li>
        <li>Modelos de negocios</li>
    </ol>
@endsection

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="fa fa-folder"></i>&nbsp;Modelos de negocios
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
                            @foreach ($businessModels as $businessModel)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading panel-heading-custom">
                                            <h5 class="panel-title-custom">
                                                {{ Str::limit($businessModel->description, 26) }}
                                            </h5>
                                        </div>
                                        <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                            data-toggle="modal" data-target="#show-modal"
                                            wire:click="show({{ $businessModel->id }})">
                                            <div class="panel-body text-left" style="height:420px; padding-top:0px">
                                                <di class="row no-margin-bottom">
                                                    <div class="col-lg-12">
                                                        <li><strong>Descripción:</strong></li>
                                                        <span>&ensp;{{ $businessModel->description }}</span>
                                                        <hr style="margin:8px; padding:0px">
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <li><strong>Fuente de ingresos:</strong></li>
                                                        <p style=" text-align: justify; text-justify: inter-word;">
                                                            {{ Str::limit($businessModel->source_income, 150) }}
                                                        </p>
                                                        <hr style="margin:8px; padding:0px">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <li><strong>B2B:</strong></li>
                                                        &ensp;{{ $businessModel->b2b . ' %' }}
                                                        <hr style="margin:8px; padding:0px">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <li><strong>B2C:</strong></li>
                                                        &ensp;{{ $businessModel->b2c . ' %' }}
                                                        <hr style="margin:8px; padding:0px">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <li><strong>B2G:</strong></li>
                                                        &ensp;{{ $businessModel->b2g . ' %' }}
                                                        <hr style="margin:8px; padding:0px">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <li><strong>Ingresos:</strong></li>
                                                        &ensp;{{ $businessModel->income }}
                                                        <hr style="margin:8px; padding:0px">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <li><strong>Gastos:</strong></li>
                                                        &ensp;{{ $businessModel->bills }}
                                                        <hr style="margin:8px; padding:0px">
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <li><strong>Plan de negocios:</strong></li>
                                                        @if ($businessModel->business_plan != '')
                                                            &ensp;<a class="btn btn-success sm-b"
                                                                href="{{ url('storage/' . substr($businessModel->business_plan, 7)) }}"
                                                                target="_blank"><i
                                                                    class="fa fa-cloud-download"></i>&nbsp;Descargar</a>
                                                        @else
                                                            &ensp;No se ha cargado
                                                        @endif
                                                    </div>
                                                </di>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
