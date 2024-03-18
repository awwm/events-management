<?php

class Event {
    private $id;
    private $name;
    private $cityId;
    private $categoryIds;
    private $featuredImage;
    private $shortDescription;
    private $longDescription;
    private $userId;

    public function __construct($name, $cityId, $categoryIds, $featuredImage, $shortDescription, $longDescription, $userId) {
        $this->name = $name;
        $this->cityId = $cityId;
        $this->categoryIds = $categoryIds;
        $this->featuredImage = $featuredImage;
        $this->shortDescription = $shortDescription;
        $this->longDescription = $longDescription;
        $this->userId = $userId;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getCityId() {
        return $this->cityId;
    }

    public function setCityId($cityId) {
        $this->cityId = $cityId;
    }

    public function getCategoryIds() {
        return $this->categoryIds;
    }

    public function setCategoryIds($categoryIds) {
        $this->categoryIds = $categoryIds;
    }

    public function getFeaturedImage() {
        return $this->featuredImage;
    }

    public function setFeaturedImage($featuredImage) {
        $this->featuredImage = $featuredImage;
    }

    public function getShortDescription() {
        return $this->shortDescription;
    }

    public function setShortDescription($shortDescription) {
        $this->shortDescription = $shortDescription;
    }

    public function getLongDescription() {
        return $this->longDescription;
    }

    public function setLongDescription($longDescription) {
        $this->longDescription = $longDescription;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }
}
?>
