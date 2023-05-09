<?php
    include "../env.php";

    $db->insertArea($_POST["areaName"],$_POST["areaType"],$_POST["areaLocation"]);
?>