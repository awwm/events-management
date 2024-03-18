<?php

class City {
    // Properties
    private $id;
    private $name;

    // Constructor
    public function __construct($name) {
        $this->name = $name;
    }

    // Getters and Setters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }
}
?>
