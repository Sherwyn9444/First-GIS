<?php
    include('db.php');
    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    
    //$conn->close();

    $search = $_POST['searchbar']; 
    
    $sql = "SELECT * FROM profile WHERE name LIKE '%".$search."%' OR id LIKE '%".$search."%' OR owner LIKE '%".$search."%' OR type LIKE '%".$search."%' OR date LIKE '%".$search."%'";
    $result = $conn->query($sql);
    echo "<tr><td>Id</td><td>Name</td><td>Owner</td><td>Type</td><td>Date</td><td>Address</td></tr>";
    if($result->num_rows > 0) {
        // output data of each row
            while($row = $result->fetch_assoc()) {  
                if(isset($row)){
                    echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>".$row["owner"]."</td><td>".$row["type"]."</td><td>".$row["date"]."</td><td></td><td><input type='button' id='".$row["id"]."' onclick = 'viewOnMap(this.id)' value='View on Map'></td><td><input type='button' id='".$row["id"]."' onclick = 'deleteField(this.id)' value='Delete'></td>";
                }
            }
        }
?>
