<div>
<style>

jmnode.root {
    font-size: 18px !important;
}
</style>


<div class="page-content browse container-fluid">
    <div class="row no-margin-bottom">
        <div class="col-md-12">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <div class="row no-margin-bottom">
                        <div wire:ignore class="col-lg-12">
                            <div id="jsmind_container" style="position:unset;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button class="btn btn-success" onclick="screen_shot();">Download</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('javascript')
<script type="text/javascript">
    var mind = {
        meta: {
            name:
                "GreenTech",
            author: "Empresa ejemplo",
        },
        format: "node_tree",
        data: {
            id: "root",
            topic:
                'GreenTech',
            children: [
                {
                    id: "open",
                    topic: "problemas",
                    direction: "right",
                    children: [
                        { 
                            id: "open1", 
                            topic: "Ineficiencia energética",
                            children: [
                                {
                                    id: "open11", 
                                    topic: "Soluciones",
                                    children: [
                                        { 
                                            id: "open111", 
                                            topic: "Implementación de tecnología de automatización de edificios y hogares, incluyendo sensores de movimiento y temperatura, sistemas de iluminación y calefacción inteligentes y paneles solares.",
                                            children: [
                                                {
                                                    id: "open1111", 
                                            topic: "Implementación de tecnología de monitoreo ambiental y sistemas de control de emisiones, incluyendo filtros de aire y procesos de producción más limpios.",
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
</script>
@endpush
</div>
