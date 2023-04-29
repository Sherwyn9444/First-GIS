<script>
    var isAdd = true;
     $(document).ready(function(){
        $("#table-body").load("Controller/locationTable.php");
        $("#search-val").change(function(){
            $.post("Controller/locationSearch.php",{
                    searchData:$("#search-val").val(),
                },function(data, status){
                    $("#table-body").html(data);
                });
        });
        $("#saveLocation").click(function(){
            if(isAdd){
                if($("#map-number").val() == "" || $("#map-name").val() == "" || $("#map-data").val() == ""){
                    alert("Error: A Data Field has no value");
                }else{
                    $.post("Controller/locationAdd.php",{
                        locationNo: $("#map-number").val(),
                        locationName:$("#map-name").val(),
                        locationPoint:$("#map-data").val(),
                    },function(data, status){
                        alert("Location Successfully Created."+data);
                        $("#main").load("location.php");
                    }); 
                }
            }else{
                if($("#map-number").val() == "" || $("#map-name").val() == "" || $("#map-data").val() == ""){
                    alert("Error: A Data Field has no value");
                }else{
                    $.post("Controller/locationEdit.php",{
                        locationNo: $("#map-number").val(),
                        locationName:$("#map-name").val(),
                        locationPoint:$("#map-data").val(),
                    },function(data, status){
                        alert("Location Successfully Edit."+data);
                        $("#main").load("location.php");
                    }); 
                }
            }
            
        });
    });
</script>
<script src="modal.js"></script><!--Modal-->

<script src="addMapLocation.js"></script> <!--Map-->
<script>
    function deleteLocation(data = ""){
        if(confirm("Do you wish to delete the location "+data.name+"?")){
            $.post("Controller/locationDelete.php",{
                locationNo:data.id,
            },function(data, status){
                $("#main").load("location.php");
            });
        }
    }

    function openLocation(data = ""){
        openModal("Edit Location",false);
        document.getElementById("map-data").value = data.location;
        document.getElementById("map-number").value = data.id;
        document.getElementById("map-name").value = data.name;
        
        var elem_string = data.location.substring(data.location.indexOf("(")+1,data.location.length-1);
        var coord = elem_string.split(" ");
        coord = ol.proj.fromLonLat([parseFloat(coord[0]),parseFloat(coord[1])]);

        reset();

        var mapView = map.getView();
        mapView.animate({
            center:coord,
            duration:750,
        });
        map.addLayer(createPoint(coord));
    }

    mapClick = function(event){
        var geometry = ol.proj.transform([event.coordinate[0],event.coordinate[1]],'EPSG:3857','EPSG:4326');
        document.getElementById("map-data").value = "'Point("+geometry[0]+" "+geometry[1]+")'";;
        
    }
    document.getElementById("cancel").addEventListener("click",function(e){
        e.preventDefault();
        modal.style.display = "none";
    });
    document.getElementById("saveLocation").addEventListener("click",function(e){
        e.preventDefault();
        modal.style.display = "none";
    });
</script>
<div>
    <div>
        <div class='title-content'>List of Location</div><div id = 'container'">
        <button class="mui-btn mui-btn--primary modal-open" onclick="openModal('Add New Location')">Add New Location</button>
        <div class="mui-textfield mui-textfield--float-label" style="display:inline-block;width:fit-content;padding:20px;">
            <input type="text" name="search" id="search-val" style="width:400px;">
            <label>Search</label>
        </div>
        <table class="mui-table mui-table--bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Businesses</th>
                </tr>
            </thead>
            <tbody id="table-body">
                
            </tbody>
        </table>
        </div>
        
        <div class="modal">
            <div class="modal-content">
                <p class='modal-title' id="modal-title">Add New Location</p>
                <form class="mui-form">
                    
                    <div class="modal-input centered">
                        <div class="mui-textfield mui-textfield--float-label" style="display:inline-block;width:fit-content;padding:20px;">
                            <input type="text" name="LocationNumber" id="map-number" style="width:100px;">
                            <label>No</label>
                        </div>
                        <div class="mui-textfield mui-textfield--float-label" style="display:inline-block;width:fit-content;padding:20px;">
                            <input type="text" name="locationName" id="map-name" style="width:400px;">
                            <label>Name</label>
                        </div><br />
                    </div>
                    <input type="text" name="locationPosition" id="map-data" style="display:none;">
                    <div id="map-holder" style="width:700px;height:450px;" class="centered"></div><br />
                    <div class="centered">
                        <button class="mui-btn mui-btn--primary" id="cancel">Cancel</button>
                        <button class="mui-btn mui-btn--primary" id="saveLocation">Save Location</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>