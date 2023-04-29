<?php
    include "../env.php";

    $db->editLocation($_POST["locationNo"],$_POST["locationName"],$_POST["locationPoint"]);
?>