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
    target: 'map-holder-business',
    view: new ol.View({
        center: center_point/*ol.proj.fromLonLat(center_point)*/,
        zoom: 17,
    })
});

function setCoordinate(coordinate){
    var elem_string = coordinate.substring(coordinate.indexOf("(")+1,coordinate.length-1);
    var coord = elem_string.split(" ");
    coord = ol.proj.fromLonLat([parseFloat(coord[0]),parseFloat(coord[1])]);

    reset();
    map.addLayer(createPoint(coord));
    var mapView = map.getView();
    mapView.animate({
        center:coord,
        duration:750,
    });
}
/*
map.on("singleclick",function(event){
    reset();
    map.addLayer(createPoint(event.coordinate));
    mapClick(event);
})*/

function createPoint(coordinate){
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
                color: "red",
                crossOrigin: 'anonymous',
                src: 'Icon/Marker_Icon.png',
                scale: 0.05
            }),
        })
    layer.setStyle(style_layer);
    layer.residue = "temp";
    layer.coor =  ol.proj.transform(coordinate, 'EPSG:3857', 'EPSG:4326');
    return layer;
}

function reset(){
    var all_layers = map.getAllLayers();
    for(var l = 1; l < all_layers.length; l++){
        if(all_layers[l].residue == 'temp'){
            map.removeLayer(all_layers[l]);
        }
    }
}

var mapClick = function(event){

}