@extends('voyager::master')

@section('page_title', 'Productos y Servicios | '.setting('admin.title'))

@section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li>Productos y servicios</li>
    </ol>
@endsection

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="fa fa-folder"></i>&nbsp;Productos y Servicios
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
                            <div class="col-lg-12">
                                <div class="row no-margin-bottom">
                                    @if (count($productsServices) > 0)
                                        @foreach ($productsServices as $productService)
                                            <div class="col-lg-12">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading panel-heading-custom">
                                                        <h5 class="panel-title-custom">
                                                            {{ Str::limit($productService->description, 26) }}
                                                        </h5>
                                                    </div>
                                                    <button
                                                        style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                                        data-toggle="modal" data-target="#show-modal"
                                                        wire:click="show({{ $productService->id }})">
                                                        <div class="panel-body text-left">
                                                            <li><strong>Descripción:</strong></li>
                                                            <span>&ensp;{{ $productService->description }}</span>
                                                            <li><strong>Clientes / beneficiarios actuales y
                                                                    proyecciones:</strong></li>
                                                            <p
                                                                style="  text-align: justify;
                                                text-justify: inter-word;">
                                                                {{ Str::limit($productService->beneficiaries, 150) }}</p>
                                                            <li><strong>Nivel de desarrollo:</strong></li>
                                                            &ensp;{{ $productService->developmentLevel->name }}
                                                            <li><strong>Adjuntos:</strong></li>


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
                                                                                @if (count($productService->files) > 0)
                                                                                    @if ($productService != [])
                                                                                        @if ($productService->files != '')
                                                                                            @foreach ($productService->files as $file)
                                                                                                <tr>
                                                                                                    <td><strong>{{ $file->name }}</strong>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <a class="btn btn-success sm-b"
                                                                                                            href="{{ url('storage/' . substr($file->url, 7)) }}"
                                                                                                            target="_blank"><i
                                                                                                                class="fa fa-cloud-download"></i></a>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endforeach
                                                                                        @endif
                                                                                    @else
                                                                                        <tr>
                                                                                            <td colspan="2"><strong>Sin
                                                                                                    Adjuntos</strong></td>
                                                                                        </tr>
                                                                                    @endif
                                                                                @endif
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="panel-body">
                                            <div class="row no-margin-bottom">
                                                <div class="col-lg-12">
                                                    <h4><strong>Sin Registros de Productos o servicios<strong></h4>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
