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
                transition: 0.75s 0.1s;
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
        <script>
            var allPoints = [];
            $(document).ready(function(){
                if(allPoints.length == 0){
                    $.post("read.php",{
                    readId: null
                    },function(data, status){
                        var datum = JSON.parse(data);
                        allPoints = datum;
                        setAllPoint(allPoints);
                    });
                }
            });
        </script>
    </head>
    <body>
        <div id="map-holder" style="width:800px;height:600px;"></div>

        <div id="point-information">
            <div class="point-info" id="point-class">Point</div><br>
            <div class="point-info">Name: </div><input type='text' id='point-txt-name'>
            <div class="point-info">Id: </div><input type='text' id='point-txt-id'>
            <div class="point-info">Type: </div><input type='text' id='point-txt-type'>
            <div class="point-info">Owner: </div><input type='text' id='point-txt-owner'>
            <div class="point-info">Date: </div><input type='text' id='point-txt-date'>
            <div class="point-info">Coordinates: </div><input type='text' id='point-txt-coor'>
        </div>
        
        <div id="map-information">
            <input type="text" placeholder="Latitude" id="map-txt-lat">
            <input type="text" placeholder="Longitude" id="map-txt-lon">
            <input type="text" placeholder="Zoom" id="map-txt-zoom">
        </div>
        
            
        <script>
            var container = document.getElementById('popup');
            var content = document.getElementById('popup-content');
            var closer = document.getElementById('popup-closer');
            var point_information = document.getElementById("point-information");
            var point_txt_name = document.getElementById("point-txt-name");
            var point_txt_id = document.getElementById("point-txt-id");
            var point_txt_type = document.getElementById("point-txt-type");
            var point_txt_owner = document.getElementById("point-txt-owner");
            var point_txt_date = document.getElementById("point-txt-date");
            var point_txt_coor = document.getElementById("point-txt-coor");
            var open_point = false;
            var collect_point = [];
            //var center_point = [121.15166,16.48612];
            var center_point = [13486396.215547621,1860735.883408689];
            
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
                    point_information.style.opacity = 1;
                    setInfo(event.pixel,coordinate);   
                } else {
                    deselect();
                    point_information.style.opacity = 0;                
                }
               
            });

        function mapSelect(local){
            setTimeout(function(){
                var pix = map.getPixelFromCoordinate(pointToArray(local));
                setInfo(pix,pointToArray(local));
            },100)
        }

        function setInfo(pixel, coordinate){
            deselect();
            var feature = map.forEachFeatureAtPixel(pixel, function (feature, layer) {
                //console.log(layer.name, layer.id, layer.coor);
                point_txt_name.value = layer.name;
                point_txt_id.value = layer.id;
                point_txt_type.value = layer.type;
                point_txt_owner.value = layer.owner;
                point_txt_date.value = layer.date;
                point_txt_coor.value = layer.coor;
                var style_layer = new ol.style.Style({
                    image: new ol.style.Icon({
                        color: "#000000",
                        crossOrigin: 'anonymous',
                        src: 'Icon/Marker_Icon.png',
                        scale: 0.05
                    }),
                })        
                layer.setStyle(style_layer);
                var mapView = map.getView();
                mapView.animate({
                    center:coordinate,
                    duration:750,
                });
            });
        }
        
        function deselect(){
            var all_layers = map.getAllLayers();
            var style_layer = new ol.style.Style({
                    image: new ol.style.Icon({
                        color: "#FF00FF",
                        crossOrigin: 'anonymous',
                        src: 'Icon/Marker_Icon.png',
                        scale: 0.05
                    }),
                })
            for(var l = 1; l < all_layers.length; l++){
                all_layers[l].setStyle(style_layer);
            }
        }

        function createPoint(coordinate, color,name,id,type,owner,date){
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
            var style_layer = new ol.style.Style({
                    image: new ol.style.Icon({
                        color: color,
                        crossOrigin: 'anonymous',
                        src: 'Icon/Marker_Icon.png',
                        scale: 0.05
                    }),
                })
            layer.setStyle(style_layer);
            layer.name = name;
            layer.id = id;
            layer.type = type;
            layer.owner = owner;
            layer.date = date;
            layer.coor =  ol.proj.transform(coordinate, 'EPSG:3857', 'EPSG:4326');
            return layer;
        }

        function setAllPoint(arr){
            
            arr.map(function(e){
                
                var temp = createPoint(pointToArray(e),"#FF00FF",e.name,e.id,e.type,e.owner,e.date);
                map.addLayer(temp);
            
            });

            
            //return temp;
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

        function pointToArray(str){
            var temp = str.location.replace("POINT(",'');
            temp = temp.replace(")",'');
            var newTemp = temp.split(" ");
            return newTemp;
        }
        
        </script>
       

    </body>
</html>