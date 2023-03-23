<?php
    include('db.php');
    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    
    //$conn->close();

    $businessId = $_POST['createId']; 
    $businessName = $_POST['createName'];
    $businessOwner = $_POST['createOwner'];
    $businessType = $_POST['createType'];
    $businessLocation = $_POST['createLocation'];

    $sql = "INSERT INTO `profile`(`id`, `name`, `owner`, `type`, `date`, `location`) VALUES ('$businessId','$businessName','$businessOwner','$businessType','CURR_DATE()',$businessLocation)";
    $conn->query($sql);
    echo "Added Successfully";
?>
