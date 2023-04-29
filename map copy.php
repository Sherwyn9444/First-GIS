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
        <script src="https://cdn.jsdelivr.net/npm/ol@v7.2.2/dist/ol.js"></script>   <!--Map-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v7.2.2/ol.css">    <!--Map-->
    <script src="https://cdn.jsdelivr.net/npm/elm-pep@1.0.6/dist/elm-pep.js"></script> <!--Map-->
    </head>
    <body>
        <div id="map-holder" style="width:800px;height:600px;"></div>

        <div id="point-information">
            <div class="point-info" id="point-class">Point</div><br>
            <div class="point-info">Name: </div><input type='text' id='point-txt-name'>
            <div class="point-info">Id: </div><input type='text' id='point-txt-id'>
            <div class="point-info">Type: </div><input type='text' id='point-txt-type'>
            <div class="point-info">Owner: </div><input type='text' id='point-txt-owner'>
            <div class="point-info">Coordinates: </div><input type='text' id='point-txt-coor'>
            <input type="button" id="map-btn-savearea" value="Save as Area">
        </div>
        <div id="map-controller">
            <input type="text" id="map-txt-search" placeholder="Search">
            <input type="button" id="map-btn-search" value="Search">
            <input type="button" id="map-btn-point" value="Add Point">
            <input type="button" id="map-btn-viewarea" value="View Barangay">
            <input type="button" id="map-btn-reset" value="Clear">
            <input type="button" id="map-btn-getdata" value="Data">
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
            
            var Salvacion = [
[16.48278364657887, 121.15018399523653],
[16.47953058164487, 121.1483235356914],
[16.47865722811601, 121.14696710991034],
[16.47806256173532, 121.14564274894676],
[16.47680938873711, 121.14673587230125],
[16.479448112395506, 121.15147947133437],
[16.47990838776863, 121.15226778150812],
[16.480946523104766, 121.15344148773107],
[16.482743928712843, 121.1503723336287],
]


var Bonfal_West = [
[16.503573935994787, 121.17024286214819],
[16.49405827946152, 121.1597811639333],
[16.492581077816133, 121.16193082795006],
[16.492615431470842, 121.16372221463068],
[16.491413049927527, 121.16350724822901],
[16.490949622338377, 121.16385352940237],
[16.49047382645036, 121.16367124929897],
[16.487920044861177, 121.16670925102218],
[16.492755694053198, 121.17186372742917],
[16.496128957954, 121.17757066401852],
[16.49743978305767, 121.17850231796577],
]

var Bonfal_East = [
[16.498846434223037, 121.18276110279646],
[16.496644986385654, 121.17979994430975],
[16.49734451458212, 121.17881289148085],
[16.496001704563273, 121.17750389025326],
[16.492684454374213, 121.17189831102519],
[16.48789068398697, 121.16675705223697],
[16.488555455870817, 121.17833405318139],
[16.492504896575152, 121.1877909119123],
]

var Bonfal_Proper = [
[16.511890110726643, 121.17211783391534],
[16.50743233222222, 121.16768631045007],
[16.504381480740026, 121.171885360466],
[16.502584381333538, 121.17056316830407],
[16.496900422133457, 121.17977492543993],
[16.502222173199193, 121.18699612961142],
[16.504242171250425, 121.18615341367897],
]

var Don_Mariano_Perez = [
[16.489842919051878, 121.14233330935222],
[16.486424651562057, 121.14098976934176],
[16.484260290185674, 121.13921629652792],
[16.481821060272075, 121.14545032217654],
[16.486046748938268, 121.14878230140252],
[16.486304409898143, 121.14797617739623],
] 

var Don_Domingo_Maddela = [
[16.484155997321086, 121.14771016578682],
[16.47976303051097, 121.14380486981158],
[16.4784461498531, 121.1460364675117],
[16.479611751720444, 121.14832028172347],
[16.482861851241793, 121.15012378849148],
]

var Don_Tomas_Maddela = [
[16.487712660068304, 121.14721435427866],
[16.487053001947256, 121.14714139043473],
[16.484404352012152, 121.1444834218346],
[16.48341484707927, 121.14530687093031],
[16.48014506024489, 121.14610054498235],
[16.481701477524854, 121.14814815261035],
[16.485484716598485, 121.15130696193889],
[16.48645445901525, 121.14873496699153],
[16.48652629159363, 121.14809821096088],

]

