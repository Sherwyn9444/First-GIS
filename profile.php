<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "geois";

    $conn = new mysqli($server, $username, $password, $dbname);
    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM profile";

    $result = $conn->query($sql);

    
    //$conn->close();
?>

<html>
    <head>
    </head>
    <body>
        <div class="prof-search">
            <input id="prof-txt-search" type="text" placeholder="Search">
            <button id="prof-btn-search">Search</button>
        </div>
        <table>
            <tr>
                <td>Id</td><td>Name</td><td>Age</td><td>Type</td><td>Date</td>
            </tr>
            <?php
                if($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {  
                        if(isset($row)){
                            echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>".$row["age"]."</td><td>".$row["type"]."</td><td>".$row["date"]."</td>";
                        }
                    }
                }
            ?>
        </table>
    </body>
</html>