
<div class="map-container">
    <div id="map-holder" style="width:300px;height:300px;"></div>
</div>
    
<script>
    
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


</script>

