@extends('voyager::master')

<style>

jmnode.root {
    font-size: 18px !important;
}
</style>

@section('breadcrumbs')
    <ol class="breadcrumb hidden-xs">
        <li class="active">
            <a href="{{ route('voyager.dashboard') }}"><i class="voyager-boat"></i>
                {{ __('voyager::generic.dashboard') }}</a>
        </li>
        <li>Detalles proyecto</li>
    </ol>
@endsection

@section('page_title', 'Detalles proyecto | '{{ setting('admin.title') }})

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="fa fa-sitemap"></i>Detalles del proyecto
        </h1>
    </div>
@stop

@section('content')
<div class="page-content browse container-fluid">
    <div class="row no-margin-bottom">
        <div class="col-md-12">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <div class="row no-margin-bottom">
                        <div class="col-lg-12 text-right">
                            
                            <button id="zoom-in-button" onclick="zoomIn();" class="btn btn-primary sm-b"><i class="fa fa-search-plus" aria-hidden="true"></i>&nbsp;Zoom In</button>
                            <button id="zoom-out-button" onclick="zoomOut();" class="btn btn-primary sm-b">
                                <i class="fa fa-search-minus" aria-hidden="true"></i>&nbsp;Zoom Out
                            </button>
                            <button class="btn btn-success sm-b" onclick="screen_shot();"><i class="fa fa-cloud-download"></i>&nbsp;Descargar</button>
                        </div>
                        <div class="col-lg-12">
                            <div id="jsmind_container" style="position:unset;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('javascript')
<script type="text/javascript">
    var mind = {
        meta: {
            name:
                "GreenTech",
        },
        format: "node_tree",
        data: {
            id: "root",
            topic:
                'GreenTech',
            children: [
                {
                    id: "open",
                    topic: "problems",
                    direction: "right",
                    children: [
                        { 
                            id: "open1", 
                            topic: "Ineficiencia energética",
                            children: [
                                {
                                    id: "open11", 
                                    topic: "solutions",
                                    children: [
                                        { 
                                            id: "open111", 
                                            topic: "Implementación de tecnología de automatización de edificios y hogares, incluyendo sensores de movimiento y temperatura, sistemas de iluminación y calefacción inteligentes y paneles solares.",
                                            children: [
                                                {
                                                    id: "open1111", 
                                                    topic: "methodologies",
                                                    children: [
                                                        {
                                                            id: "open11111", 
                                                            topic: "Análisis de necesidades de los clientes, evaluación de la calidad del aire, diseño y planificación de la solución, instalación y mantenimiento.",
                                                            children: [
                                                                {
                                                                    id: "open111111", 
                                                                    topic: "indicators",
                                                                    children: [
                                                                        {
                                                                            id: "open1111111", 
                                                                            topic: "Reducción en el consumo de energía, disminución de las emisiones de gases de efecto invernadero, ahorro de costos en energía.",
                                                                        },
                                                                        {
                                                                            id: "open11111111", 
                                                                            topic: "Mejora en la calidad del aire, reducción de las emisiones de gases de efecto invernadero, cumplimiento de las regulaciones ambientales.",
                                                                        }
                                                                    ]
                                                                }
                                                            ]
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ]
                        },
                        { 
                            id: "open2", 
                            topic: "Contaminación" ,
                            children: [
                                {
                                    id: "ope22", 
                                    topic: "Soluciones",
                                    children: [
                                        { 
                                            id: "open222", 
                                            topic: "Implementación de tecnología de monitoreo ambiental y sistemas de control de emisiones, incluyendo filtros de aire y procesos de producción más limpios.",
                                        }
                                    ]
                                }
                            ]
                        }
                    ],
                }
            ],
        },
    };
    var options = {
        // for more detail at next chapter
        container: "jsmind_container", // [required] id of container
        editable: true, // [required] whether allow edit or not
        theme: "primary", 
        view:{
            engine: 'canvas', 	// engine for drawing lines between nodes in the mindmap
            hmargin:100, 		// Minimum horizontal distance of the mindmap from the outer frame of the container
            vmargin:50, 			// Minimum vertical distance of the mindmap from the outer frame of the container
            line_width:2, 		// thickness of the mindmap line
            line_color:'#555', 	// Thought mindmap line color
            draggable: false,    // Drag the mind map with your mouse, when it's larger that the container
            hide_scrollbars_when_draggable: false, // Hide container scrollbars, when mind map is larger than container and draggable option is true.
            node_overflow: 'wrap' // Text overflow style in node
        },// [required] theme
    };
    var jm = new jsMind(options);
    jm.show(mind);


    //Screenshot
    function screen_shot() {
        jm.screenshot.shootDownload();
    }

    var zoomInButton = document.getElementById('zoom-in-button');
            var zoomOutButton = document.getElementById('zoom-out-button');

            function zoomIn() {
                if (jm.view.zoomIn()) {
                    zoomOutButton.disabled = false;
                } else {
                    zoomInButton.disabled = true;
                }
            }

            function zoomOut() {
                if (jm.view.zoomOut()) {
                    zoomInButton.disabled = false;
                } else {
                    zoomOutButton.disabled = true;
                }
            }
</script>
@endpush