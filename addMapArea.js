
//var center_point = [121.15166,16.48612];
var center_point = [13486396.215547621,1860735.883408689];
var collection_layer = [];
var collection_coor = [];
var pointFeature = null;

var map_modal = new ol.Map({
    layers:[
        new ol.layer.Tile({
            source: new ol.source.TileJSON({
                url:'https://api.maptiler.com/maps/openstreetmap/tiles.json?key=iXy9WEaPCZfoCJLTKnjL',
                tileSize:512,
            })
        }),
        
    ],
    target: 'map-holder-modal',
    view: new ol.View({
        center: center_point/*ol.proj.fromLonLat(center_point)*/,
        zoom: 17,
    })
});

map_modal.on("singleclick",function(event){
    reset();
    if(checkPoint(event.coordinate)){
        if(pointFeature.residue == "point"){
            
        }else{
            map_modal.addLayer(createModalPoint(event.coordinate));
        }
    }else{
        map_modal.addLayer(createModalPoint(event.coordinate));
    }
    
    mapClick(event);
    setData();
    ;
})

function checkPoint(coordinate){
    var pixel = map_modal.getPixelFromCoordinate(coordinate);
    if(map_modal.hasFeatureAtPixel(pixel)){
        var feature = map_modal.forEachFeatureAtPixel(pixel, function (feature, layer) {
            pointFeature = layer;
        });
        return true;
    }else{
        pointFeature = null;
        return false;
    }
}



function createModalPoint(coordinate){
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
        image: new ol.style.Circle({
            fill: new ol.style.Fill({
                color: 'black'
            }),
            radius: 6
        }),
        text: new ol.style.Text({
            text: collection_coor.length+"",
            textAlign: 'center',

            font: '12px roboto,sans-serif',
            fill: new ol.style.Fill({
                color: 'white'
            }),
            offsetX: 0,
            offsetY: 0.6,
        })
    })
    layer.setStyle(style_layer);
    layer.residue = "point";
    layer.id = collection_coor.length;
    layer.coor =  ol.proj.transform(coordinate, 'EPSG:3857', 'EPSG:4326');
    collection_coor.push(coordinate);
    collection_layer.push(layer);
    map_modal.addLayer(createModalPoly());
    return layer;
}

function createModalPoly(){
    var layer = new ol.layer.Vector({
        source: new ol.source.Vector({
            features: [
                new ol.Feature(new ol.geom.Polygon([collection_coor]))
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
    layer.residue = "temp";
    return layer;
}
function reset(){
    var all_layers = map_modal.getAllLayers();
    for(var l = 1; l < all_layers.length; l++){
        if(all_layers[l].residue == 'temp'){
            map_modal.removeLayer(all_layers[l]);
        }
    }
}

function removePoints(){
    var all_layers = map_modal.getAllLayers();
    for(var l = 1; l < all_layers.length; l++){
        if(all_layers[l].residue == 'point' || all_layers[l].residue == 'temp'){
            map_modal.removeLayer(all_layers[l]);
        }
    }
}

function setData(){
    var temp_coor = [];
    for(var x = 0; x < collection_coor.length;x++){
        temp_coor.push(ol.proj.transform(collection_coor[x], 'EPSG:3857', 'EPSG:4326'));
    }
    var dataField = document.getElementById("map-data");
    var str = "multipoint(";
    for(var x = 0; x < temp_coor.length;x++){
        str += ""+temp_coor[x][0]+" "+temp_coor[x][1]+",";
    }
    if(str.charAt(str.length-1) == ","){
        str = str.substring(0,str.length-1);
    }
    str += ")";
    console.log(str);
    dataField.value = str;
}

var mapClick = function(event){

}