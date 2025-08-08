<div>
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body" style="max-height: 575px; overflow-y: auto;">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <!-- Panel para mostrar los puntos totales -->
                                <div class="panel panel-info" style="margin-bottom: 20px;">
                                    <div class="panel-heading text-center"
                                        style="padding: 20px; background-color: #FE9941; color: white;">
                                        <h4 class="panel-title-custom">
                                            Total de Puntos para {{ $contact->name }}
                                        </h4>
                                        <h2 style=" font-weight: bold;">
                                            {{ $contact->points }} puntos
                                        </h2>
                                    </div>
                                </div>

                                <!-- Panel de detalles de puntos -->
                                <div class="panel panel-primary">
                                    <div class="panel-heading panel-heading-custom">
                                        <h5 class="panel-title-custom">Detalles de Puntos asignados a
                                            {{ $contact->name }}:</h5>
                                    </div>
                                    <div class="panel-body" style="margin-top:15px">
                                        <div class="row no-margin-bottom">
                                            @forelse ($detailPoints->take(5) as $detail)
                                                <div class="col-lg-12">
                                                    <div class="panel panel-primary">
                                                        <div class="panel-heading panel-heading-custom">
                                                            <h5 class="panel-title-custom">+ {{ $detail->points }}
                                                                puntos</h5>
                                                        </div>
                                                        <div class="panel-body" style="margin:15px">
                                                            <h6>{{ $detail->detail }}</h6>
                                                            <p>Puntos: {{ $detail->points }}</p>
                                                            <p>Fecha:
                                                                {{ \Carbon\Carbon::parse($detail->date)->format('Y-m-d h:i A') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <p>No se encontraron detalles de puntos.</p>
                                            @endforelse
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
