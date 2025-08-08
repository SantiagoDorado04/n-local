<div>
    @section('breadcrumbs')
        <ol class="breadcrumb hidden-xs">
            <li class="active">
                <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                    {{ __('voyager::generic.dashboard') }}</a>
            </li>
            <li>
                <a href="{{ route('interviews') }}">Entrevistas</a>
            </li>
            <li>
                Respuestas
            </li>
        </ol>
    @endsection

    @section('page_title', 'Respuestas | ' . setting('admin.title'))

    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="fa fa-video-camera" aria-hidden="true"></i>Respuestas
            </h1>
        </div>
    @stop
    
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-lg-12">
                <div class="panel panel-bordered" style="margin-bottom:0px">
                    <div class="panel-body" style="margin-bottom:0px">
                        <ul>
                            <li><strong>Entrevista: {{ $topic }}</strong>
                            </li>
                        </ul>
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
                        <div class="row no-margin-bottom" style="margin-bottom:12px">
                            <div class="col-lg-12">
                                <label><strong>Buscar persona:</strong></label>
                                <input type="text" class="form-control" wire:model="searchName" placeholder="Nombre / Correo electrónico / Teléfono">
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            @if(!empty($responses))
                                @foreach($responses as $response)
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading panel-heading-custom">
                                                <h6 class="panel-title-custom"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;{{ $response['candidate_name'] }}</h6>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row no-margin-bottom mt5">
                                                    <div class="col-lg-12" style="margin-top: 20px;">
                                                        <div class="thumbnail-container">
                                                            @if(!empty($response['file_jpg']) )
                                                                <img src="{{ $response['file_jpg'] }}" alt="Thumbnail" class="img-thumbnail" style="border: 0px">
                                                            @endif
                                                        </div>
                                                        <p class="text-muted">
                                                            <small><strong>Email: </strong>{{ $response['candidate_email'] }}</small><br>
                                                            <small><strong>Teléfono: </strong>{{ $response['candidate_phone'] }}</small>
                                                        </p>
                                                        <button class="btn btn-success btn-block sm-b" onclick="showModal('{{ $response['file_mp4'] }}')"><i class="fa fa-video-camera" aria-hidden="true"></i>&nbsp;Ver Video</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="videoModal" class="modal modal-info fade" 
        tabindex="-1" data-backdrop="static" data-keyboard="false" 
        role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" 
                    class="close" 
                    data-dismiss="modal"
                    aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title">
                        <i class="fa fa-video-camera" aria-hidden="true"></i>
                        &nbsp;Video de la Entrevista
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="row no-margin-bottom text-center">
                        <div class="col-lg-12">
                            <div class="video-container">
                                <video id="modalVideo" controls class="img-responsive">
                                    <source id="videoSource" src="" type="video/mp4">
                                    Tu navegador no soporta la reproducción de video.
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .thumbnail-container {
        width: 100%;
        height: 140px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .thumbnail-container img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    .video-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .video-container video {
        max-width: 100%;
        height: auto;
    }
</style>

<script>
    function showModal(videoUrl) {
        document.getElementById('videoSource').src = videoUrl;
        document.getElementById('modalVideo').load();
        $('#videoModal').modal('show');
    }

    function closeModal() {
        document.getElementById('modalVideo').pause();
        $('#videoModal').modal('hide');
    }
</script>