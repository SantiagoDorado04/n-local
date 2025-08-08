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
        <i class="fa fa-folder"></i>&nbsp;Nuevo modelo de propuesta
    </h1>
</div>
@stop

@section('content')
<div class="page-content browse container-fluid">
    <div class="row no-margin-bottom">
        <div class="col-md-12">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <div class="row no-margin-bottom">
                        <form action="{{ route('proposal.templates.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label><strong>Nombre de la platilla:</strong></label>
                                    <input type="text" class="form-control" name="name" autocomplete="off"> 
                                        @error('name')
                                            <span class=" text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label><strong>Descripción de la platilla:</strong></label>
                                    <textarea class="form-control" rows="4" name="description" autocomplete="off"></textarea>
                                        @error('description')
                                            <span class=" text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label><strong>Archivo DOCX:</strong></label>
                                    <input type="file" class="form-control" name="file" autocomplete="off">
                                        @error('file')
                                            <span class=" text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <button type="submit" class="btn btn-success"><i
                                        class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection