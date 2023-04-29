<?php
    include "../env.php";

    $db->editBusiness($_POST["businessId"],$_POST["businessNo"],$_POST["businessName"],$_POST["businessOwner"],$_POST["businessType"],$_POST["businessDate"]);
    $db->deleteBusinessLocation($_POST["businessNo"]);
    $db->attachBusiness($_POST["businessNo"],$_POST["businessLocation"]);
?>