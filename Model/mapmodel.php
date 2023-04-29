<?php
Class MapData{
    private $id;
    private $name;
    private $date;
    private $active;
    private $location;
    private $clients;
    function __construct($id, $name, $date, $active, $location){
        $this->id = $id;
        $this->name = $name;
        $this->date = $date;
        $this->$active = $active;
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
    function getDate(){
        return $this->date;
    }
    function getActive(){
        return $this->active;
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