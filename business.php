<script src="modal.js"></script><!--Modal-->
<script src="setBusinessMap.js"></script> <!--Map-->
<script>
    var isAdd = true;
     $(document).ready(function(){
        $("#table-body").load("Controller/businessTable.php");
        $("#all-location").load("Controller/businessLocation.php");
        $("#search-val").change(function(){
            $.post("Controller/businessSearch.php",{
                    searchData:$("#search-val").val(),
                },function(data, status){
                    $("#table-body").html(data);
                });
        });
        $("#all-location").change(function(){
            if($("#all-location").val() != "0"){
                $.post("Controller/businessSetLocation.php",{
                    locationName:$("#all-location").val(),
                },function(data, status){
                    var localdata = data.split("|");
                    setCoordinate(localdata[0]);
                    document.getElementById("map-value").value = localdata[1];
                });
            }
        });

        $("#saveBusiness").click(function(){
            if(isAdd){
                if($("#business-number").val() == "" || $("#business-name").val() == "" || $("#business-type").val() == "" ||  $("#map-value").val() == "" || $("#business-owner").val() == ""){
                    alert("Error: A Data Field has no value");
                }else{
                    alert("Business Successfully Created");
                    $.post("Controller/businessAdd.php",{
                        businessNo: $("#business-number").val(),
                        businessName:$("#business-name").val(),
                        businessOwner:$("#business-owner").val(),
                        businessType:$("#business-type").val(),
                        businessDate:$("#business-date").val(),
                        businessLocation:$("#map-value").val(),
                    },function(data, status){
                        $("#main").load("business.php");
                    });
                }
            }else{
                if($("#business-number").val() == "" || $("#business-name").val() == "" || $("#business-type").val() == "" ||  $("#map-value").val() == "" || $("#business-owner").val() == ""){
                    alert("Error: A Data Field has no value");
                }else{
                    alert("Business Successfully Edited");
                    $.post("Controller/businessEdit.php",{
                        businessId: $("#business-id").val(),
                        businessNo: $("#business-number").val(),
                        businessName:$("#business-name").val(),
                        businessOwner:$("#business-owner").val(),
                        businessType:$("#business-type").val(),
                        businessDate:$("#business-date").val(),
                        businessLocation:$("#map-value").val(),
                    },function(data, status){
                        $("#main").load("business.php");
                    });
                }
            }
        });

       
    });
    
</script>
<script>
    function deleteBusiness(data = ""){
        if(confirm("Do you wish to delete the business "+data.Name+"?")){
            $.post("Controller/businessDelete.php",{
                businessId:data.id,
                businessNo:data.Number,
            },function(data, status){
                $("#main").load("business.php");
            });
        }
    }

    function openBusiness(data = ""){
        openModal('Edit Business',false);
        document.getElementById("business-id").value = data.id;
        document.getElementById("business-number").value = data.Number;
        document.getElementById("business-name").value = data.Name;
        document.getElementById("business-type").value = data.Type;
        document.getElementById("business-owner").value = data.Owner;
        document.getElementById("business-date").value = data.Date;
        document.getElementById("all-location").value = data.Location[0];
        if($("#all-location").val() != "0"){
                $.post("Controller/businessSetLocation.php",{
                    locationName:$("#all-location").val(),
                },function(data, status){
                    var localdata = data.split("|");
                    setCoordinate(localdata[0]);
                    document.getElementById("map-value").value = localdata[1];
                });
            }
    }

    span.onclick = function(){
        document.getElementById("business-id").value = "";
        document.getElementById("business-number").value = "";
        document.getElementById("business-name").value = "";
        document.getElementById("business-type").value = "";
        document.getElementById("business-owner").value = ""
        document.getElementById("business-date").value = "";
        document.getElementById("all-location").value = "";
        modal.style.display = "none";
    }

    document.getElementById("cancel").addEventListener("click",function(e){
        e.preventDefault();
        document.getElementById("business-id").value = "";
        document.getElementById("business-number").value = "";
        document.getElementById("business-name").value = "";
        document.getElementById("business-type").value = "";
        document.getElementById("business-owner").value = ""
        document.getElementById("business-date").value = "";
        document.getElementById("all-location").value = "";
        modal.style.display = "none";
    });

    document.getElementById("saveBusiness").addEventListener("click",function(e){
        e.preventDefault();
        modal.style.display = "none";
    });
</script>
<div>
    <div>
        <div class='title-content'>List of Businesses<div>
        <button class="mui-btn mui-btn--primary modal-open" onclick="openModal('Add New Business')">Add New Business</button>
        <div class="mui-textfield mui-textfield--float-label" style="display:inline-block;width:fit-content;padding:20px;">
            <input type="text" name="search" id="search-val" style="width:400px;">
            <label>Search</label>
        </div>
        <table class="mui-table mui-table--bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Business Number</th>
                    <th>Business Name</th>
                    <th>Business Type</th>
                    <th>Business Owner</th>
                    <th>Business Date</th>
                    <th>Business Location</th>
                </tr>
            </thead>
            <tbody id="table-body">
               
            </tbody>
        </table>
        <div class="modal">
            <div class="modal-content">
                <p class='modal-title' id="modal-title">Add New Business</p><br>
                <form class="mui-form centered">
                <input type="text" style="width:600px;display:none;" id="business-id">
                    <div class="mui-textfield" style="display:block;width:fit-content;padding:5px;">
                        <input type="text" style="width:600px;" id="business-number">
                        <label>Business Number</label>
                    </div>
                    <div class="mui-textfield" style="display:block;width:fit-content;padding:5px;">
                        <input type="text" style="width:600px;" id="business-name">
                        <label>Business Name</label>
                    </div>
                    <div class="mui-textfield" style="display:block;width:fit-content;padding:5px;">
                        <input type="text" style="width:600px;" id="business-owner">
                        <label>Business Owner</label>
                    </div>
                    <div class="mui-textfield" style="display:block;width:fit-content;padding:5px;">
                        <input type="text" style="width:600px;" id="business-type">
                        <label>Business Category</label>
                    </div>
                    <div>
                        <div class="mui-textfield centered" style="display:inline-block;width:fit-content;padding:5px;">
                            <input type="date" value="<?php echo date('Y-m-d'); ?>" style="width:400px;" id="business-date">
                            <label>Date</label>
                        </div>
                        <div class="" style="display:inline-block;width:fit-content;padding:5px;">
                            <label>Location: </label>
                            <select id="all-location">
                            </select>
                        </div>
                    </div>
                    <br>
                    <input style="display:none;" type="text" id="map-value">
                    <div class="business-location">
                        <div id="map-holder-business" style="width:350px;height:250px;" class="centered"></div><br />
                    </div>
                    <div class="centered">
                        <button class="mui-btn mui-btn--primary" id="cancel">Cancel</button>
                        <button class="mui-btn mui-btn--primary" id="saveBusiness">Save Business</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>