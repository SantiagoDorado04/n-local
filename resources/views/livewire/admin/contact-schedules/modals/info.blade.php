<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="info-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}" wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-address-card-o"></i>&nbsp;Información del contacto
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <table class="table table-striped">
                            @if ($contact!='')
                            <tr>
                                <th>- NIT:</th>
                            </tr>
                            <tr>
                                <td>{{ $contact->nit }}</td>
                            </tr>
                            <tr>
                                <th>- Nombre:</th>
                            </tr>
                            <tr>
                                <td>{{ $contact->name }}</td>
                            </tr>
                            <tr>
                                <th>- Correo electrónico:</th>
                            </tr>
                            <tr>
                                <td>{{ $contact->email }} &nbsp;&nbsp;&nbsp;<a href="mailto:{{ $contact->email }}"><i class="fa fa-envelope-square"></i></a></td>
                            </tr>
                            <tr>
                                <th>- Teléfono:</th>
                            </tr>
                            <tr>
                                <td>{{ $contact->phone }} &nbsp;&nbsp;&nbsp;<a href="tel:{{ $contact->email }}"><i class="fa fa-phone-square"></i></a></td>
                            </tr>
                            <tr>
                                <th>- WhatsApp:</th>
                            </tr>
                            <tr>
                                @if ($contact->whatsapp!='')
                                <td>{{ $contact->whatsapp }} &nbsp;&nbsp;&nbsp;<a href="https://api.whatsapp.com/send?phone=+57{{ $contact->whatsapp }}"><i class="fa fa-whatsapp"></i></a></td>
                                @else
                                <td>-</td>
                                @endif
                                
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()">{{ __('voyager::generic.close') }}</button>
            </div>
        </div>
    </div>
</div>