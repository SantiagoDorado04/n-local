<div>
    @include('livewire.admin.proposals.modals-answers.create')
    @include('livewire.admin.proposals.modals-answers.show')

    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>Gestión de propuestas</li>
        </ol>
    @endsection

    @section('page_title', 'Gestión de propuestas | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-briefcase"></i>&nbsp;Gestión de propuestas
            </h1>
        </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12" style="margin-bottom:0px">
                <div class="panel panel-bordered" style="margin-bottom:10px">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-4">
                                <label><strong>Buscar Empresa / Contacto:</strong></label>
                                <select class="form-control" wire:model="searchContact">
                                    <option value="">Seleccionar</option>
                                    @foreach ($contacts as $contact)
                                        <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
                            <div class="col-lg-4">Nueva propuesta:</strong></label>
                                <select class="form-control" wire:model="templateId">
                                    <option value="">Seleccionar</option>
                                    @foreach ($templates as $template)
                                        <option value="{{ $template->id }}">{{ $template->name }}</option>
                                    @endforeach
                                </select>
                                @error('templateId')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-4">
                                <label><strong>Empresa / Contacto:</strong></label>
                                <select class="form-control" wire:model="contactId">
                                    <option value="">Seleccionar</option>
                                    @foreach ($contacts as $contact)
                                        <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                                    @endforeach
                                </select>
                                @error('contactId')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-4" style="padding-top: 22px">
                                <button class="btn btn-success" wire:click="add"><i
                                        class="fa fa-plus-square"></i>&nbsp;Agregar</button>
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Empresa / Contacto</th>
                                            <th>Propuesta</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($proposals as $proposal)
                                            <tr>
                                                <th><strong>{{ $proposal->contact->name }}</strong></th>
                                                <td>{{ $proposal->proposal->name }}</th>
                                                <td>
                                                    <button class="btn btn-success sm-b"
                                                        wire:click="getProposalContact({{ $proposal->id }})"
                                                        data-toggle="modal" data-target="#create-modal">
                                                        <i class="fa fa-cogs"></i>&nbsp;Nueva versión
                                                    </button>
                                                    <button class="btn btn-primary sm-b"
                                                        onclick="mostrarHijos({{ $proposal->id }})"><i class="fa fa-cogs"></i>&nbsp;Versiones</button>
                                                </td>
                                            </tr>
                                            
                                                @php
                                                $answersP= [];
                                                    $proposal = App\ContactsProposal::find($proposal->id);
                                                    if ($proposal!='') {
                                                        $data= json_decode($proposal->answers, true);
                                                        if (!empty($data) && isset($data['answers'])) {
                                                            $answersP=$data['answers'];
                                                        }
                                                    }
                                                @endphp
                                                @if ($answersP!=[])
                                                    @foreach ($answersP as $key => $value)
                                                    <tr class="hijos-{{ $proposal->id }}" style="display: none;" wire:ignore>
                                                        <th></th>
                                                        <td><span class="label label-success">Versión {{ $loop->iteration }}</span></td>
                                                        <td>
                                                            <button class="btn btn-primary sm-b"
                                                                wire:click="getAnswers([{{ $proposal->id }},{{ $key }}])"
                                                                data-toggle="modal" data-target="#show-modal">
                                                                <i class="fa fa-check-square-o"></i>&nbsp;Respuestas
                                                            </button>
                                                            <button class="btn btn-success sm-b"
                                                                wire:click="generate([{{ $proposal->id }},{{ $key  }}])">
                                                                <i class="fa fa-cloud-download"></i>&nbsp;Descargar
                                                            </button>
                                                            <button class="btn btn-warning sm-b"
                                                                wire:click="send([{{ $proposal->id }},{{ $key  }}])">
                                                                <i class="fa fa-paper-plane"></i>&nbsp;Enviar
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                <tr class="hijos-{{ $proposal->id }}" style="display: none;" wire:ignore>
                                                    <th colspan="3" class="text-center">Sin versiones</th>
                                                </tr>
                                                @endif
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

    <script>
        function mostrarHijos(idPadre) {
            var hijos = $('.hijos-' + idPadre);
            if (hijos.is(":visible")) {
                hijos.hide();
            } else {
                hijos.show();
            }
        }
    </script>
</div>
