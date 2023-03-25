<html>
    <head>
        <style>
            #map-controller{
                display: inline-block;
            }
            #map-controller input[type='button']{
                
            }
            #map-information{
                display: none;   
            }
            #point-information{
                position: fixed;
                right: 0px;
                top: 55px;
                width:325px;
                height:600px;
                background-color: red;
                padding: 15px;
                text-align: left;
            }
            #point-information input{
                height: 20px;
                width: 150px;
                font-size: 16px;
            }
            #point-information div{
                display: inline-block;
                padding: 5px;
            }
            .point-info{
                width: 125px;
                text-align: right;
            }
            #point-class{
                width: 100%;
                text-align: center;
            }
            
        </style>
        <script src="https://cdn.jsdelivr.net/npm/ol@v7.2.2/dist/ol.js"></script>   <!--Map-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v7.2.2/ol.css">    <!--Map-->
    <script src="https://cdn.jsdelivr.net/npm/elm-pep@1.0.6/dist/elm-pep.js"></script> <!--Map-->
    </head>
    <body>
        <div id="map-holder" style="width:800px;height:600px;"></div>

        <div id="point-information">
            <div class="point-info" id="point-class">Point</div><br>
            <div class="point-info">Name: </div><input type='text' id='point-txt-name'>
            <div class="point-info">Id: </div><input type='text' id='point-txt-id'>
            <div class="point-info">Type: </div><input type='text' id='point-txt-type'>
            <div class="point-info">Owner: </div><input type='text' id='point-txt-owner'>
            <div class="point-info">Coordinates: </div><input type='text' id='point-txt-coor'>
        </div>
        <div id="map-controller">
            <input type="text" id="map-txt-search" placeholder="Search">
            <input type="button" id="map-btn-search" value="Search">
            <input type="button" id="map-btn-point" value="Add Point">
            <input type="button" id="map-btn-savepoint" value="Save as Point">
            <input type="button" id="map-btn-saveregion" value="Save as Region">
            <input type="button" id="map-btn-reset" value="Clear">
            <input type="button" id="map-btn-getdata" value="Data">
        </div>

        <div id="map-information">
            <input type="text" placeholder="Latitude" id="map-txt-lat">
            <input type="text" placeholder="Longitude" id="map-txt-lon">
            <input type="text" placeholder="Zoom" id="map-txt-zoom">
        </div>
        
        <div id="popup" class="ol-popup">
            <a href="#" id="popup-closer" class="ol-popup-closer"></a>
            <div id="popup-content"></div>
        </div>
            
        <script>
            var Salvacion = [
                [16.486710064705164, 121.15179441522147],
                [16.485490992433665, 121.15132946850012],
                [16.48172226900472, 121.14814748929045],
                [16.48011305049419, 121.1460697585049],
                [16.476307419530375, 121.1469755275274],
                [16.476843837712334, 121.14922761320898],
                [16.47800026667709, 121.15106560586156],
                [16.480229507834608, 121.15315786619628],
                [16.482214904173446, 121.1556569550765]
            ]
            var container = document.getElementById('popup');
            var content = document.getElementById('popup-content');
            var closer = document.getElementById('popup-closer');
            var map_txt_lat = document.getElementById("map-txt-lat");
            var map_txt_lon = document.getElementById("map-txt-lon");
            var map_txt_zoom = document.getElementById("map-txt-zoom");
            var point_txt_name = document.getElementById("point-txt-name");
            var point_txt_id = document.getElementById("point-txt-id");
            var point_txt_type = document.getElementById("point-txt-type");            
            var point_txt_owner = document.getElementById("point-txt-owner");
            var point_txt_coor = document.getElementById("point-txt-coor");
            var map_btn_search = document.getElementById("map-btn-search");
            var map_btn_point = document.getElementById("map-btn-point");
            var map_btn_savepoint = document.getElementById("map-btn-savepoint");
            var map_btn_saveregion = document.getElementById("map-btn-saveregion");
            var map_btn_reset = document.getElementById("map-btn-reset");
            var map_btn_getdata = document.getElementById("map-btn-getdata");
            var open_point = false;
            var open_poly = false;
            var collect_point = [];
            //var center_point = [121.15166,16.48612];
            var center_point = [13486396.215547621,1860735.883408689];

            map_btn_point.addEventListener('click',function(){
                if(open_point){
                    open_point = false;
                }else{
                    open_point = true;
                }
                collect_point = [];
            });

            map_btn_savepoint.addEventListener('click',function(){
               savePoint('blue');
               collect_point = [];
            });

            map_btn_saveregion.addEventListener('click',function(){
                var all_layers = map.getAllLayers();
                for(var l = 1; l < all_layers.length; l++){
                    if(all_layers[l].name == "temp"){
                        map.removeLayer(all_layers[l]);
                    }
                }
                for(var x =0; x< Salvacion.length ; x++){
                    var temp = Salvacion[x][0];
                    Salvacion[x][0] = Salvacion[x][1];
                    Salvacion[x][1] = temp;

                }
                Salvacion.map(function(e){
                   collect_point.push(ol.proj.fromLonLat(e));    
                });
                
                var temp_layer = createPoly(collect_point);
                map.addLayer(temp_layer);

                collect_point = [];
            });

            map_btn_reset.addEventListener('click',function(){
                var all_layers = map.getAllLayers();
                for(var l = 1; l < all_layers.length; l++){
                    if(all_layers[l].name == 'temp'){
                        map.removeLayer(all_layers[l]);
                    }
                }
            });

            map_btn_getdata.addEventListener('click',function(){
                var all_layers = map.getAllLayers();
                for(var l = 1; l < all_layers.length; l++){
                   console.log(all_layers[l]);
                }
            });

            var map = new ol.Map({
                layers:[
                    new ol.layer.Tile({
                        source: new ol.source.TileJSON({
                            url:'https://api.maptiler.com/maps/openstreetmap/tiles.json?key=iXy9WEaPCZfoCJLTKnjL',
                            tileSize:512,
                        })
                    }),
                    
                ],
                target: 'map-holder',
                view: new ol.View({
                    center: center_point/*ol.proj.fromLonLat(center_point)*/,
                    zoom: 17,
                })
            });

            map.on('singleclick', function (event) {
                var coordinate = event.coordinate;
                var double = true;
                
                if (map.hasFeatureAtPixel(event.pixel) === true) {
                    map_txt_lat.value = coordinate[0];
                    map_txt_lon.value = coordinate[1];
                    if(!open_point){
                        setInfo(event,coordinate);
                        
                    }else{
                        double = confirm("A marker already exists near this point, do you want to continue to place?");
                    }
                } else {
                    
                    
                }
                if(open_point && double){
                    var temp_layer = createPoint(coordinate, "#0000FF");
                    map.addLayer(temp_layer);
                    collect_point.push(coordinate);
                    point_txt_name.value = temp_layer.name;
                    point_txt_id.value = temp_layer.id;
                    point_txt_type.value = temp_layer.type;
                    point_txt_coor.value = temp_layer.coor;
                    //open_point = false;
                    var yey = map.getView();
                    yey.animate({
                        center:coordinate,
                        duration:750,
                    });
                }
                
                
            });

            map.getView().on('change:resolution', function(event){
                map_txt_zoom.value = map.getView().getZoom();
            });
            
        function setInfo(event, coordinate){
            var feature = map.forEachFeatureAtPixel(event.pixel, function (feature, layer) {
                //console.log(layer.name, layer.id, layer.coor);
                point_txt_name.value = layer.name;
                point_txt_id.value = layer.id;
                point_txt_type.value = layer.type;
                point_txt_coor.value = layer.coor;
                           
                var yey = map.getView();
                yey.animate({
                    center:coordinate,
                    duration:750,
                });
                });
        }
        function createPoint(coordinate, color){
            var layer = new ol.layer.Vector({
                source: new ol.source.Vector({
                    features: [
                        new ol.Feature(new ol.geom.Point(coordinate))
                    ],
                }),
                /*
                style: new ol.style.Style({
                    image: new ol.style.Icon({
                        color: color,
                        crossOrigin: 'anonymous',
                        src: 'Icon/Marker_Icon.png',
                        scale: 0.05
                    }),
                })
                */
            });
            layer.name = "temp";
            layer.id = '1';
            layer.type = 'Point';
            layer.coor =  ol.proj.transform(coordinate, 'EPSG:3857', 'EPSG:4326');
            return layer;
        }

        function savePoint(color){
            var all_layers = map.getAllLayers();
            var style_layer = new ol.style.Style({
                    image: new ol.style.Icon({
                        color: color,
                        crossOrigin: 'anonymous',
                        src: 'Icon/Marker_Icon.png',
                        scale: 0.05
                    }),
                })
            for(var l = 1; l < all_layers.length; l++){
                if(all_layers[l].name == "temp"){
                    all_layers[l].setStyle(style_layer);
                    all_layers[l].name = "";
                }
            }
        }

        function createPoly(coordinates, color){
            var layer = new ol.layer.Vector({
                source: new ol.source.Vector({
                    features: [
                        new ol.Feature(new ol.geom.Polygon([coordinates]))
                    ],
                }),
                
                style: new ol.style.Style({
                    stroke: new ol.style.Stroke({
                        color: 'rgba(255, 0, 0, 1)',
                        width:1,
                    }),
                    fill: new ol.style.Fill({
                        color: 'rgba(255, 0, 0, 0.1)',
                    })
                }),
                
            });
            layer.name = "poly";
            layer.id = '1';
            layer.type = 'Region';
            layer.coor = coordinates;
            return layer;
        }
        </script>
       

    </body>
</html>