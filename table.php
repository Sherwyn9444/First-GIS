<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "geois";

    $conn = new mysqli($server, $username, $password, $dbname);
    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    
    //$conn->close();

    $search = $_POST['searchbar']; 
    
    $sql = "SELECT * FROM profile WHERE name LIKE '%".$search."%' OR id LIKE '%".$search."%' OR age LIKE '%".$search."%' OR type LIKE '%".$search."%' OR date LIKE '%".$search."%'";
    $result = $conn->query($sql);
    echo "<tr><td>Id</td><td>Name</td><td>Age</td><td>Type</td><td>Date</td></tr>";
    if($result->num_rows > 0) {
        // output data of each row
            while($row = $result->fetch_assoc()) {  
                if(isset($row)){
                    echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>".$row["age"]."</td><td>".$row["type"]."</td><td>".$row["date"]."</td>";
                }
            }
        }
?>
