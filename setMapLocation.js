
//var center_point = [121.15166,16.48612
var center_point = [13486396.215547621,1860735.883408689];

var temp_map = 0;
while(document.getElementById('map-holder-'+temp_map)){
    var elem = document.getElementById('map-holder-'+temp_map);
    var str = elem.innerHTML;
    var elem_string = str.substring(str.indexOf("(")+1,str.length-1);
    var coord = elem_string.split(" ");
    coord = ol.proj.fromLonLat([parseFloat(coord[0]),parseFloat(coord[1])]);
    
    elem.innerHTML = "";
    addNewMap(temp_map,coord);
    temp_map++;
}

function addNewMap(ext,coor){
    var mapz = new ol.Map({
        layers:[
            new ol.layer.Tile({
                source: new ol.source.TileJSON({
                    url:'https://api.maptiler.com/maps/openstreetmap/tiles.json?key=iXy9WEaPCZfoCJLTKnjL',
                    tileSize:512,
                })
            }),
            
        ],
        target: 'map-holder-'+ext,
        view: new ol.View({
            center: coor/*ol.proj.fromLonLat(center_point)*/,
            zoom: 15,
            extent: coor.concat(coor),
            constrainOnlyCenter: true,
            smoothExtentConstraint: false
        }),
        
    });
    mapz.getControls().forEach(function(control) {
        if (control instanceof ol.control.Zoom) {
          mapz.removeControl(control);
        }
      }, this);

    mapz.addLayer(createPoint(coor));

}

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
