@extends('voyager::master')

@section('page_title', 'Modelos de propuestas | '.setting('admin.title'))

@section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li>Modelos de propuestas</li>
    </ol>
@endsection

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="fa fa-folder"></i>&nbsp;Modelos de propuestas
        </h1>
        <a class="btn btn-success" href="{{ route('proposal.templates.create') }}">
            <i class="fa fa-cloud-upload"></i> <span>Cargar</span>
        </a>
    </div>
@stop

@section('content')
<div class="page-content browse container-fluid">
    <div class="row no-margin-bottom">
        <div class="col-md-12">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <div class="row no-margin-bottom">
                        @foreach ($templates as $template)
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading panel-heading-custom">
                                    <h5 class="panel-title-custom">
                                        {{ Str::limit($template->name, 26) }}
                                        <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                            <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                                            <ul class="dropdown-menu">
                                                <li><a data-toggle="modal" data-target="#edit-modal"
                                                        wire:click="edit({{ $template->id }})"><i
                                                            class="fa fa-pencil"></i>&nbsp;&nbsp;Editar</a></li>
                                                <li><a data-toggle="modal" data-target="#delete-modal"
                                                        wire:click="delete({{ $template->id }})"><i
                                                            class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar</a></li>
                                            </ul>
                                        </div>
                                    </h5>
                                </div>
                                <button style="background-color: #fff; border:0px; margin:0px; padding:0px" data-toggle="modal" data-target="#show-modal"
                                wire:click="show({{ $template->id }})">
                                <div class="panel-body" style="height:120px">
                                    <p style="  text-align: justify;
                                    text-justify: inter-word;">{{ Str::limit($template->description, 150) }}</p>
                                </div>
                                </button>
                                <div class="panel-footer">
                                    <div class="pull-right">
                                        <a class="btn btn-success"
                                            href="{{ asset( $template->url_file ) }}" target="_blank"><i class="fa fa-cloud-download"></i>&nbsp;Descargar</a>
                                    </div>
                                    <div class="clearfix">
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
@endsection