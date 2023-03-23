<?php
    include('db.php');
    include('field.php');
    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    
    //$conn->close();

    $businessId = $_POST['readId']; 
    $allOutput = array();
    if($businessId == null){
        $sql = "SELECT id,name,owner,type,date,ST_AsText(location) as location FROM `profile`";
    }else{
        $sql = "SELECT id,name,owner,type,date,ST_AsText(location) as location FROM `profile` WHERE  id = $businessId";
    }
    $result = $conn->query($sql);
    
    if($result->num_rows > 0) {
        // output data of each row
            while($row = $result->fetch_assoc()) {  
                if(isset($row)){
                    $output = new field($row["id"],$row["name"],$row["owner"],$row["type"],$row["date"],$row["location"]);
                    array_push($allOutput,$output);
                }
            }
        }
    //echo var_dump($output->location);
    echo json_encode($allOutput,JSON_HEX_TAG);
?>
