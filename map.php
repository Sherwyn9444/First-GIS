<head><link rel="stylesheet" href="map.css"></head>
<script src="mapData.js"></script>
<script src="mapProper.js"></script>
<script>
    
     var allPoints = [];
        $(document).ready(function(){
            $.post("Controller/areaSet.php",{

            },function(data, status){
                var areaData = calibdata(data);
                
                if(allPoints.length == 0){
                    $.post("Controller/mapRead.php",{
                    businessId: ""
                    },function(data, status){
                        var datum = JSON.parse(data);
                        for(var x =0; x < datum.length; x++){
                            map.addLayer(createPoint(datum[x].location,datum[x].id,datum[x].name,datum[x].businesses,isInside(datum[x].location,areaData)));
                        }
                    });
                }
            }); 
        
            $("#category").load("Controller/mapCategory.php");
            $("#year").load("Controller/mapYear.php");
            $("#barangay").load("Controller/mapBarangay.php");

            

            $(".select-filter").change(function(){
                calibrate($("#search-val").val(),$("#barangay").val(),$("#category").val(),$("#year").val());
                
            });

            $("#search-val").change(function(){
                calibrate($("#search-val").val(),$("#barangay").val(),$("#category").val(),$("#year").val());
            });
        });
</script>

<div class="map-container">
    <div id="map-title">Map of Businesses</div><br>
    <div id="map-holder" style="width:675px;height:500px;display:inline-block;"></div>
    <div id="control-holder">
        <div class="mui-textfield mui-textfield--float-label" style="display:inline-block;width:fit-content;padding:20px;">
            <input type="text" name="search" id="search-val" style="width:400px;">
            <label>Search</label>
        </div>
        <table class="control-table">
            <tr>
                <td class="label-table"><label>Barangay: </label></td>
                <td class="select-table"><select id="barangay" class="select-filter"></select></td>
                <td class="filter-table"><button class="mui-btn mui-btn--primary btn-filter">Filter OFF</button></td>
            </tr>
            <tr>
                <td class="label-table"><label>Category: </label></td>
                <td class="select-table"><select id="category" class="select-filter"></select></td>
                <td class="filter-table"><button class="mui-btn mui-btn--primary btn-filter">Filter OFF</button></td>
            </tr>
            <tr>
                <td class="label-table"><label>Year: </label></td>
                <td class="select-table"><select id="year" class="select-filter"></select></td>
                <td class="filter-table"><button class="mui-btn mui-btn--primary btn-filter">Filter OFF</button></td>
            </tr>
        </table>
        
  
    </div>
    <div id="def-holder">
        <div id="business-holder">

        </div>
    </div>
</div>

<script>
    
</script>
    


