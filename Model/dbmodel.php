<?php
Class Database{
    private $conn;
    private $server;
    private $username;
    private $password;
    private $dbname;
    function __construct()
    {
        $this->server = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "geois";        
        $this->conn = new mysqli($this->server, $this->username, $this->password, $this->dbname);
    }
    
    function setServer($server){
        $this->server = $server;
    }

    function setUsername($username){
        $this->username = $username;
    }

    function setPassword($password){
        $this->password = $password;
    }
    function setDatabase($dbname){
        $this->dbname = $dbname;
    }
    function reset(){
        $this->conn = new mysqli($this->server, $this->username, $this->password, $this->dbname);
    }
    function getConnection(){
        return $this->conn;
    }
}
?>