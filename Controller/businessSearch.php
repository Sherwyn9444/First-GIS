<?php
    include "../env.php";
    $search = $_POST["searchData"];
    $dataTable = $db->selectBusiness("id LIKE '%".$search."%' OR no LIKE '%".$search."%' OR name LIKE '%".$search."%' OR type LIKE '%".$search."%' OR owner LIKE '%".$search."%'");
    $str = "";
    foreach($dataTable as $val){
        $str = $str . '<tr><td>'.$val->getId().'</td>';
        $str = $str . '<td>'.$val->getNumber().'</td>';
        $str = $str .  '<td>'.$val->getName().'</td>';
        $str = $str .  '<td>'.$val->getType().'</td>';
        $str = $str .  '<td>'.$val->getOwner().'</td>';
        $str = $str .  '<td>'.$val->getDate().'</td>';
        $str = $str .  '<td>';
        foreach($val->getLocation() as $location){
            $str = $str . $location->getName();
        }
        $str = $str .  '</td>';
        $str = $str .  '<td><button class="mui-btn mui-btn--primary">Edit</button><button class="mui-btn mui-btn--primary">Remove</button></td></tr>';
    }
    echo $str;

?>