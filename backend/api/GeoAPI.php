<?php

require_once('../classes/GeoService.php');

class GeoAPI {
    // Method to integrate with third-party API for city autocomplete search
    public static function autocompleteCitySearch($query) {
        return ThirdPartyService::autocompleteCitySearch($query);
    }
}
?>
