<?php
    include "../env.php";
    $dataTable = $db->selectLocation("");
    $str = "<option value='0'>Select</option>";
    $n = 1;
    foreach($dataTable as $val){
        $str = $str . '<option value='.$val->getId().'>'.$val->getName().'</option>';
        $n = $n + 1;
    }
    echo $str;
?>