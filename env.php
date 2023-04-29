<?php
    include "Model/businessmodel.php";
    include "Model/datamodel.php";
    include "Model/dbmodel.php";
    include "Model/locationmodel.php";

    $database = new Database();
    $database->setServer("localhost");
    $database->setUsername("root");
    $database->setPassword("");
    $database->setDatabase("geois");
    $database->reset();

    $db = new Data($database);
    
?>