<div>
    <style>
        input[type=file] {
            display: block;
            margin-top: 0px;
            padding-top: 0px
        }
    </style>
    @include('livewire.admin.profile.modals.delete')
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>Mi empresa</li>
        </ol>
    @endsection

    @section('page_title', 'Mi Empresa | '.setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-company"></i>&nbsp;Mi Empresa
            </h1>
        </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-md-12">
                                <div class="panel panel-bordered">
                                    <div class="panel-heading" style="padding-left:20px">
                                        <h5>Información de la empresa</h5>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row no-margin-bottom">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="is-required"><strong>NIT / Cédula:</strong></label>
                                                    <input type="number" class="form-control" min="0" wire:model="nit" >
                                                    @error('nit')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="is-required"><strong>Razón social:</strong></label>
                                                    <input type="text" class="form-control" wire:model="name">
                                                    @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="is-required"><strong>Sector primario:</strong></label>
                                                    <select class="form-control" wire:model="main_sector">
                                                        <option value="">-Seleccionar-</option>
                                                        @if ($sectors!=[])
                                                            @foreach ($sectors as $sector)
                                                                <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @error('main_sector')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row no-margin-bottom">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label><strong>Sector secundario:</strong></label>
                                                    <select class="form-control" wire:model="secondary_sector">
                                                        <option value="">-Seleccionar-</option>
                                                        @if ($sectors!=[])
                                                            @foreach ($sectors as $sector)
                                                                <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @error('secondary_sector')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="is-required"><strong>Tipo de empresa:</strong></label>
                                                    <select class="form-control" wire:model="company_type_id">
                                                        <option value="">-Seleccionar-</option>
                                                        @if ($companyTypes!=[])
                                                            @foreach ($companyTypes as $type)
                                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @error('company_type_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="is-required"><strong>Dirección:</strong></label>
                                                    <input type="text" class="form-control" wire:model="address">
                                                    @error('address')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row no-margin-bottom">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="is-required"><strong>Teléfono:</strong></label>
                                                    <input type="tel" class="form-control" wire:model="phone">
                                                    @error('phone')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label><strong>WhatsApp:</strong></label>
                                                    <input type="tel" class="form-control" wire:model="whatsapp">
                                                    @error('whatsapp')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="is-required"><strong>Correo electrónico:</strong></label>
                                                    <input type="email" class="form-control" wire:model="email">
                                                    @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row no-margin-bottom">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label><strong>Página Web:</strong></label>
                                                    <input type="text" class="form-control" wire:model="website">
                                                    @error('website')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="is-required"><strong>Nombre persona de contacto:</strong></label>
                                                    <input type="text" class="form-control" wire:model="contact_person_name">
                                                    @error('contact_person_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="is-required"><strong>Correo persona de contacto:</strong></label>
                                                    <input type="email" class="form-control" wire:model="contact_person_email">
                                                    @error('contact_person_email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-md-12">
                                <div class="panel panel-bordered">
                                    <div class="panel-heading" style="padding-left:20px">
                                        <h5>Información líder de la empresa</h5>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row no-margin-bottom">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="is-required"><strong>Nombre líder del proyecto:</strong></label>
                                                    <input type="text" class="form-control" wire:model="leader_name">
                                                    @error('leader_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="is-required"><strong>Cargo líder del proyecto:</strong></label>
                                                    <select class="form-control" wire:model="leader_position">
                                                        <option value="">-Seleccionar-</option>
                                                        @if ($charges!=[])
                                                            @foreach ($charges as $charge)
                                                                <option value="{{ $charge->id }}">{{ $charge->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @error('leader_position')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="is-required"><strong>Género líder del proyecto:</strong></label>
                                                    <div class="form-group">
                                                        <label class="radio-inline">
                                                            <input wire:model="leader_gender" value="m" type="radio">
                                                            Masculino</label>
                                                        <label class="radio-inline">
                                                            <input wire:model="leader_gender" value="f" type="radio">
                                                            Femenino</label>
                                                        <label class="radio-inline">
                                                            <input wire:model="leader_gender" value="o" type="radio">
                                                            Otro</label>
                                                    </div>
                                                    @error('leader_gender')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row no-margin-bottom">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="is-required"><strong>Edad líder del proyecto:</strong></label>
                                                    <input type="number" class="form-control" min="1" wire:model="leader_age">
                                                    @error('leader_age')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="is-required"><strong>Correo electrónico líder del proyecto:</strong></label>
                                                    <input type="email" class="form-control" wire:model="leader_email">
                                                    @error('leader_email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="is-required"><strong>Teléfono líder del proyecto:</strong></label>
                                                    <input type="tel" class="form-control" wire:model="leader_phone">
                                                    @error('leader_phone')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row no-margin-bottom">
                            <div class="col-lg-12 text-center">
                                <button class="btn btn-success sm-b" wire:click='update()'><i class="fa fa-floppy-o"></i>&nbsp;Actualizar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
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
                                                En esta sección carge los archivos como:
                                                <ul>
                                                    <li>Certificado de existencia representacion legal</li>
                                                    <li>Estados financieros</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row no-margin-bottom">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="is-required"><strong>Nombre del adjunto:</strong></label>
                                                    <input type="text" class="form-control" wire:model="attachment_name">
                                                    @error('attachment_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="is-required"><strong>Seleccione el adjunto:</strong></label>
                                                    <input type="file" id="exampleInputFile" wire:model="attachment" accept="application/pdf">
                                                    @error('attachment')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4" style="padding-top:22px">
                                                <button class="btn btn-success" wire:click="upload()"><i class="fa fa-upload"></i>&nbsp;Subir</button>
                                            </div>
                                        </div>
                                        <div class="row no-margin-bottom">
                                            <div class="col-lg-12">

                                                <table class="table table-bordered">
                                                    @foreach ($company->attachments as $attachment)
                                                    <tr>
                                                        <td width="60%">{{ $attachment->name }}</td>
                                                        <td width="20%"class="no-sort no-click bread-actions">
                                                            <a class="btn btn-success sm-b" target="_blank"
                                                            href="{{ url('storage/'.substr($attachment->url,7)) }}"
                                                            style="text-decoration:none;">
                                                                <i class="fa fa-download"></i
                                                                    >&nbsp;Descargar
                                                                </a>
                                                            <button class="btn btn-danger sm-b" data-toggle="modal" data-target="#delete-modal"
                                                                wire:click="delete({{ $attachment->id }})">
                                                                <i class="fa fa-trash"></i>
                                                                &nbsp;Eliminar
                                                            </button>

                                                        </td>
                                                    </tr>
                                                    @endforeach
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
</div>
