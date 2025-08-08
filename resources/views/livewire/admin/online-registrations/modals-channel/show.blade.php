<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="voyager-list"></i>&nbsp;Detalles del control de registro
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <table class="table table-striped">
                            <tr>
                                <th>
                                    <li>Nombre:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $name }}</td>
                            </tr>

                            <tr>
                                <th>
                                    <li>Url:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $url }}</td>
                            </tr>

                            {{-- Mostrar HEADERS dinámicamente --}}
                            <tr>
                                <th colspan="2">
                                    <div class="panel-group" id="accordion2">
                                        <a data-toggle="collapse" data-parent="#accordion2" href="#collapse3"
                                            style="text-decoration:none">
                                            <div class="panel-heading panel-heading-custom" id="heading2"
                                                style="padding: 4px">
                                                <p style="padding: 5px; margin-bottom:0px"><strong>Headers:</strong></p>
                                            </div>
                                        </a>
                                        <div id="collapse3" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <ul class="list-group list-group-flush">
                                                    @if (!empty($structure['headers']) && is_array($structure['headers']))
                                                        @foreach ($structure['headers'] as $key => $value)
                                                            <li>
                                                                <strong>{{ ucfirst($key) }}:</strong>
                                                                {{ is_array($value) ? json_encode($value) : ($value !== '' ? $value : 'N/A') }}
                                                            </li>
                                                        @endforeach
                                                    @else
                                                        <li>No hay información en los headers.</li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                            </tr>

                            {{-- Mostrar BODY dinámicamente --}}
                            <tr>
                                <th colspan="2">
                                    <div class="panel-group" id="accordion1">
                                        <a data-toggle="collapse" data-parent="#accordion1" href="#collapse2"
                                            style="text-decoration:none">
                                            <div class="panel-heading panel-heading-custom" id="heading1"
                                                style="padding: 4px">
                                                <p style="padding: 5px; margin-bottom:0px"><strong>Body:</strong></p>
                                            </div>
                                        </a>
                                        <div id="collapse2" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <ul class="list-group list-group-flush">
                                                    @if (!empty($structure['body']) && is_array($structure['body']))
                                                        @foreach ($structure['body'] as $key => $value)
                                                            <li>
                                                                <strong>{{ ucfirst($key) }}:</strong>
                                                                @if (is_array($value))
                                                                    <ul>
                                                                        @foreach ($value as $item)
                                                                            <li>{{ is_array($item) ? json_encode($item) : $item }}
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @else
                                                                    {{ $value !== '' ? $value : 'N/A' }}
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    @else
                                                        <li>No hay información en el body.</li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                            </tr>


                            <tr>
                                <th>
                                    <li>Creado por el usuario:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $user_created_at }}</td>
                            </tr>
                            <tr>
                                <th>
                                    <li>Ultimo usuario en modificar:</li>
                                </th>
                            </tr>
                            <tr>
                                <td>{{ $user_updated_at ?? 'Sin modificación' }}</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i
                        class="fa fa-close"></i>&nbsp;{{ __('voyager::generic.close') }}</button>
            </div>
        </div>
    </div>
</div>