var Don_Mariano_Marcos = [
[16.485297930176507, 121.15425463339098],
[16.484195573087828, 121.15212827320714],
[16.48284754809877, 121.15042336513461],
[16.480775299874686, 121.15383318137027],
[16.481585558754375, 121.15728038603613],
[16.482137680105115, 121.15745985004381],
[16.48266111837362, 121.1571607433644],
[16.482955103629962, 121.15717569869838],
[16.483574331899383, 121.15709667309898],
[16.484303620324237, 121.15688356281095],
[16.48448361661842, 121.1569041339645],
[16.484421974072433, 121.15641214048841],

]

var District_IV = [
[16.4917650184235, 121.15964518632514],
[16.489207206866546, 121.15211062303062],
[16.488088662558013, 121.15146754366994],
[16.48689840959312, 121.15097401764896],
[16.486009300150254, 121.15220035524246],
[16.48620826341038, 121.15328008676322],
[16.484452792341706, 121.15559029083708],
[16.4848057665578, 121.15611736348461],
[16.484427746482446, 121.156384222984],
[16.484526613342645, 121.15658436760859],
[16.484544060430395, 121.15684516211938],
[16.48444519356502, 121.15697252695064],
[16.4843172481531, 121.15694826699617],
[16.4835923557649, 121.15717829664216],
[16.482995416211356, 121.15719587856849],
[16.482677251810625, 121.15725946332644],
[16.48315107826841, 121.15844535363308],
[16.4846799496136, 121.16009072390683],
[16.48458796822728, 121.16019156736309],
[16.48662288237634, 121.16507978423172],
[16.488183110766922, 121.16399553140779],
]

var Luyang = [
[16.49749003062404, 121.14512311895035],
[16.495720854045953, 121.14283014399915],
[16.491468309343464, 121.14243223963541],
[16.490330986093156, 121.14175802736763],
[16.487337998173995, 121.14636514460567],
[16.489337319236476, 121.15218334703592],
[16.494772494820296, 121.1554295543709],
[16.494760523235836, 121.15198358055794],
[16.495280093652582, 121.14958922486467],
[16.49592073077248, 121.14800088108068],
[16.49557092718813, 121.14736505329789],
]

var Vista_Alegre = [
[16.476611255583894, 121.13826447247831],
[16.475898357075703, 121.13717172660314],
[16.474996493758546, 121.13847048194657],
[16.476130264107226, 121.14151583930365],
[16.47513392082087, 121.1427250253131],
[16.47374246731173, 121.14292207784797],
[16.47357872391219, 121.14392002967679],
[16.474188560220345, 121.14621300462801],
[16.474686734934917, 121.14708182716811],
[16.476980039979722, 121.1471534826731],
[16.476834025114226, 121.1465891958687],
[16.478182511157062, 121.14562184706116],
[16.47859478527088, 121.14373193411309],
[16.47722053481235, 121.14233465250221],
[16.477641400051, 121.14134043289445],

]

var San_Nicolas = [
[16.489114681528203, 121.15191584328521],
[16.48725997359615, 121.1464566178887],
[16.485961001943053, 121.14873520564545],
[16.484296868820397, 121.14758654774869],
[16.48284822329595, 121.1502459407361],
[16.48423388522466, 121.15209136148111],
[16.485034900937023, 121.15361861360478],
[16.486891375211666, 121.15089794867424],
[16.488120845975867, 121.15140878113266],
]

var Magsaysay = [
[16.496287819929265, 121.1176213003093],
[16.48795777838308, 121.11805824323496],
[16.483028913865198, 121.12547218916983],
[16.482307450108504, 121.13656087272297],
[16.492132868509984, 121.13604137061292],
]

var Masoc = [
[16.50788852200057, 121.10760568847698],
[16.502765727380027, 121.10054611498332],
[16.50225138307383, 121.11224054523879],
[16.499494474277967, 121.11616729888424],
[16.49867150881285, 121.11910699970076],
[16.50225138307383, 121.11792682784011],
[16.5025599898217, 121.11732601307469],
[16.503341791378958, 121.12105964768838],
[16.50755935052309, 121.11921428805171],
[16.508361705017563, 121.11728309773429],
]

var Busilac = [
[16.487595507543578, 121.1160216402355],
[16.473962108088898, 121.10847509409238],
[16.45664910668892, 121.10459758675229],
[16.456089307180186, 121.10814154488581],
[16.4694840664109, 121.11777277228391],
[16.4736810615694, 121.12752225416112],
[16.483009528735877, 121.12523413975451],
]

