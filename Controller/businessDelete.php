<?php
    include "../env.php";

    $db->deleteBusiness($_POST["businessId"]);
    $db->deleteBusinessLocation($_POST["businessNo"]);
?>