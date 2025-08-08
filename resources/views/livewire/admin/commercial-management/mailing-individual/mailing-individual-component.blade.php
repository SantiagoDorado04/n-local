<div>
    <div wire:loading wire:target="send">
        @include('partials.loader')
    </div>

    <div wire:loading wire:target="draft">
        @include('partials.loader')
    </div>

    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li><a href="{{ route('mailing.individual.outbox') }}">Bandeja de salida individual</a></li>
        <li>Mailing Individual</li>
    </ol>
    @endsection

    @section('page_title', 'Mailing Individual | '.setting('admin.title'))

    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-person"></i>&nbsp;Mailing Individual
        </h1>
    </div>
    @stop
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="row no-margin-bottom">
                                    <div class="col-lg-12">
                                        <label>Contacto: </label>
                                        <select class="form-control" wire:model="contactId">
                                            <option value="">Seleccionar</option>
                                            @foreach ($contacts as $contact)
                                            <option value="{{ $contact->id }}">
                                                {{ $contact->name . ' ('. $contact->email.')' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-12">
                                        <label>Destinatario: </label>
                                        <input type="text" class="form-control" wire:model='to'
                                            placeholder="Correo electrónico">
                                        @error('to')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12">
                                        <label for="">CC: <small>(ENTER para agregar las direcciones de correo
                                                electrónico)</small></label>
                                        <div class="col-sm-12 email-id-row" style="margin-top:0px">
                                            <div class="all-mail">
                                                @foreach ($cc as $item)
                                                <span class="email-ids">{{ $item }}<span
                                                        class="cancel-email cancel-cc">x</span></span>
                                                @endforeach
                                            </div>
                                            <input type="email" class="enter-cc" name="cc" id="cc" autocomplete="off"
                                                readonly onfocus="this.removeAttribute('readonly');" />
                                            @if ($errorMsjCc != '')
                                            <span class="text-danger">{{ $errorMsjCc }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <label for="">CCO: <small>(ENTER para agregar las direcciones de correo
                                                electrónico)</small></label>
                                        <div class="col-sm-12 email-id-row" style="margin-top:0px">
                                            <div class="all-mail">
                                                @foreach ($cco as $item)
                                                <span class="email-ids">{{ $item }}<span
                                                        class="cancel-email cancel-cco">x</span></span>
                                                @endforeach
                                            </div>
                                            <input type="email" class="enter-cco" name="cco" id="cco" autocomplete="off"
                                                readonly onfocus="this.removeAttribute('readonly');" />
                                            @if ($errorMsjCco != '')
                                            <span class="text-danger">{{ $errorMsjCco }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="to-input">Asunto:</label>
                                        <input type="text" class="form-control" wire:model="subject">
                                        @error('subject')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-12">
                                        <label>Plantilla:</label>
                                        <select class="form-control" wire:model="template">
                                            <option value="">Seleccionar</option>
                                            @foreach ($templates as $template)
                                            <option value="{{ $template->id }}">{{ $template->title }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <br>
                                        <div wire:ignore>
                                            <textarea name="content" id="content" class="form-control"
                                                wire:model="content"></textarea>
                                        </div>
                                        @error('content')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label><strong>Previsualización:</strong></label>
                                    <div class="panel panel-bordered">
                                        <div class="panel-body">
                                            <div>
                                                {!! $content !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <h5>** En el contenido del correo electrónico puede utilizar las siguientes variables
                                    que se reemplazarn con la información del contacto.</h5>
                                <div class="row no-margin-bottom">
                                    <div class="col-lg-6">
                                        <ul>
                                            <li><strong style="font-weight:bold">@{{nit}}:<strong> NIT</li>
                                            <li><strong style="font-weight:bold">@{{name}}:<strong> Nombre</li>
                                            <li><strong style="font-weight:bold">@{{address}}:<strong> Dirección</li>
                                            <li><strong style="font-weight:bold">@{{phone}}:<strong> Teléfono</li>
                                            <li><strong style="font-weight:bold">@{{email}}:<strong> Correo electrónico
                                            </li>
                                            <li><strong style="font-weight:bold">@{{whatsap}}:<strong> WhatsApp</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul>
                                            <li><strong style="font-weight:bold">@{{website}}:<strong> Página WEB</li>
                                            <li><strong style="font-weight:bold">@{{contact_person_name}}:<strong>
                                                        Nombre persona de contacto</li>
                                            <li><strong style="font-weight:bold">@{{contact_person_email}}:<strong>
                                                        Correo persona de contacto </li>
                                            <li><strong style="font-weight:bold">@{{leader_name}}:<strong> Nombre líder
                                            </li>
                                            <li><strong style="font-weight:bold">@{{leader_email}}:<strong> Correo líder
                                            </li>
                                            <li><strong style="font-weight:bold">@{{leader_phone}}:<strong> Teléfono
                                                        líder</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12 text-center">
                                @if($emailId!='')
                                @if ( $status == 'draft')
                                <button class="btn btn-primary" wire:click='draft'><i
                                        class="fa fa-floppy-o"></i>&nbsp;Guardar borrador</button>
                                <button class="btn btn-success" wire:click='send'><i
                                        class="fa fa-paper-plane-o"></i>&nbsp;Enviar</button>
                                @endif
                                @else
                                <button class="btn btn-primary" wire:click='draft'><i
                                        class="fa fa-floppy-o"></i>&nbsp;Guardar borrador</button>
                                <button class="btn btn-success" wire:click='send'><i
                                        class="fa fa-paper-plane-o"></i>&nbsp;Enviar</button>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('javascript')
<script>
    $(document).on('click', '.cancel-to', function() {
            var element = $(this).parent().text()
            @this.removeTo(element);
            $(this).parent().remove();

        });

        $(".enter-cc").keydown(function(e) {
            if (e.keyCode == 13 || e.keyCode == 32) {
                var getValue = $(this).val();
                @this.addCc(getValue)
                $(this).val('');
            }
        });

        $(document).on('click', '.cancel-cc', function() {
            var element = $(this).parent().text()
            @this.removeCc(element);
            $(this).parent().remove();

        });

        $(".enter-cco").keydown(function(e) {
            if (e.keyCode == 13 || e.keyCode == 32) {
                var getValue = $(this).val();
                @this.addCco(getValue)
                $(this).val('');
            }
        });

        $(document).on('click', '.cancel-cco', function() {
            var element = $(this).parent().text()
            @this.removeCco(element);
            $(this).parent().remove();

        });


        const editor = CKEDITOR.replace('content', {
            filebrowserUploadUrl: "{{ route('upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form',
            extraPlugins: 'uicolor',
            height: '300px',
        });
        editor.on('change', function(event) {
            @this.set('content', event.editor.getData());
        });

        window.livewire.on('cke', () => {
            editor.setData(@this.content, {
                callback: function() {
                    this.checkDirty();
                }
            });
        });
</script>
@endpush