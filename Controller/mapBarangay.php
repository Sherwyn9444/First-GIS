<?php
    include "../env.php";
    $dataTable = $db->getBarangay();
    $str = "<option value='0'>Select</option>";
    $n = 1;
    foreach($dataTable as $val){
        $str = $str . '<option value='.str_replace(' ', '', $val).'>'.$val.'</option>';
        $n = $n + 1;
    }
    echo $str;
?>