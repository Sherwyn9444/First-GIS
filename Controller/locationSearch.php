<?php
    include "../env.php";
    $search = $_POST["searchData"];
    $dataTable = $db->selectLocation("locationId LIKE '%".$search."%' OR locationName LIKE '%".$search."%'");
    $str = "";
    $n = 0;
    foreach($dataTable as $val){
        $str = $str . '<tr style="height:100px;"><td>'.$val->getId().'</td>';
        $str = $str . '<td>'.$val->getName().'</td>';
        $str = $str . '<td><div id="map-holder-'.$n.'" style="width:200px;height:100px;">'.$val->getLocation().'</div></td>';
        
        $str = $str .  '<td>';
        foreach($val->getClients() as $clie){
            foreach($clie as $c){
                $str = $str .  ''.$c->getName().'<br>';
            }
        }
        $str = $str .  '</td>';
        
        $str = $str .  '<td><button class="mui-btn mui-btn--primary">Edit</button><button class="mui-btn mui-btn--primary">Remove</button></td></tr>';
        $n = $n + 1;
    }
    $str = $str . '<script src="setMapLocation.js" id=0"></script>';
    echo $str;

?>