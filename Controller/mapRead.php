<?php
    include "../env.php";
    $output = "";
    $allOutput = [];
    $business_ids = $_POST["businessId"];
    if($business_ids == ""){
        $dataTable = $db->selectSummarize("");
    }
    $output = $output . "[";
    foreach($dataTable as $val){
        $output = $output . '{"location":"'.$val->getLocation().'","id":"'.$val->getId().'","name":"'.$val->getName().'","businesses":[';
            
        foreach($val->getClients() as $cli){
            foreach($cli as $clie){
                $output = $output . '{"name":"' . $clie->getName() . '","active":"' . $clie->getActive() . '","id":"' . $clie->getId() . '","owner":"'.$clie->getOwner().'","number":"' . $clie->getNumber() . '","type":"' . $clie->getType() . '","date":"' . $clie->getDate() . '","active":"' . $clie->getActive() . '"},';
            }
        }
        if(substr($output,-1) == ","){
            $output = substr($output, 0, -1);   
        }
        $output = $output . ']},';
    }
    if(substr($output,-1) == ","){
        $output = substr($output, 0, -1);   
    }
    $output = $output . "]";
    echo $output;
?>