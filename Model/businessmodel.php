<?php
    Class Business{
        private $id;
        private $number;
        private $name;
        private $type;
        private $owner;
        private $date;
        private $location;
        private $active;
        function __construct($id,$number,$name,$type, $owner, $date, $active)
        {
            $this->id = $id;
            $this->number = $number;
            $this->name = $name;
            $this->type = $type;
            $this->owner = $owner;
            $this->date = $date;
            $this->active = $active;
        }

        function setNumber($number){
            $this->number = $number;
        }
        function setName($name){
            $this->name = $name;
        }
        function setOwner($owner){
            $this->owner = $owner;
        }
        function setDate($date){
            $this->date = $date;
        }
        function setActive($active){
            $this->active = $active;
        }
        function setLocation($location){
            $this->location = $location;
        }
        function setType($type){
            $this->type = $type;
        }
        function getId(){
            return $this->id;
        }
        function getNumber(){
            return $this->number;
        }
        function getName(){
            return $this->name;
        }
        function getLocation(){
            return $this->location;
        }
        function getActive(){
            return $this->active;
        }
        function getType(){
            return $this->type;
        }
        function getOwner(){
            return $this->owner;
        }
        function getDate(){
            return $this->date;
        }
    }
?>