<div>
    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard')}}"><i class="voyager-boat"></i> {{ __('voyager::generic.dashboard')
                }}</a>
        </li>
        <li>Plantillas de correo</li>
    </ol>
    @endsection

    @section('page_title', 'Terrenos Comerciales | '.setting('admin.title'))

    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-mail"></i>&nbsp;Plantillas Correos electrónicos
        </h1>
        <a href="{{ route('mailing.templates.add') }}" class="btn btn-success btn-add-new">
            <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
        </a>
    </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-8">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><strong>Buscar template:</strong></label>
                                    <input type="text" class="form-control" placeholder="Título del template" wire:model='searchTitle'>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                
                                                <th width="80%"><small>Título</small></th>
                                                <th class="actions dt-not-orderable thwidth">
                                                    <small>{{ __('voyager::generic.actions') }}</small>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            @if (count($templates) > 0)
                                            @foreach ($templates as $template)
                                            <tr>
                                               <td width="80%">{{ $template->title }}</td>
                                               <td>
                                                <a href="{{ route('mailing.templates.add',['template'=>$template->id]) }}" >
                                                    <button class="btn btn-primary"><i class="fa fa-pencil-square"></i>&nbsp;Editar</button>
                                                    </a>
                                               </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <th class="text-center" colspan="11">No se encontraron
                                                    resultados</th>
                                            </tr>
                                            @endif()
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