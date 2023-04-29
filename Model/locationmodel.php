<?php
Class Location{
    private $id;
    private $name;
    private $location;
    private $clients;
    function __construct($id, $name, $location){
        $this->id = $id;
        $this->name = $name;
        $this->location = $location;
        $this->clients = [];
    }

    function addClient($client){
        array_push($this->clients,$client);
    }
    function setName($name){
        $this->name = $name;
    }
    function setLocation($location){
        $this->location = $location;
    }
    function getId(){
        return $this->id;
    }
    function getName(){
        return $this->name;
    }
    function getLocation(){
        return $this->location;
    }
    function getClients(){
        return $this->clients;
    }
}
?>