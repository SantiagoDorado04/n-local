<style>
    * {
        margin: 0;
        padding: 0;
    }

    .rate:not(:checked)>input {
        position: absolute;
        top: -9999px;
    }

    .rate:not(:checked)>label {
        float: right;
        width: 1em;
        overflow: hidden;
        white-space: nowrap;
        cursor: pointer;
        font-size: 30px;
        color: #ccc;
    }

    .rate:not(:checked)>label:before {
        content: '★ ';
    }

    .rate>input:checked~label {
        color: #ffc700;
    }

    .rate:not(:checked)>label:hover,
    .rate:not(:checked)>label:hover~label {
        color: #ffc700;
    }

    .rate>input:checked+label:hover,
    .rate>input:checked+label:hover~label,
    .rate>input:checked~label:hover,
    .rate>input:checked~label:hover~label,
    .rate>label:hover~input:checked~label {
        color: #ffc700;
    }
</style>

<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="info-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="{{ __('voyager::generic.close') }}"
                    wire:click="cancel()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <i class="fa fa-plus-square"></i>
                    Calificación de oportunidad de contacto
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom ">
                    <div class="col-lg-12">
                        <label>Califique la oportunidad de contacto de acuerdo al número de estrellas, <b>5</b> estrella <b>mayor calificación</b>, <b>1</b> estrellas <b>menor calificación</b></label>
                    </div>
                    <div class="col-lg-4 text-center">
                    </div>
                    <div class="col-lg-4 text-center">
                        <div class="rate" style="text-align: center; ">
                            <input type="radio" id="star5" name="rate" wire:model="rate" value="5" />
                            <label for="star5" title="text"></label>
                            <input type="radio" id="star4" name="rate" wire:model="rate" value="4" />
                            <label for="star4" title="text"></label>
                            <input type="radio" id="star3" name="rate" wire:model="rate" value="3" />
                            <label for="star3" title="text"></label>
                            <input type="radio" id="star2" name="rate" wire:model="rate" value="2" />
                            <label for="star2" title="text"></label>
                            <input type="radio" id="star1" name="rate" wire:model="rate" value="1" />
                            <label for="star1" title="text"></label>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary pull-right" wire:click="storeRate()"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                <button type="button" class="btn btn-default pull-right"
                    wire:click="cancel()"><i class="fa fa-ban"></i>&nbsp;{{ __('voyager::generic.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
