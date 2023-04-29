<?php
    include "../env.php";
    $dataTable = $db->selectBusiness("");
    $str = "";
    
    foreach($dataTable as $val){
        $data = '';
        $data = $data . '{';
        $str = $str . '<tr><td>'.$val->getId().'</td>';
        $data = $data . '"id":"'.$val->getId().'",';

        $str = $str . '<td>'.$val->getNumber().'</td>';
        $data = $data . '"Number":"'.$val->getNumber().'",';

        $str = $str .  '<td>'.$val->getName().'</td>';
        $data = $data . '"Name":"'.$val->getName().'",';

        $str = $str .  '<td>'.$val->getType().'</td>';
        $data = $data . '"Type":"'.$val->getType().'",';

        $str = $str .  '<td>'.$val->getOwner().'</td>';
        $data = $data . '"Owner":"'.$val->getOwner().'",';

        $str = $str .  '<td>'.$val->getDate().'</td>';
        $data = $data . '"Date":"'.$val->getDate().'",';

        $str = $str .  '<td>';
        $data = $data . '"Location":[';
        foreach($val->getLocation() as $location){
            $str = $str . $location->getName() . "<br>";
            $data = $data . ''.$location->getId().',';
        }
        if(substr($data, -1) == ','){
            $data = rtrim($data, ",");
        }
        $data = $data . ']';
        $data = $data . "}";
        $str = $str . '</td>';
        $str = $str . '<td><button class="mui-btn mui-btn--primary" onclick=\'openBusiness('.$data.')\'>Edit</button>';
        $str = $str . '<button class="mui-btn mui-btn--primary" id="remove-business" onclick=\'deleteBusiness('.$data.')\'>Remove</button></td></tr>';
    }
    echo $str;

?>