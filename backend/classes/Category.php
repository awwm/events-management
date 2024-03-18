<?php

class Category {
    // Properties
    private $id;
    private $name;
    private $parentId;

    // Constructor
    public function __construct($name, $parentId = null) {
        $this->name = $name;
        $this->parentId = $parentId;
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

    public function getParentId() {
        return $this->parentId;
    }

    public function setParentId($parentId) {
        $this->parentId = $parentId;
    }
}
?>
