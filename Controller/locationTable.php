<?php
    include "../env.php";
    $dataTable = $db->selectLocation("");
    $str = "";
    $n = 0;
    foreach($dataTable as $val){
        $data = "";
        $data = $data . "{";
        $str = $str . '<tr style="height:100px;"><td>'.$val->getId().'</td>';
        $data = $data . '"id":"'.$val->getId().'",';

        $str = $str . '<td>'.$val->getName().'</td>';
        $data = $data . '"name":"'.$val->getName().'",';

        $str = $str . '<td><div id="map-holder-'.$n.'" style="width:200px;height:100px;">'.$val->getLocation().'</div></td>';
        $data = $data . '"location":"'.$val->getLocation().'",';
        
        if(substr($data, -1) == ','){
            $data = rtrim($data, ",");
        }

        $data = $data . "}";

        $str = $str .  '<td>';
        foreach($val->getClients() as $clie){
            foreach($clie as $c){
                $str = $str .  ''.$c->getName().'<br>';
            }
        }
        $str = $str . '</td>';
        $str = $str . '<td><button class="mui-btn mui-btn--primary" onclick=\'openLocation('.$data.')\'>Edit</button>';
        $str = $str . '<button class="mui-btn mui-btn--primary" onclick=\'deleteLocation('.$data.')\'>Remove</button></td></tr>';
        $n = $n + 1;
    }
    $str = $str . '<script src="setMapLocation.js" id=0"></script>';
    echo $str;

?>