var La_Torre_North = [
[16.50345855965735, 121.14055564289488],
[16.499301956125056, 121.13489486098409],
[16.49780761815062, 121.13525313832021],
[16.49490479070553, 121.14250825437678],
[16.496038444476767, 121.1430814981146],
[16.497893499956053, 121.1403227626264],
[16.500332527312512, 121.14259782371083],
[16.501534853424612, 121.14249034050998],
[16.501912943871403, 121.14138920612488],
[16.50301414323605, 121.1419747476164],
]

var La_Torre_South = [
[16.504967102891822, 121.12054472725023],
[16.50323892027185, 121.12112408434545],
[16.502583398278905, 121.11801672868194],
[16.49875312555196, 121.11918113002434],
[16.500436393760822, 121.12423284046375],
[16.49892488824316, 121.12817389139904],
[16.49244932763369, 121.1360918208827],
[16.495266308983663, 121.13793694916374],
[16.50137042401472, 121.12515403413443],
[16.50340417960772, 121.12300602709563],
[16.504605633010133, 121.12251871782804],
]

var Vista_Hills = [
[16.46252925476278, 121.08922712425472],
[16.447012806823835, 121.08085863287921],
[16.44342277884136, 121.1073946580438],
[16.452516444755364, 121.10727501537207],
[16.455872674346008, 121.10847144208964],

]

