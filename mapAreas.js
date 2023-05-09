//var center_point = [121.15166,16.48612];
var center_point = [13486396.215547621,1860735.883408689];
var tooltip = false;
var map_regions = [];
var map_points = [];
var selected = null;
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

map.on("singleclick",function(event){
    var ctr = 0;
    var pixel = map.getPixelFromCoordinate(event.coordinate);
    var feature = map.forEachFeatureAtPixel(pixel, function (feature, layer) {
        if(layer){
            showTooltip(pixel,layer,event);
            
        }
        ctr++;
    });
    if(ctr == 0){
        closeTooltip();
    }
});

function showTooltip(coor,geo,event){
    var temp = document.getElementById("def-holder");
    
    var def = document.getElementById("business-holder");
    var str = "";
  
    str += "Region Id: "+geo.id+"<br>Region Name: "+geo.name+"<br>Region Type: "+geo.type+"<br>";
    str += "<br>Coordinates:<br><br>";
    geo.coor.map(function(e){
        str += "[<div class='coor-point'>"+e[0]+"</div>,<div class='coor-point'>"+e[1]+"</div>]<br>";
    });
    str+="<br><div class='btn-contain'><button class='mui-btn mui-btn--primary btn-control'>Edit Region</button></div>";
    str+="<div class='btn-contain'><button class='mui-btn mui-btn--primary btn-control'>Remove Region</button></div>";
    temp.innerHTML = str;
    temp.style.transition = "0.5s";
    selected = geo;
}

function closeTooltip(){
    var temp = document.getElementById("def-holder");
    temp.innerHTML = "";
    selected = null;
}

function createRegion(coordinate,id,name,type){
        var coordinates = raw(coordinate);
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
        layer.name = name;
        layer.id = id;
        layer.type = type;
        layer.coor = coordinate;
        return layer;
    }


    