<style>
    .video-container {
        position: relative;
        width: 100%;
        padding-bottom: 56.25%; /* Proporción de aspecto 16:9 (dividir la altura por el ancho y multiplicar por 100) */
    }

    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>

<div wire:ignore.self class="modal modal-primary fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
    id="show-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-pencil-square"></i>&nbsp;Tutorial
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <table class="table table-bordered">
                            <tr>
                                <th class="text-center">Tutorial "{{ $tutorial->title ?? '' }}"</th>
                            </tr>
                            
                            <tr>
                                <th>Título:</th>
                            </tr>
                            <tr>
                                <td>{{ $tutorial->title ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Descripción:</th>
                            </tr>
                            <tr>
                                <td>{!! $tutorial->description ?? '' !!}</td>
                            </tr>
                            <tr>
                                <th>Categoría:</th>
                            </tr>
                            <tr>
                                <td>{{ $tutorial->category->title ?? ''}}</td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <div class="video-container">
                                        {!! $tutorial->embed ?? '' !!}
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()"><i class="fa fa-ban"></i>
                    &nbsp;{{ __('voyager::generic.close') }}
                </button>
            </div>
        </div>
    </div>
</div>