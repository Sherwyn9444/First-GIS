<html>
    <head>
        <script>
            $(document).ready(function(){
                $("#add-db").click(function(){
                    addField($('#point-txt-id').val(),$('#point-txt-name').val(),$('#point-txt-type').val(),$('#point-txt-owner').val(),$('#point-txt-location').val());
                });
            });
        </script>
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
                
                width:800px;
                height:600px;
                background-color: beige;
                display: block;
                margin-left: auto;
                margin-right: auto;
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
    </head>
    <body>
        

        <div id="point-information">
            <div class="point-info" id="point-class">Business</div><br>
            <div class="point-info">Id: </div><input type='text' id='point-txt-id'><br>
            <div class="point-info">Name: </div><input type='text' id='point-txt-name'><br>
            <div class="point-info">Type: </div><input type='text' id='point-txt-type'><br>
            <div class="point-info">Owner: </div><input type='text' id='point-txt-owner'><br>
            <div class="point-info">Location: </div><input type='button' id='point-btn-location' value='Open Map'><br>
            <input type='text' style='visibility:hidden;' id='point-txt-location' value=''>
        </div>
        <div id="map-holder" style = "
                position: absolute;
                z-index: 3;
                width:400px;
                height:400px;"></div>
        <button id='add-db'>Create</button>
        <div id="map-information">
            <input type="text" placeholder="Latitude" id="map-txt-lat">
            <input type="text" placeholder="Longitude" id="map-txt-lon">
            <input type="text" placeholder="Zoom" id="map-txt-zoom">
        </div>
        
            
        <script>
            var point_txt_name = document.getElementById("point-txt-name");
            var point_txt_id = document.getElementById("point-txt-id");
            var point_txt_type = document.getElementById("point-txt-type");
            var point_txt_owner = document.getElementById("point-txt-owner");
            var point_btn_location = document.getElementById("point-btn-location");
            var point_txt_location = document.getElementById("point-txt-location");
            var map_holder = document.getElementById("map-holder");
            var open_point = false;
            var collect_point = [];
            //var center_point = [121.15166,16.48612];
            var center_point = [13486396.215547621,1860735.883408689];

            var map = createMap();
            
            function createMap(){
                var temp = new ol.Map({
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
                return temp;
            }
            map.on('singleclick', function (event) {
                
                var all_layers = map.getAllLayers();
                for(var l = 0; l < all_layers.length; l++){
                    if(all_layers[l].name == "temp"){
                        map.removeLayer(all_layers[l]);
                    }
                }

                var coordinate = event.coordinate;
                var double = true;
                
                if (map.hasFeatureAtPixel(event.pixel) === true) {
                    if(!open_point){
                        setInfo(event,coordinate);
                        
                    }else{
                        double = confirm("A marker already exists near this point, do you want to continue to place?");
                    }
                } else {
                    
                    
                }
                if(double){
                    var temp_layer = createPoint(coordinate, "#0000FF");
                    map.addLayer(temp_layer);
                    collect_point.push(coordinate);
                    point_txt_location.value = "ST_GeomFromText('Point("+coordinate[0]+" "+coordinate[1]+")')";
                    //open_point = false;
                }
                
                
            });

            
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
                layer.owner = 'Someone';
                layer.coor =  ol.proj.transform(coordinate, 'EPSG:3857', 'EPSG:4326');
                return layer;
            }

            point_btn_location.addEventListener('click',function(e){
                map_holder.style.visibility = "visible";
            });

        </script>
       

    </body>
</html>