@extends('voyager::master')

@section('page_title', 'Detalles empresa | '.setting('admin.title'))

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
        <li>Detalles empresa</li>
    </ol>
@endsection

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="fa fa-folder"></i>&nbsp;Detalles empresa
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
                    <div class="panel-heading">
                        <div class="row no-margin-bottom">
                            <div class="col-md-12" style="padding-left:35px; padding-top:20px">
                                <h5>Informacion General</h5>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-md-12">
                                <div class="row no-margin-bottom">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong>NIT / Cédula:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->nit }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Nombre:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Sector Primario:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->mainSector ? $company->mainSector->name  : 'No Registrado' }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row no-margin-bottom">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Sector Secundario:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->secondarySector ? $company->secondarySector->name : 'No Registrado' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Tipo de Empresa:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->companyType ? $company->companyType->name : '' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Direccion:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->address }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row no-margin-bottom">
                                    {{-- <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Ciudad:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->city_id ? $company->city_id->name : 'No registra' }}"
                                                readonly>
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Calificacion:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->rate }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Telefono:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->phone }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Correo Electronico:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->email }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row no-margin-bottom">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> WhatsApp:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->whatsapp }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Pagina Web:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->website }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Nombre persona de contacto:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->contact_person_name }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row no-margin-bottom">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Correo persona de contacto:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->contact_person_email }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Nombre lider del proyecto:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->leader_name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Cargo lider del proyecto:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->leaderPosition ? $company->leaderPosition->name : 'No registrado' }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row no-margin-bottom">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Correo electronico lider del
                                                    proyecto:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->leader_email }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Telefono lider del proyecto:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->leader_phone }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Genero lider del proyecto:</strong></label>
                                            @php
                                                $gender = '';
                                            @endphp
                                            @switch($company->leader_gender)
                                                @case('m')
                                                    {{ $gender = 'Masculino' }}
                                                @break

                                                @case('f')
                                                    {{ $gender = 'Femenino' }}
                                                @break

                                                @case('o')
                                                    {{ $gender = 'Otro' }}
                                                @break

                                                @default
                                                    {{ $gender = 'Sin registrar' }}
                                            @endswitch
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $gender }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row no-margin-bottom">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Edad lider del proyecto:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->leader_age }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Medio de almacenamiento:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->storage }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Creado por:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->user->name }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row no-margin-bottom">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Formulario comercial:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->commercialForm ? $company->commercialForm->name : 'No registra' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Accion comercial:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->commercialAction ? $company->commercialAction->name : 'No registra' }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for=""><strong> Fecha de creacion:</strong></label>
                                            <input type="text" class="form-control" style="background-color:white"
                                                value="{{ $company->created_at }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row no-margin-bottom">
                                </div>
                                {{-- <div class="panel-footer">
                                    <div class="pull-right">
                                        <button class="btn btn-primary"  data-toggle="modal" data-target="#edit-modal-2" wire:click='files({{ $product->id }})'><i class="fa fa-cloud-upload"></i>&nbsp;Adjuntos</button>
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                </div> --}}
                                {{-- @if ($company->attachments)
                                @foreach ($company->attachments as $attachment)
                                    <a href="{{ url('storage/'.substr($attachment->url,7)) }}" target="_blank">Descargar {{ $attachment->name }}</a>

                                @endforeach

                                @endif --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12" style="margin-left: 5px">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-md-12">
                                <div class="panel panel-bordered">
                                    <div class="panel-heading" style="padding-left:20px">
                                        <h5>Archivos adjuntos</h5>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row no-margin-bottom">
                                            <div class="col-lg-12">
                                                <table class="table table-bordered">
                                                    @if (count($company->attachments) > 0)
                                                        @foreach ($company->attachments as $attachment)
                                                            <tr>
                                                                <td width="60%">{{ $attachment->name }}</td>
                                                                <td width="20%"class="no-sort no-click bread-actions">
                                                                    <a class="btn btn-success sm-b"
                                                                        href="{{ url('storage/' . substr($attachment->url, 7)) }}"
                                                                        style="text-decoration:none;">
                                                                        <i class="fa fa-download"></i>&nbsp;Descargar
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <h5>Sin Adjuntos</h5>
                                                        </tr>
                                                    @endif
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
