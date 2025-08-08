<div>
    <div wire:loading wire:target="save">
        @include('partials.loader')
    </div>

    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li><a href="{{ route('mailing.massive.outbox') }}">Bandeja De Salida Masiva</a></li>
        <li>Mailing Masivo</li>
    </ol>
    @endsection

    @section('page_title', 'Mailing Masivo | '.setting('admin.title'))

    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-mail"></i> Mailing Masivo
        </h1>
    </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-lg-12">
                <div class="panel panel-bordered" style="margin: 0px">
                    <div class="panel-body" style="margin: 0px">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <h5><strong>Información Mariling Masivo</strong></h5>
                                <hr style="margin:0px; padding:0px">
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <label><strong>Nombre campaña email marketing: </strong></label>
                                <input type="text" class="form-control" wire:model="campaignName"
                                    placeholder="Nombre de la campaña">
                                @error('campaignName')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-12">
                                <label><strong>Descripción: </strong></label>
                                <textarea class="form-control" rows="3" wire:model="campaignDescription"></textarea>
                                @error('campaignDescription')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
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
                <div class="panel panel-bordered" style="margin: 0px">
                    <div class="panel-body" style="margin: 0px">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <h5><strong>Seleccionar Contactos</strong></h5>
                                <hr style="margin:0px; padding:0px">
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-lg-4">
                                <label><strong>Buscar empresa:</strong></label>
                                <input type="text" class="form-control" wire:model='searchName'
                                    placeholder="Nombre de la empresa">
                            </div>
                            <div class="col-lg-4">
                                <label><strong>Fecha de registro (Desde):</strong></label>
                                <input type="datetime-local" class="form-control" wire:model="searchStart">
                            </div>
                            <div class="col-lg-4">
                                <label><strong>Fecha de registro (Hasta):</strong></label>
                                <input type="datetime-local" class="form-control" wire:model="searchEnd">
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-lg-4" wire:ignore>
                                <label><strong>Terreno comercial:</strong></label>
                                <select class="form-control" wire:model="landId" id="landId">
                                    <option value="">Seleccionar</option>
                                    @foreach ($lands as $land)
                                    <option value="{{ $land->id }}">{{ $land->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label><strong>Estrategia comercial:</strong></label>
                                <select class="form-control" wire:model="strategyId" id="strategyId">
                                    <option value="" selected>Seleccionar</option>
                                    @foreach ($strategies as $strategy)
                                    <option value="{{ $strategy->id }}">{{ $strategy->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label><strong>Acción comercial:</strong></label>
                                <select class="form-control" wire:model="actionId" id="actionId">
                                    <option value="" selected>Seleccionar</option>
                                    @foreach ($actions as $action)
                                    <option value="{{ $action->id }}">{{ $action->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <label><strong>Formulario:</strong></label>
                                <select class="form-control" wire:model="formId" id="formId">
                                    <option value="" selected>Seleccionar</option>
                                    @foreach ($forms as $form)
                                    <option value="{{ $form->id }}">{{ $form->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label><strong>Medio de almacenamiento:</strong></label>
                                <select class="form-control" wire:model='searchStorage'>
                                    <option value="">Seleccionar</option>
                                    <option value="form">Formulario</option>
                                    <option value="manual">Manual</option>
                                    <option value="excel">Excel</option>
                                    <option value="api">API</option>
                                </select>
                            </div>
                        </div>

                        <div class="row no-margin-bottom">
                            @if (count($selected) > 0)
                            <div class="container-fluid">
                                <div class="alert alert-success">
                                    @if (count($selected) == 1)
                                    <span><strong style="font-weight:bold">{{ count($selected) }}
                                            Contacto</strong> seleccionado!</span>
                                    @else
                                    <span><strong style="font-weight:bold">{{ count($selected) }}
                                            Contactos</strong> seleccionados!</span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if (count($selected) == 0)
                            @error('selected')
                            <div class="container-fluid">
                                <div class="alert alert-danger">
                                    <span><strong>Seleccione al menos un contacto</strong></span>
                                </div>
                            </div>
                            @enderror
                            @endif

                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" wire:model="selectAll"></th>
                                                <th class="thwidth"><small>NIT</small></th>
                                                <th class="thwidth"><small>Empresa</small></th>
                                                <th class="thwidth"><small>Correo elelctrónico</small></th>
                                                <th class="thwidth"><small>Teléfono</small></th>
                                                <th class="thwidth"><small>WhatsApp</small></th>
                                                <th class="thwidth"><small>Persona de contacto</small></th>
                                                <th class="thwidth"><small>Página Web</small></th>
                                                <th class="thwidth"><small>Acción comercial</small></th>
                                                <th class="thwidth"><small>Estrategia comercía</small></th>
                                                <th class="thwidth"><small>Terreno comercial</small></th>
                                                <th class="thwidth"><small>Formulario</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($contacts) > 0)
                                            @foreach ($contacts as $contact)
                                            <tr>
                                                <th>
                                                    <input type="checkbox" value="{{ $contact->id }}"
                                                        wire:model="selected">
                                                </th>
                                                <td class="fitwidth">{{ $contact->nit }}</td>
                                                <td class="fitwidth">{{ $contact->name }}</td>
                                                <td class="fitwidth">{{ $contact->email }}</td>
                                                <td class="fitwidth">{{ $contact->phone }}</td>
                                                <td class="fitwidth">{{ $contact->whatsapp }}</td>
                                                <td class="fitwidth">{{ $contact->contact_person_name }}</td>
                                                <td class="fitwidth">{{ $contact->website }}</td>
                                                <td class="fitwidth">{{ $contact->commercial_action_name }}
                                                </td>
                                                <td class="fitwidth">{{ $contact->commercial_strategy_name }}
                                                </td>
                                                <td class="fitwidth">{{ $contact->commercial_land_name }}</td>
                                                <td class="fitwidth">{{ $contact->commercial_form_name }}</td>
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
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-6">
                                <div class="pull-right">
                                    @if ($links->links())
                                    {{ $links->links() }}
                                    @endif
                                </div>
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
                <div class="panel panel-bordered" style="margin: 0px">
                    <div class="panel-body" style="margin: 0px">
                        <div class="row no-margin-bottom">
                            <div class="col-md-6">
                                <div class="page-content browse container-fluid">
                                    <div class="row no-margin-bottom">
                                        <div class="col-md-12">
                                            <div class="panel panel-bordered" style="margin: 0px">
                                                <div class="panel-body" style="margin: 0px">
                                                    <div class="row no-margin-bottom">
                                                        <div class="col-lg-12">
                                                            <h5><strong>Correo electrónico</strong></h5>
                                                            <hr style="margin:0px; padding:0px">
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="col-sm-12 email-id-row">
                                                                <span class="to-input">Asunto:</span>
                                                                <input type="text" wire:model='subject' />
                                                            </div>
                                                            @error('subject')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <div class="col-sm-12 email-id-row">
                                                                <span class="to-input">Plantilla:</span>
                                                                <select name="" id="" class="form-control"
                                                                    wire:model="template">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach ($templates as $template)
                                                                    <option value="{{ $template->id }}">
                                                                        {{ $template->title }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <br>
                                                            <div wire:ignore>
                                                                <textarea name="content" id="content"
                                                                    class="form-control"
                                                                    wire:model="content"></textarea>
                                                            </div>
                                                            @error('content')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12"
                                                            style="margin-top:15px">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th colspan="2" class="text-center">Enlaces
                                                                            llamados de acción</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Título</th>
                                                                        <th>URL</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($linksContent as $item)
                                                                    <tr>
                                                                        <td>{{ $item['title'] }}</td>
                                                                        <td>{{ $item['url'] }}</td>
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

                            <div class="col-md-6">
                                <div class="page-content browse container-fluid">
                                    <div class="row no-margin-bottom">
                                        <div class="col-md-12">
                                            <div class="panel panel-bordered" style="margin: 0px;height:730px">
                                                <div class="panel-body" style="margin: 0px">
                                                    <div class="row no-margin-bottom">
                                                        <div class="col-lg-12">
                                                            <h5><strong>Previsualización</strong></h5>
                                                            <hr style="margin:0px; padding:0px">
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div>
                                                                {!! $content !!}
                                                                
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
                                @if($campaignId!='')
                                @if ( $status == 'draft')
                                <button class="btn btn-primary" wire:click='save("draft")'>Guardar Borrador</button>
                                <button class="btn btn-success" wire:click='save("sent")'>Envíar Ahora</button>
                                @endif
                                @else
                                <button class="btn btn-primary" wire:click='save("draft")'>Guardar Borrador</button>
                                <button class="btn btn-success" wire:click='save("sent")'>Envíar Ahora</button>
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
    window.initSelect2 = () => {
            jQuery("#landId").select2({
                theme: "bootstrap"
            });

            jQuery("#strategyId").select2({
                theme: "bootstrap"
            });

            jQuery("#actionId").select2({
                theme: "bootstrap"
            });

            jQuery("#landId").on('change', function(e) {
                var data = $('#landId').select2("val");
                @this.set('landId', data);
            });

            jQuery("#strategyId").on('change', function(e) {
                var data = $('#strategyId').select2("val");
                @this.set('strategyId', data);
            });

            jQuery("#actionId").on('change', function(e) {
                var data = $('#actionId').select2("val");
                @this.set('actionId', data);
            });
        }

        initSelect2();


        window.livewire.on('select2', () => {
            initSelect2();
        });
</script>
<script>
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