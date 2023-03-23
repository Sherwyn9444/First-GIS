<?php
    include('db.php');
    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    
    //$conn->close();

    $businessId = $_POST['deleteId']; 
    $businessName = $_POST['deleteName'];
    $businessOwner = $_POST['deleteOwner'];
    $businessType = $_POST['deleteType'];
    $businessLocation = $_POST['deleteLocation'];

    $sql = "DELETE FROM `profile` WHERE  id = '$businessId' AND name='$businessName' AND owner='$businessOwner' AND type='$businessType' AND location = ST_GeomFromText('$businessLocation')";
    //$sql = "SELECT location FROM `profile`";
    $result = $conn->query($sql);
    echo $result;
?>
