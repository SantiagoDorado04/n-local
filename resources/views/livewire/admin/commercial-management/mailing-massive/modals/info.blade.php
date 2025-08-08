<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="info-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}" wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-link"></i>&nbsp;Clicks en elnaces
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        @if($details!=[])
                            @if ($details->links!='')
                                @php
                                    $links=json_decode($details->links);
                                @endphp
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="thwidth"><small>Estado</small></th>
                                            <th class="thwidth"><small>Título</small></th>
                                            <th class="thwidth"><small>Enlace</small></th>
                                            <th class="thwidth"><small>Fecha click</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($links as $link)
                                        <tr>
                                        <td class="thwidth">
                                            @if ($link->date_click!='')
                                            <span class="label label-success">
                                                Leido
                                            </span>
                                            @else
                                            <span class="label label-warning">
                                                Sin Leer
                                            </span>
                                            @endif
                                        </td>
                                            <td class="thwidth">{{ $link->title }}</td>
                                            <td class="thwidth">{{ $link->url}}</td>
                                            <td class="thwidth">{{ $link->date_click}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()">{{ __('voyager::generic.close') }}</button>
            </div>
        </div>
    </div>
</div>