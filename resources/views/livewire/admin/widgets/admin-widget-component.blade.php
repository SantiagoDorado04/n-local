<div>
    <style>
        .progress-bar {
            transition: width 2s ease-in-out;
        }
    </style>
    <div class="row no-margin-bottom">
        <div class="col-lg-12">
            <div class="page-content browse container-fluid">
                <div class="row no-margin-bottom">
                    <div class="col-md-12">
                        <div class="panel panel-bordered" style="margin:0px">
                            <div class="panel-body" style="padding:15px">
                                <div class="row no-margin-bottom">
                                    <div class="col-md-3" style="margin-bottom:0px">
                                        <div class="panel panel-bordered"
                                        style="margin-bottom:0px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1); border: 2px solid #9C9AD9;">
                                            <div class="panel-body" style="padding: 0px;">
                                                <div class="card">
                                                    <div class="card-body" style="height:120px">
                                                        <div class="row"
                                                            style="display: flex; align-items: center; justify-content: center;">
                                                            <div class="col-md-8 text-center"
                                                                style="align-self: center; padding:5px">
                                                                <h5 class="card-title">Empresas</h5>
                                                                <div class="count">
                                                                    <h2 class="counter-count">{{ \App\Contact::where('storage','=','primer-cloud')->count() ?? '' }}</h2>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 text-center"
                                                                style="align-self: center;">
                                                                <div class="icon">
                                                                    <i class="fa fa-building fa-2x"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="margin-bottom:0px">
                                        <div class="panel panel-bordered"
                                        style="margin-bottom:0px; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.1); border: 2px solid #F2A7ED;">
                                            <div class="panel-body" style="padding: 0px;">
                                                <div class="card">
                                                    <div class="card-body" style="height:120px">
                                                        <div class="row"
                                                            style="display: flex; align-items: center; justify-content: center;">
                                                            <div class="col-md-8 text-center"
                                                                style="align-self: center;">
                                                                <h5 class="card-title">Convocatorias</h5>
                                                                <div class="count">
                                                                    <h2 class="counter-count">{{ \App\Announcement::count() ?? '' }}</h2>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 text-center"
                                                                style="align-self: center;">
                                                                <div class="icon">
                                                                    <i class="fa fa-bullhorn fa-3x"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="margin-bottom:0px">
                                        <div class="panel panel-bordered"
                                            style="margin-bottom:0px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1); border: 2px solid #9C9AD9;">
                                            <div class="panel-body" style="padding: 0px;">
                                                <div class="card">
                                                    <div class="card-body" style="height:120px">
                                                        <div class="row"
                                                            style="display: flex; align-items: center; justify-content: center;">
                                                            <div class="col-md-8 text-center"
                                                                style="align-self: center; padding:5px">
                                                                <h5 class="card-title">Proyectos</h5>
                                                                <div class="count">
                                                                    <h2 class="counter-count">{{ \App\Models\Project::count() ?? '' }}</h2>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 text-center"
                                                                style="align-self: center;">
                                                                <div class="icon">
                                                                    <i class="fa fa-briefcase fa-3x"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="margin-bottom:0px">
                                        <div class="panel panel-bordered"
                                            style="margin-bottom:0px; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.1); border: 2px solid #F2A7ED;">
                                            <div class="panel-body" style="padding: 0px;">
                                                <div class="card">
                                                    <div class="card-body" style="height:120px">
                                                        <div class="row"
                                                            style="display: flex; align-items: center; justify-content: center;">
                                                            <div class="col-md-8 text-center"
                                                                style="align-self: center; padding:5px">
                                                                <h5 class="card-title">Formularios</h5>
                                                                <div class="count">
                                                                    <h2 class="counter-count">{{ \App\CommercialForm::count() ?? '' }}</h2>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 text-center"
                                                                style="align-self: center;">
                                                                <div class="icon">
                                                                    <i class="fa fa-calendar-o fa-3x"></i>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row no-margin-bottom">
        <div class="col-lg-12">
            <div class="page-content browse container-fluid">
                <div class="row no-margin-bottom">
                    <div class="col-md-4">
                        <div class="panel panel-bordered" style="margin:0px">
                            <div class="panel-heading" style="padding-left:15px">
                                <h5>Tipos de empresas</h5>
                            </div>
                            <div class="panel-body" style="padding:15px;height:346px">
                                <div class="row no-margin-bottom">
                                    <div class="col-lg-12">
                                        <canvas id="myChart" width="250" height="250"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="panel panel-bordered">
                            <div class="panel-heading" style="padding-left:15px">
                                    <h5><strong>Porcentaje diligenciamiento de información de empresas</strong></h5>
                                </div>
                                <div class="panel-body">
                                    <div class="row no-margin-bottom">
                                        <div class="col-lg-12">
                                            TechMinds<span class="pull-right strong">80%</span>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                                                    style="background-color: #9C9AD9">
                                                    80%
                                                </div>
                                            </div>

                                            CodeLab<span class="pull-right strong">60%</span>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                                style="background-color: #D98BBD">
                                                    60%
                                                </div>
                                            </div>

                                            NexxusTech<span class="pull-right strong">75%</span>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                                    style="background-color: #D98BBD">
                                                    75%
                                                </div>
                                            </div>
                                            BrainWave<span class="pull-right strong">35%</span>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"
                                                    style="background-color: #F2A7ED">
                                                    35%
                                                </div>
                                            </div>
                                            TechSavvy<span class="pull-right strong">8%</span>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"
                                                    style="background-color: #F2A7ED">
                                                    8%
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
    </div>

    <div class="row no-margin-bottom">
        <div class="col-lg-12">
            <div class="page-content browse container-fluid">
                <div class="row no-margin-bottom">
                    <div class="col-md-4">
                        <div class="panel panel-bordered" style="margin:0px">
                            <div class="panel-heading" style="padding-left:15px">
                                <h5>Proyectos</h5>
                            </div>
                            <div class="panel-body" style="padding:15px;height:346px">
                                <div class="row no-margin-bottom">
                                    <div class="col-lg-12">
                                        <div class="panel panel-bordered"
                                            style="margin-bottom:0px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1); border: 2px solid #f3f3f3;">
                                            <div class="panel-body" style="padding:0px;margin:0px">
                                                <div class="card" style="padding:0px;margin:0px">
                                                    <div class="card-body" style="padding:0px;margin:0px">
                                                        <div class="row"
                                                            style="display: flex; align-items: center; justify-content: center;padding:0px;margin:0px">
                                                            <div class="col-md-4 text-center"
                                                                style="align-self: center; background-color:#BFBFBF;text-color:#fff;padding:0px;margin:0px">
                                                                <div class="icon">
                                                                    <i class="fa fa-briefcase fa-2x" style="padding:15px; color:#fff"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 text-center" 
                                                                style="align-self: end; padding:0px;margin:0px">
                                                                <div class="count">
                                                                    <h3 class="counter-count">25</h3>
                                                                </div>
                                                                <h5 class="card-title">Proyectos</h5>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="panel panel-bordered"
                                            style="margin-bottom:0px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1); border: 2px solid #f3f3f3;">
                                            <div class="panel-body" style="padding:0px;margin:0px">
                                                <div class="card" style="padding:0px;margin:0px">
                                                    <div class="card-body" style="padding:0px;margin:0px">
                                                        <div class="row"
                                                            style="display: flex; align-items: center; justify-content: center;padding:0px;margin:0px">
                                                            <div class="col-md-4 text-center"
                                                                style="align-self: center; background-color:#F2A7ED;text-color:#fff;padding:0px;margin:0px">
                                                                <div class="icon">
                                                                    <i class="fa fa-hourglass-start fa-2x" style="padding:15px; color:#fff"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 text-center" 
                                                                style="align-self: end; padding:0px;margin:0px">
                                                                <div class="count">
                                                                    <h3 class="counter-count">6</h3>
                                                                </div>
                                                                <h5 class="card-title">Proyectos Iniciados</h5>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="panel panel-bordered"
                                            style="margin-bottom:0px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1); border: 2px solid #f3f3f3;">
                                            <div class="panel-body" style="padding:0px;margin:0px">
                                                <div class="card" style="padding:0px;margin:0px">
                                                    <div class="card-body" style="padding:0px;margin:0px">
                                                        <div class="row"
                                                            style="display: flex; align-items: center; justify-content: center;padding:0px;margin:0px">
                                                            <div class="col-md-4 text-center"
                                                                style="align-self: center; background-color:#9C9AD9;text-color:#fff;padding:0px;margin:0px">
                                                                <div class="icon">
                                                                    <i class="fa fa-hourglass-end fa-2x" style="padding:15px; color:#fff"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 text-center" 
                                                                style="align-self: end; padding:0px;margin:0px">
                                                                <div class="count">
                                                                    <h3 class="counter-count">19</h3>
                                                                </div>
                                                                <h5 class="card-title">Proyectos Finalizados</h5>
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
                    <div class="col-md-8">
                        <div class="panel panel-bordered">
                            <div class="panel-heading" style="padding-left:15px">
                                    <h5><strong>Porcentaje nivel diligenciamientode proyectos</strong></h5>
                                </div>
                                <div class="panel-body">
                                    <div class="row no-margin-bottom">
                                        <div class="col-lg-12">
                                            Brilliance Marketing Solutions<span class="pull-right strong">98%</span>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-danger"
                                                    style="background-color: #9C9AD9; width:98%" aria-valuenow="98"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                    98%
                                                </div>
                                            </div>

                                            Bold Branding Agency<span class="pull-right strong">14%</span>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100"
                                                    style="background-color: #D98BBD">
                                                    14%
                                                </div>
                                            </div>

                                            Ignite Advertising Agency<span class="pull-right strong">56%</span>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-warning"  role="progressbar" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"
                                                    style="background-color: #D98BBD">
                                                    56%
                                                </div>
                                            </div>
                                            Prime Promotion Partners<span class="pull-right strong">93%</span>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-warning"  role="progressbar" aria-valuenow="93" aria-valuemin="0" aria-valuemax="100"
                                                    style="background-color: #F2A7ED">
                                                    93%
                                                </div>
                                            </div>
                                            Radiant Results Marketing<span class="pull-right strong">27%</span>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-warning"  role="progressbar" aria-valuenow="27" aria-valuemin="0" aria-valuemax="100"
                                                    style="background-color: #F2A7ED">
                                                    27%
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
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Publica', 'Privada', 'Pequeña','Micro','Pyme'],
                datasets: [{
                    label : "Tipos de empresas",
                    data: [12,16,21,6,13],
                    borderWidth: 1
                }]
            },
            options: {
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 2000 
                },
                cutoutPercentage: 50,
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: true,
                    text: 'Resultados de la encuesta'
                },
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        fontColor: 'black',
                        fontSize: 14
                    }
                }
            }
        });
    </script>
    @push('javascript')
        <script>
            $('.counter-count').each(function () {
                $(this).prop('Counter',0).animate({
                    Counter: $(this).text()
                }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function (now) {
                        $(this).text(Math.ceil(now));
                    }
                });
            });

      $('.progress .progress-bar').css("width",
                function() {
                    return $(this).attr("aria-valuenow") + "%";
                }
        )

        </script>
    @endpush
</div>