<?php
    include "../env.php";
    $dataTable = $db->selectArea();
    $str = '';
    foreach($dataTable as $val){
        $str = $str . '';
        $str = $str . '{"id":"' . $val->getId() .'",';
        $str = $str . '"name":"' . $val->getName() .'",';
        $str = $str . '"type":"' . $val->getType() .'",';
        $str = $str . '"location":"' . $val->getLocation() .'"}';
        $str = $str . '|';
    }
    if(substr($str, -1) == '|'){
        $str = rtrim($str, "|");
    }
    
    echo $str;
?>