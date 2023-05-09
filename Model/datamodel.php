<?php
    Class Data{
        private $conn;
        function __construct($conn)
        {
            $this->conn = $conn->getConnection();
        }

        function selectLocation($where){
            if($where == ""){
                $sql = "SELECT locationId, locationName, ST_AsText(locationPoint) as location FROM location";
            }else{
                $sql = "SELECT locationId, locationName, ST_AsText(locationPoint) as location FROM location WHERE $where";
            }
            $allOutput = [];
            $result = $this->conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {  
                    if(isset($row)){
                        $output = new Location($row["locationId"],$row["locationName"],$row["location"]);
                        $output->addClient($this->getBusinessFromLocation($row["locationId"]));
                        array_push($allOutput,$output);
                    }
                }
            }
            return $allOutput;
        }

        function selectArea(){
           
            $sql = "SELECT `id`, `name`, `type` , ST_AsText(area) as location FROM areas";

            $allOutput = [];
            $result = $this->conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {  
                    if(isset($row)){
                        $output = new Area($row["id"],$row["name"],$row["type"],$row["location"]);
                        array_push($allOutput,$output);
                    }
                }
            }
            return $allOutput;
        }

        function selectBusiness($where){
            $sql = "SELECT * FROM profile";
            if($where == ""){
                $sql = "SELECT * FROM profile";
            }else{
                $sql = "SELECT * FROM profile WHERE $where";
            }
            $allOutput = [];
                
            $result = $this->conn->query($sql);

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {  
                    if(isset($row)){
                        $output = new Business($row["id"],$row["no"],$row["name"],$row["type"],$row["owner"],$row["date"],$row["active"]);
                        $output->setLocation($this->getLocationFromBusiness($row["no"]));
                        array_push($allOutput,$output);
                    }
                }
            }
            return $allOutput;
        }

        function insertLocation($locationNumber, $locationName,$businessLocation){
            $sql = "INSERT INTO `location`(`locationNo`,`locationName`, `locationPoint`) VALUES ('".$locationNumber."', '".$locationName."',ST_GeomFromText($businessLocation))";
            $this->conn->query($sql);
        }

        function insertArea($areaName, $areaType,$areaLocation){
            $sql = "INSERT INTO `areas`(`name`,`type`, `area`) VALUES ('".$areaName."', '".$areaType."',ST_GeomFromText('".$areaLocation."'))";
            $this->conn->query($sql);
        }

        function insertBusiness($businessId,$businessName,$businessOwner,$businessType,$businessDate){
            $sql = "INSERT INTO `profile`(`no`, `name`, `owner`, `type`,`date`) VALUES ('$businessId','$businessName','$businessOwner','$businessType','$businessDate')";
            $this->conn->query($sql);
        }

        function attachBusiness($businessNo,$locationNo){

            $sql = "INSERT INTO `business`(`businessNo`, `locationNo`) VALUES ('$businessNo',$locationNo)";
            $this->conn->query($sql);
        }
        
        function selectSummarize($where){
            
            if($where == ""){
                $sql = "SELECT  a.id AS id, b.locationNo as locid, a.name AS name, ST_AsText(c.locationPoint) as local FROM profile as a inner join business as b on b.businessNo = a.no inner join location as c on c.locationId = b.locationNo";
            }else{
                $sql = "SELECT  a.id AS id, b.locationNo as locid, a.name AS name, ST_AsText(c.locationPoint) as local FROM profile as a inner join business as b on b.businessNo = a.no inner join location as c on c.locationId = b.locationNo WHERE $where";
            }
            $allOutput = [];
                
            $result = $this->conn->query($sql);

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {  
                    if(isset($row)){
                        $output = new Location($row["id"],$row["name"],$row["local"],"");
                        $output->addClient($this->getBusinessFromLocation($row["locid"]));
                        array_push($allOutput,$output);
                    }
                }
            }
            return $allOutput;
        }

        function editBusiness($businessId,$businessNo,$businessName,$businessOwner,$businessType,$businessDate){
            $sql = "UPDATE `profile` SET no = '".$businessNo."', name = '".$businessName."', owner = '".$businessOwner."', type = '".$businessType."', date = '".$businessDate."' WHERE id = '".$businessId."'";
            $this->conn->query($sql);
        }

        function editLocation($locationNumber, $locationName,$businessLocation){
            $sql = "UPDATE `location` SET locationName = '".$locationName."', locationPoint = ST_GeomFromText('".$businessLocation."') WHERE locationNo = '".$locationNumber."'";
            $this->conn->query($sql);
        }

        function deleteBusiness($businessId){
            $sql = "DELETE FROM `profile` WHERE id = '".$businessId."'";
            $this->conn->query($sql);
        }

        function deleteLocation($locationId){
            $sql = "DELETE FROM `location` WHERE locationId = '".$locationId."'";
            $this->conn->query($sql);
        }

        function deleteBusinessLocation($businessNo){
            $sql = "DELETE FROM business WHERE businessNo = '".$businessNo."'";
            $this->conn->query($sql);
        }

        function getBusinessFromLocation($locationNo){
            $sql = "SELECT * FROM business as a inner join profile as b ON a.businessNo = b.no WHERE a.locationNo = '".$locationNo."'";
            $result = $this->conn->query($sql);
            $allOutput = [];
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {  
                    if(isset($row)){
                        $output = new Business($row["id"],$row["no"],$row["name"],$row["type"],$row["owner"],$row["date"],$row["active"]);
                        array_push($allOutput,$output);
                    }
                }
            }
            return $allOutput;
        }

        function getLocationFromBusiness($businessNo){
            $sql = "SELECT b.locationId as locationId,b.locationName as locationName, ST_AsText(b.locationPoint) as locations FROM business as a inner join location as b ON a.locationNo = b.locationId WHERE a.businessNo = '".$businessNo."'";
            $result = $this->conn->query($sql);
            $allOutput = [];
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {  
                    if(isset($row)){
                        $output = new Location($row["locationId"],$row["locationName"],$row["locations"]);
                        
                        array_push($allOutput,$output);
                    }
                }
            }
            return $allOutput;
        }

        function getCategory(){
            $sql = "Select `type` from profile group by type";
        
            $allOutput = [];
                
            $result = $this->conn->query($sql);

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {  
                    if(isset($row)){
                        $output = $row["type"];
                        array_push($allOutput,$output);
                    }
                }
            }

            return $allOutput;
        }

        function getYears(){
            $sql = "Select YEAR(date) as year from profile group by YEAR(date)";
        
            $allOutput = [];
                
            $result = $this->conn->query($sql);

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {  
                    if(isset($row)){
                        $output = $row["year"];
                        array_push($allOutput,$output);
                    }
                }
            }
            
            return $allOutput;
        }

        function getBarangay(){
            $sql = "Select `name` from areas WHERE type = 'Barangay'";
        
            $allOutput = [];
                
            $result = $this->conn->query($sql);

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {  
                    if(isset($row)){
                        $output = $row["name"];
                        array_push($allOutput,$output);
                    }
                }
            }

            return $allOutput;
        }
    }
?>