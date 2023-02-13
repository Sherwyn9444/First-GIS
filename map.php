<html>
    <head>

    </head>
    <body>
        <div id="map-holder" style="width:400px;height:400px;"></div>
        <div id="map-controller">
            <input type="text" id="map-txt-search" placeholder="Search">
            <input type="button" id="map-btn-search" value="Search">
            <input type="button" id="map-btn-point" value="Add Point">
            <input type="button" id="map-btn-savepoint" value="Save as Point">
            <input type="button" id="map-btn-saveregion" value="Save as Region">
            <input type="button" id="map-btn-reset" value="Reset">
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
            var container = document.getElementById('popup');
            var content = document.getElementById('popup-content');
            var closer = document.getElementById('popup-closer');
            var map_txt_lat = document.getElementById("map-txt-lat");
            var map_txt_lon = document.getElementById("map-txt-lon");
            var map_txt_zoom = document.getElementById("map-txt-zoom");
            var map_btn_search = document.getElementById("map-btn-search");
            var map_btn_point = document.getElementById("map-btn-point");
            var map_btn_savepoint = document.getElementById("map-btn-savepoint");
            var map_btn_saveregion = document.getElementById("map-btn-saveregion");
            var map_btn_reset = document.getElementById("map-btn-reset");
            var open_point = false;
            var open_poly = false;
            var collect_point = [];
            var center_point = [121.15166,16.48612];
            var cr_point = [121.15196,16.48642];
            var all_point = [
                [13486545.87727408,1861064.2844393428],
                [13486548.743655343,1861123.523125329],
                [13486587.917654209,1861100.5920569364],
                [13486601.29411229,1861070.0172383327]
            ];

            map_btn_point.addEventListener('click',function(){
                if(open_point){
                    open_point = false;
                }else{
                    open_point = true;
                }
                collect_point = [];
            });

            map_btn_saveregion.addEventListener('click',function(){
               
                var temp_layer = createPoly(collect_point);
                map.addLayer(temp_layer);

                collect_point = [];
            });

            map_btn_reset.addEventListener('click',function(){
                var all_layers = map.getAllLayers();
                for(var l = 1; l < all_layers.length; l++){
                    map.removeLayer(all_layers[l]);
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
                    center: ol.proj.fromLonLat(center_point),
                    zoom: 17,
                })
            });

            map.on('singleclick', function (event) {
                var coordinate = event.coordinate;
                if (map.hasFeatureAtPixel(event.pixel) === true) {
                    map_txt_lat.value = coordinate[0];
                    map_txt_lon.value = coordinate[1];
                   
                } else {
                    map_txt_lat.value = coordinate[0];
                    map_txt_lon.value = coordinate[1];
                   
                }
                if(open_point){
                    map.addLayer(createPoint(coordinate, "#0000FF"));
                    collect_point.push(coordinate);
                }
            });

            map.getView().on('change:resolution', function(event){
                map_txt_zoom.value = map.getView().getZoom();
            });
            
        
        function createPoint(coordinate, color){
            var layer = new ol.layer.Vector({
                source: new ol.source.Vector({
                    features: [
                        new ol.Feature(new ol.geom.Point(coordinate))
                    ],
                }),
                
                style: new ol.style.Style({
                    
                    image: new ol.style.Icon({
                        color: color,
                        crossOrigin: 'anonymous',
                        src: 'Icon/Marker_Icon.png',
                        scale: 0.05
                    }),
                })
                
            });
            return layer;
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
            return layer;
        }
        </script>
       

    </body>
</html>