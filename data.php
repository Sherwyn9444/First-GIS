<?php
    class user{
        private $id;
        private $name;
        private $age;
        private $type;
        private $date;

        function __construct($conn, $sql){
            $result = $conn->query($sql);

            if($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                   
                    if(isset($row)){
                        $this->id = $row["id"];
                        $this->name = $row["name"];
                        $this->age = $row["age"];
                        $this->type = $row["type"];
                        $this->date = $row["date"];
                    }
                }
            } else {

                header("Location: Login.php");
                exit();
            }
        }

    }

?>