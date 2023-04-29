<?php
    include "../env.php";
    $dataTable = $db->selectLocation("locationId = '".$_POST["locationName"]."'");
    $m = "";
    foreach($dataTable as $val){
        echo $val->getLocation()."|".$val->getId();
    }
    
    
?>