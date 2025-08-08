<div>
    @include('livewire.admin.videotutorials.modals.show')
    @include('livewire.admin.videotutorials.modals.create')
    @include('livewire.admin.videotutorials.modals.edit')
    @include('livewire.admin.videotutorials.modals.delete')

    @section('page_title', 'Tutoriales | '.setting('admin.title'))

    @section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li>Tutoriales</li>
    </ol>
    @endsection


    @section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="fa fa-file-video-o"></i>&nbsp;Tutoriales
        </h1>
        @if (Auth::user()->role_id == '1')
        <button class="btn btn-success btn-add-new" data-toggle="modal" data-target="#create-modal">
            <i class="fa fa-plus-square"></i> <span>{{ __('voyager::generic.add_new') }}</span>
        </button>
        @endif
    </div>
    @stop

    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <div class="row no-margin-bottom">
                                    @foreach ($tutorials as $tutorial)
                                    <div class="col-md-6">
                                        <div class="panel panel-info">
                                            <div class="panel-heading panel-heading-custom">
                                                <h5 class="panel-title-custom">
                                                    {{ $tutorial->title }}
                                                    @if ( Auth::user()->role_id == '1')
                                                        <div class="btn-group pull-right navbar-right panel-navbar-custom">
                                                            <button class="btn btn-link dropdown-toggle" style="color:#fff"
                                                                data-toggle="dropdown">
                                                                <i class="fa fa-ellipsis-v"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a data-toggle="modal" data-target="#edit-modal"
                                                                        wire:click="edit({{ $tutorial->id }})">
                                                                        <i class="fa fa-pencil"></i>&nbsp;&nbsp;Editar
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a data-toggle="modal" data-target="#delete-modal"
                                                                        wire:click="delete({{ $tutorial->id }})">
                                                                        <i class="fa fa-trash-o"></i>&nbsp;&nbsp;Eliminar
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </h5>
                                            </div>
                                            <button style="background-color: #fff; border:0px; margin:0px; padding:0px"
                                                data-toggle="modal" data-target="#show-modal"
                                                wire:click="show({{ $tutorial->id }})">
                                                <div class="panel-body text-left" style="padding:20px">
                                                    <h5>Título:</h5>
                                                    <p>{{ $tutorial->title }}</p>

                                                    <h5>Descripción:</h5>
                                                    <p>{!! $tutorial->description !!}</p>

                                                    <h5>Categoría:</h5>
                                                    <p>{{ $tutorial->category->title ?? ''}}</p>

                                                    <h5>Creado por:</h5>
                                                    <p>{{ $tutorial->createUser->name ?? ''}}</p>
                                                        
                                                </div>
                                            </button>
                                            <div class="panel-footer text-right">
                                                <button type="button" class="btn btn-success sm-b" title="Ver Video"
                                                    data-toggle="modal" data-target="#show-modal"
                                                    wire:click="show({{ $tutorial->id }})">
                                                    <i class="fa fa-file-video-o"></i>&nbsp;Ver Video
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
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

        const editor = CKEDITOR.replace('content', {
            filebrowserUploadUrl: "{{ route('upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form',
            extraPlugins: 'uicolor',
            height: '200px',
        });
        editor.on('change', function(event) {
            @this.set('description', event.editor.getData());
        });

        //------------------------------------------------------------//
        const editor2 = CKEDITOR.replace('content2', {
            filebrowserUploadUrl: "{{ route('upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form',
            extraPlugins: 'uicolor',
            height: '200px',
        });
        editor2.on('change', function(event) {
            @this.set('description', event.editor.getData());
        });

        window.livewire.on('load-cke', () => {
            editor2.setData(@this.description, {
                callback: function() {
                    this.checkDirty();
                }
            });
        });
    </script>
@endpush