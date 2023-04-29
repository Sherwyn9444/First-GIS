<head>
    <style>
        #def-holder{
            position: absolute;
            left: 0;
            top:0;
            padding: 5px;
            background-color: rgba(255, 0, 0, 0.85);
            height: 110px;
            width: 300px;
            overflow: auto;
            display: none;
            padding-top: 15px;
            padding-bottom: 15px;
        }
        #business-holder{
            position: absolute;
            left: 0;
            top:0;
            padding: 5px;
            background-color: rgba(0, 255, 0, 1);
            height: 100px;
            width: 300px;
            overflow: auto;
            display: none;
            padding-top: 15px;
            padding-bottom: 15px;
        }
        #control-holder{
            display:inline-block;
            vertical-align: top;
            padding-left: 15px;
        }
        .control-table{
            width: 100%;
        }
        .label-table{
            width: 75px;
        }
        .select-table select{
            width: 100%;
            height: 35px;
        }
        .btn-filter{
            height: 35px;
            font-size: 12px;
            width: 80px;
            padding-left: 5px;
            padding-right: 5px;
        }
        .filter-table{
            width: 75px;
        }

        .tooltip-business{
            font-size: 16px;
            font-weight: 500;
            color:black;
            cursor: pointer;
            width: fit-content;
        }

        .tooltip-business:hover{
            background-color: black;
            color:white;
        }
        
    </style>
</head>
<script src="mapData.js"></script>
<script src="mapProper.js"></script>
<script>
var all_barangay = [
    {name:"Don Domingo Maddela",location:reverse(Don_Domingo_Maddela),type:"Barangay"},
    {name:"District IV",location:reverse(District_IV),type:"Barangay"},
    {name:"Don Mariano Marcos",location:reverse(Don_Mariano_Marcos),type:"Barangay"},
    {name:"Don Tomas Maddela",location:reverse(Don_Tomas_Maddela),type:"Barangay"},
    {name:"Don Mariano Perez",location:reverse(Don_Mariano_Perez),type:"Barangay"}];

</script>
<script>
     var allPoints = [];
        $(document).ready(function(){
            $("#category").load("Controller/mapCategory.php");
            $("#year").load("Controller/mapYear.php");
            $("#barangay").load("Controller/mapBarangay.php");

            if(allPoints.length == 0){
                $.post("Controller/mapRead.php",{
                businessId: ""
                },function(data, status){
                    var datum = JSON.parse(data);
                    for(var x =0; x < datum.length; x++){
                        map.addLayer(createPoint(datum[x].location,datum[x].id,datum[x].name,datum[x].businesses,isInside(datum[x].location,all_barangay)));
                    }
                });
            }

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
    


