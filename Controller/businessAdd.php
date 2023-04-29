<?php
    include "../env.php";

    $db->insertBusiness($_POST["businessNo"],$_POST["businessName"],$_POST["businessOwner"],$_POST["businessType"],$_POST["businessDate"]);
    $db->attachBusiness($_POST["businessNo"],$_POST["businessLocation"]);
?>