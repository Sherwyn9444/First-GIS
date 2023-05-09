//var center_point = [121.15166,16.48612];
var center_point = [13486396.215547621,1860735.883408689];
var tooltip = false;
var map_regions = [];
var map_points = [];
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

map.on("pointermove",function(event){
    var ctr = 0;
    var pixel = map.getPixelFromCoordinate(event.coordinate);
    var feature = map.forEachFeatureAtPixel(pixel, function (feature, layer) {
        if(layer){
            if(!tooltip){
                tooltip = true;
                showTooltip(pixel,layer,event);
            }
        }
        ctr++;
    });
    if(ctr == 0){
        closeTooltip();
        tooltip = false;
    }
});

function showTooltip(coor,geo,event){
    var temp = document.getElementById("def-holder");
    
    var def = document.getElementById("business-holder");
    var str = "";
    if(geo.type != "Region"){
        str += "Location ID: "+geo.id+"<br>Location Name: "+geo.name+"<br><br>Businesses:<br>";
        for(var x = 0; x < geo.businesses.length;x++){
            str += "<div class='tooltip-business' onclick=\'displayBusiness("+JSON.stringify(geo.businesses[x])+")\'>"+geo.businesses[x].name+"</div>";
        }
        str += "<br>Location:<br>";
        for(var x = 0; x < geo.location.length;x++){
            str += geo.location[x].type+": "+geo.location[x].name+"<br>";
        }
        str += "<br>Geo Tag: "+geo.coor;
    }else{
        str += "Region Id: "+geo.id+"<br>Region Name: "+geo.name+"<br><br>Businesses:<br>";
    }
    temp.innerHTML = str;
    temp.setAttribute("class","tooltip");
    temp.style.left = coor[0] + 220 + "px";
    temp.style.top = coor[1] - 50 + "px";
    temp.style.transition = "0.5s"
    temp.style.display = "block";
    
}

function displayBusiness(business){
    var temp = document.getElementById("def-holder");
    str = "";
    str += "Number: "+business.number+"<br>Name: "+business.name+"<br>Owner: "+business.owner+"<br>Type: "+business.type+"<br>Date: "+business.date+"<br>Active: "+business.active+"<br>";
    
    str += "";
    temp.innerHTML = str;
}

function closeTooltip(){
    var temp = document.getElementById("def-holder");
    temp.style.display = "none";
}

function createPoint(coordinate,id="as",name="as",businesses=[],location=[]){
        var elem_string = coordinate.substring(coordinate.indexOf("(")+1,coordinate.length-1);
        var coord = elem_string.split(" ");
        coord = ol.proj.fromLonLat([parseFloat(coord[0]),parseFloat(coord[1])]);

        var layer = new ol.layer.Vector({
            source: new ol.source.Vector({
                features: [
                    new ol.Feature(new ol.geom.Point(coord))
                ],
            }),
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
        layer.name = name;
        layer.id = id;
        layer.type = "Single Business";
        layer.businesses = businesses;
        layer.location = location;
        layer.coor =  ol.proj.transform(coord, 'EPSG:3857', 'EPSG:4326');
        map_regions.push(layer);
        return layer;
    }

    function isInside(coordinate, vs) {
        // ray-casting algorithm based on
        // https://wrf.ecse.rpi.edu/Research/Short_Notes/pnpoly.html
        var elem_string = coordinate.substring(coordinate.indexOf("(")+1,coordinate.length-1);
        var coord = elem_string.split(" ");
        var point = [parseFloat(coord[0]),parseFloat(coord[1])];
        
        var x = point[0], y = point[1];
        
        var inside = false;
        var region = [];
        vs.map(function(e){
            for (var i = 0, j = e.location.length - 1; i < e.location.length; j = i++) {
                var xi = e.location[i][0], yi = e.location[i][1];
                var xj = e.location[j][0], yj = e.location[j][1];
                var intersect = ((yi > y) != (yj > y)) && (x < (xj - xi) * (y - yi) / (yj - yi) + xi);
                if (intersect) {
                    inside = !inside
                };
            }
            
            if(inside){
                region.push(e);
                inside = false;
            }
        });
        
        
        return region;
    };

    function createRegion(coordinate){
        coordinates = convert(coordinate);
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

    function hideFeature(feature){
        feature.setStyle(new ol.style.Style({}));   
        feature.set('hidden',true);
    }

    function showFeature(feature,color="red"){
        var style_layer = new ol.style.Style({
            image: new ol.style.Icon({
                color: color,
                crossOrigin: 'anonymous',
                src: 'Icon/Marker_Icon.png',
                scale: 0.05
            }),
        })
        feature.setStyle(style_layer);
        feature.set('hidden',false);
    }

    function calibrate(name, barangay, category, year){
        
        var all_layers = map.getAllLayers();
        for(var l = 1; l < all_layers.length; l++){
        
            var pass = [];
            var ins = false;
            for(var x = 0; x < all_layers[l].businesses.length; x++){
                if(all_layers[l].businesses[x].name.toLowerCase().includes(name)){
                    ins = true;
                    break;
                }   
            }
            if(all_layers[l].name.toLowerCase().includes(name) || name == "" || ins){
                pass.push(true);
            }else{
                pass.push(false);
            }
            

            for(var x = 0; x < all_layers[l].location.length;x++){
                if(all_layers[l].location[x].name.replaceAll(' ','') == barangay || barangay == "0"){
                    pass.push(true);
                }else{
                    pass.push(false);
                }
            }
            
            for(var x = 0; x < all_layers[l].businesses.length;x++){
                if(all_layers[l].businesses[x].type.replaceAll(' ','') == category || category == "0"){
                    pass.push(true);
                }else{
                    pass.push(false);
                }
            }

            for(var x = 0; x < all_layers[l].businesses.length;x++){
                if(all_layers[l].businesses[x].date.substring(0,4).replaceAll(' ','') == year || year == "0"){
                    pass.push(true);
                }else{
                    pass.push(false);
                }
            }

            for(var y = 0; y < pass.length;y++){
                if(pass[y]){
                    showFeature(all_layers[l]);
                }else{
                    hideFeature(all_layers[l]);
                    break;
                }
            }
            
        };
    }
