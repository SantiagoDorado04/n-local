<div>
    
    @include('livewire.admin.announcements-contatcs.modals.info')

    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard')}}"><i class="voyager-boat"></i> {{ __('voyager::generic.dashboard')
                }}</a>
        </li>
        <li><a href="{{ route('contacts.my-forms') }}">Formularios  asignados</a></li>
        <li>Convocatorias resultado</li>
    </ol>
    @endsection

    @section('page_title', 'Convocatorias Resultado | '.setting('admin.title'))

    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-megaphone"></i>&nbsp;Convocatorias Resultado
        </h1>
    </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="thwidth" width="30%"><small>Convocatoria</small></th>
                                                <th class="thwidth" width="50%"><small>Estado</small></th>
                                                <th class="thwidth" width="20%"><small>Acciones</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($announcements as $announcement)
                                            @php
                                                $announcementContact = $announcement->contacts()->where('contact_id', $contactId)->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $announcement->name }}</td>
                                                <td>
                                                    @if ($announcementContact)
                                                    <span class="label label-success">Aplicada</span>
                                                    @else
                                                    <span class="label label-warning">Sin aplicar</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($announcementContact)
                                                    @else
                                                    <button class="btn btn-success sm-b" data-toggle="modal" data-target="#info-modal" wire:click="apply({{ $announcement->id }})"><i class="fa fa-check-square"></i>&nbsp;Aplicar</button>
                                                    @endif
                                                </td>
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
    </div>
</div>