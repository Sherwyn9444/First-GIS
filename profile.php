<html>
    <head>
        <?php
            
        ?>
    <script>
        $(document).ready(function(){
            
            $("#prof-view").click(function(){
                $("#prof-main").load("view.php");        
            });
            $("#prof-create").click(function(){
                $("#prof-main").load("create-map.php");        
            });
        });
        function addField(id,name,type,owner,location){
            var prof_id = id;
            var prof_name = name;
            var prof_type = type;
            var prof_owner = owner;
            var prof_location = location;
            $.post("create.php",{
                createId: prof_id,
                createName:prof_name,
                createOwner:prof_owner,
                createType:prof_type,
                createLocation:prof_location,
            },function(data, status){
                alert(data);
                $("#prof-main").load("create-map.php");   
            });
        }
        function deleteField(e){
            var delete_id = e;
            $.post("read.php",{
                readId: delete_id
            },function(data, status){
                var datum = JSON.parse(data);
                console.log(datum);
                $.post("delete.php",{
                    deleteId: datum[0].id,
                    deleteName: datum[0].name,
                    deleteOwner: datum[0].owner,
                    deleteType: datum[0].type,
                    deleteLocation: datum[0].location
                },function(data, status){
                    if(data == 1){
                        alert("Deleted Successfully");
                        $("#prof-main").load("view.php"); 
                    }
                });
            });
        }
        function viewOnMap(location){
            $.post("read.php",{
                readId: location
            },function(data, status){
                var datum = JSON.parse(data);
                $("#main").load("map.php"); 
                setTimeout(function(){mapSelect(datum[0])},10);
            });        
        }
    </script>
    <style>
        #prof-main{
            width: 800px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        #prof-table{
            width:600px;
            background-color: grey;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        #prof-table td{
            width: 100px;
            height:25px;
        }
    </style>
    </head>
    <body>
        <div id="prof-holder">
            <input type='button' value='Add New' id='prof-create'>
            <input type='button' value='View All' id='prof-view'>
        </div>
        <div id="prof-main"></div>
    </body>
</html>