<?php
    include "../env.php";

    $db->insertLocation($_POST["locationNo"],$_POST["locationName"],$_POST["locationPoint"]);
?>