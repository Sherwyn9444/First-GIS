<?php
    class field{
        public $id;
        public $name;
        public $owner;
        public $type;
        public $date;
        public $location;

        function __construct($id,$name,$owner,$type,$date,$location)
        {
            $this->id = $id;
            $this->name = $name;
            $this->type = $type;
            $this->owner = $owner;
            $this->date = $date;
            $this->location = $location;
        }

        function getData(){
            return $this->id;
        }
    }
?>