var Santa_Rosa = [
[16.493966754026808, 121.15951869062273],
[16.4920476331766, 121.15812499509764],
[16.491515098886808, 121.15854415164655],
[16.49180648575521, 121.15971778998347],
[16.48824952636422, 121.1639931868537],
[16.486621743464468, 121.16510395184274],
[16.487406741153325, 121.16700837017385],
[16.490406142015512, 121.1634647209988],
[16.4907352859317, 121.16374225321977],
[16.491169474966767, 121.16340629309856],
[16.49235298517235, 121.16372764619653],
[16.49225494320512, 121.16196020391133],
]
            var container = document.getElementById('popup');
            var content = document.getElementById('popup-content');
            var closer = document.getElementById('popup-closer');
            var map_txt_lat = document.getElementById("map-txt-lat");
            var map_txt_lon = document.getElementById("map-txt-lon");
            var map_txt_zoom = document.getElementById("map-txt-zoom");
            var point_txt_name = document.getElementById("point-txt-name");
            var point_txt_id = document.getElementById("point-txt-id");
            var point_txt_type = document.getElementById("point-txt-type");            
            var point_txt_owner = document.getElementById("point-txt-owner");
            var point_txt_coor = document.getElementById("point-txt-coor");
            var map_btn_search = document.getElementById("map-btn-search");
            var map_btn_point = document.getElementById("map-btn-point");
            var map_btn_savearea = document.getElementById("map-btn-savearea");
            var map_btn_viewarea = document.getElementById("map-btn-viewarea");
            var map_btn_reset = document.getElementById("map-btn-reset");
            var map_btn_getdata = document.getElementById("map-btn-getdata");
            var open_point = false;
            var open_poly = false;
            var recent_click = null;
            var barangay = [Salvacion,Bonfal_East,Bonfal_Proper,Bonfal_West,Don_Domingo_Maddela,District_IV,Don_Mariano_Marcos,Santa_Rosa,Don_Mariano_Perez,Luyang,Vista_Alegre,San_Nicolas,Magsaysay,Masoc,Busilac,La_Torre_North,La_Torre_South,Vista_Hills];
            var barangay_name = ['Salvacion','Bonfal East','Bonfal Proper','Bonfal West','Don Domingo Maddela','District IV','Don Mariano Marcos','Santa Rosa','Don Mariano Perez','Luyang','Vista Alegre','San Nicolas','Magsaysay','Masoc','Busilac','La Torre North','La Torre South','Vista Hills'];
            var barangay_area = [];
            var barangay_collection = [];
            var collect_point = [];
            //var center_point = [121.15166,16.48612];
            var center_point = [13486396.215547621,1860735.883408689];

            map_btn_point.addEventListener('click',function(){
                if(open_point){
                    open_point = false;
                }else{
                    open_point = true;
                }
                collect_point = [];
            });

            map_btn_savearea.addEventListener('click',function(){
                var all_layers = map.getAllLayers();
                var recent = null;
                for(var l = 1; l < all_layers.length; l++){
                    if(all_layers[l].name == 'temp'){
                        map.removeLayer(all_layers[l]);
                    }
                }
                recent_click.name = point_txt_name.value;
                recent_click.id = point_txt_id.value;
                recent_click.type = point_txt_type.value;
                recent_click.coor = point_txt_coor.value;
            });

            map_btn_viewarea.addEventListener('click',function(){
                var all_layers = map.getAllLayers();
                for(var l = 1; l < all_layers.length; l++){
                    if(all_layers[l].name == "temp"){
                        map.removeLayer(all_layers[l]);
                    }
                }
                for(var z = 0; z < barangay.length; z++){
                    for(var x =0; x< barangay[z].length ; x++){
                        var temp = barangay[z][x][0];
                        barangay[z][x][0] = barangay[z][x][1];
                        barangay[z][x][1] = temp;
                    }
                    barangay[z].map(function(e){
                        barangay_area.push(ol.proj.fromLonLat(e));    
                    });
                    var temp_layer = createPoly(barangay_area);
                    temp_layer.name = barangay_name[z];
                    temp_layer.type = "Barangay";
                    map.addLayer(temp_layer);
                    barangay_collection.push({name:temp_layer.name,type:temp_layer.type,area:barangay_area});
                    barangay_area = [];
                }
                console.log(barangay_collection);
            });

            map_btn_reset.addEventListener('click',function(){
                var all_layers = map.getAllLayers();
                for(var l = 1; l < all_layers.length; l++){
                    if(all_layers[l].name == 'temp'){
                        map.removeLayer(all_layers[l]);
                    }
                }
            });

            map_btn_getdata.addEventListener('click',function(){
                var all_layers = map.getAllLayers();
                for(var l = 1; l < all_layers.length; l++){
                   console.log(all_layers[l]);
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
                    center: center_point/*ol.proj.fromLonLat(center_point)*/,
                    zoom: 17,
                })
            });

            map.on('singleclick', function (event) {
                var coordinate = event.coordinate;
                var double = true;
                
                if (map.hasFeatureAtPixel(event.pixel) === true) {
                    map_txt_lat.value = coordinate[0];
                    map_txt_lon.value = coordinate[1];
                    setInfo(event,coordinate);
                } else {

                }
                if(open_point){
                    var temp_layer = createPoint(coordinate, "#0000FF");
                    map.addLayer(temp_layer);
                    collect_point.push(coordinate);
                    point_txt_name.value = temp_layer.name;
                    point_txt_id.value = temp_layer.id;
                    point_txt_type.value = temp_layer.type;
                    point_txt_coor.value = temp_layer.coor;
                    //open_point = false;
                    var yey = map.getView();
                    yey.animate({
                        center:coordinate,
                        duration:750,
                    });
                    var ctr = false; 
                    
                    var feature = map.forEachFeatureAtPixel(event.pixel, function (feature, layer) {
                        if(layer.name == "temp"){
                            ctr = true;
                        }
                    });
                    if (map.hasFeatureAtPixel(event.pixel) === true && ctr) {
                        var temp_area = createPoly(collect_point);
                        temp_area.name = "Area";
                        map.addLayer(temp_area);
                        recent_click = temp_area;
                        open_point = false;
                        collect_point = [];
                    }
                }
                
                
            });

            map.getView().on('change:resolution', function(event){
                map_txt_zoom.value = map.getView().getZoom();
            });
            
        function setInfo(event, coordinate){
            var feature = map.forEachFeatureAtPixel(event.pixel, function (feature, layer) {
                //console.log(layer.name, layer.id, layer.coor);
                point_txt_name.value = layer.name;
                point_txt_id.value = layer.id;
                point_txt_type.value = layer.type;
                point_txt_coor.value = layer.coor;
                recent_click = layer;
                var yey = map.getView();
                yey.animate({
                    center:coordinate,
                    duration:750,
                });
            });
        }
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
            layer.name = "temp";
            layer.id = '1';
            layer.type = 'Point';
            layer.coor =  ol.proj.transform(coordinate, 'EPSG:3857', 'EPSG:4326');
            return layer;
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
            layer.name = "poly";
            layer.id = '1';
            layer.type = 'Region';
            layer.coor = coordinates;
            return layer;
        }
        </script>
       

    </body>
</html>