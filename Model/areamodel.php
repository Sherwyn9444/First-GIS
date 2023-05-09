<?php
Class Area{
    private $id;
    private $name;
    private $type;
    private $location;
    function __construct($id, $name, $type, $location){
        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->location = $location;
    }

    function setType($type){
        $this->type = $type;
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
    function getType(){
        return $this->type;
    }
    function getLocation(){
        return $this->location;
    }
}
?>