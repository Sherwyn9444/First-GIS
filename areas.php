<head>
    <style>
        .coor-point{
            width: 150px;
            display: inline-block;
            padding-left: 7px;
        }
        #control-holder{
            display:inline-block;
            vertical-align: top;
            width: 500px;
            padding-left: 15px;
        }
        #def-holder{
            padding-top: 20px;
            padding-left: 15px;
        }
        .btn-contain{
            display: inline-block;
            width: 200px;
            padding-right: 25px;
        }
        .btn-control{
            width: 100%;
        }
    </style>
</head>
<script>
    $(document).ready(function(){       
        $.post("Controller/areaSet.php",{

        },function(data, status){
            $.post("Controller/areaSet.php",{

            },function(data, status){
                var areaData = calibdata(data);
                
                areaData.map(function(e){
                    map.addLayer(createRegion(e.location,e.id,e.name,e.type));
                });
            }); 
        }); 

        $("#saveLocation").click(function(){
            if($("#map-name").val() == "" || $("#map-data").val() == ""){
                alert("Error: A Data Field has no value");
            }else{
                $.post("Controller/areaAdd.php",{
                    areaName: $("#map-name").val(),
                    areaType: "Barangay",
                    areaLocation:$("#map-data").val(),
                },function(data, status){
                    alert("Area Successfully Added."+data);
                    $("#main").load("areas.php");
                }); 
            } 
        });
    });
</script>
<script src="modal.js"></script><!--Modal-->
<script src="mapData.js"></script>
<script src="mapAreas.js"></script>
<script src="addMapArea.js"></script>
<script>
    document.getElementById("cancel").addEventListener("click",function(e){
        e.preventDefault();
        collection_coor = [];
        removePoints();
        modal.style.display = "none";
    });
    document.getElementById("saveLocation").addEventListener("click",function(e){
        e.preventDefault();
        modal.style.display = "none";
    });
</script>
<div>
<div class="map-container">
    <div id="map-title">Map of Areas</div><br>
    <div style="display:inline-block;width:fit-content;">
        <div id="map-holder" style="width:675px;height:500px;"></div>
    </div>
    <div id="control-holder">
        <button class="mui-btn mui-btn--primary" onclick="openModal('Add New Region')">Add a Region</button>
        <div id="def-holder"></div>

    </div>
    
</div>
</div>
<div class="modal">
    <div class="modal-content">
        <p class='modal-title' id="modal-title">Add New Location</p>
        <form class="mui-form">
             <div class="modal-input centered">
                <div class="mui-textfield mui-textfield--float-label" style="display:inline-block;width:fit-content;padding:20px;">
                    <input type="text" name="regionName" id="map-name" style="width:400px;">
                    <label>Name</label>
                </div><br />
            </div>
            <input type="text" name="regionPosition" id="map-data" style="display:none;">
            <div id="map-holder-modal" style="width:700px;height:450px;" class="centered"></div><br />
            <div class="centered">
                <button class="mui-btn mui-btn--primary" id="cancel">Cancel</button>
                <button class="mui-btn mui-btn--primary" id="saveLocation">Save Location</button>
            </div>
        </form>
    </div>
</div>
