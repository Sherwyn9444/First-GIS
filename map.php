<html>
    <head>

    </head>
    <body>
        <div id="map-holder" style="width:400px;height:400px;"></div>
        <script>
            
            var map = new ol.Map({
                layers:[
                    new ol.layer.Tile({
                        source: new ol.source.TileJSON({
                            url:'https://api.maptiler.com/maps/openstreetmap/tiles.json?key=iXy9WEaPCZfoCJLTKnjL',
                            tileSize:512,
                        })
                    })
                ],
                target: 'map-holder',
                view: new ol.View({
                    center: ol.proj.fromLonLat([121.15166,16.48612]),
                    zoom: 17,
                })
            });
        </script>
    </body>
</html>