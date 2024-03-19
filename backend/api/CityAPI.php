<?php

require_once('./config/database.php');
require_once('./vendor/autoload.php');
require_once('UserAPI.php');

class CityAPI {
    // Method to list all cities
    public static function listCities() {
        $db = new Database();
        $pdo = $db->connect();
        $stmt = $pdo->query('SELECT * FROM cities');
        $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $cities;
    }

    // Method to add a city
    public static function addCity($userId, $name) {
        // Check if the user is an admin
        if (UserAPI::isAdmin($userId)) {
            $db = new Database();
            $pdo = $db->connect();
            $stmt = $pdo->prepare('INSERT INTO cities (name) VALUES (?)');
            $stmt->execute([$name]);
            return $pdo->lastInsertId();
        } else {
            // Non-admin users are not authorized to add cities
            return false;
        }
    }

    // Method to edit a city
    public static function editCity($userId, $id, $name) {
        // Check if the user is an admin
        if (UserAPI::isAdmin($userId)) {
            $db = new Database();
            $pdo = $db->connect();
            $stmt = $pdo->prepare('UPDATE cities SET name = ? WHERE id = ?');
            $stmt->execute([$name, $id]);
            return true;
        } else {
            // Non-admin users are not authorized to edit cities
            return false;
        }
    }

    // Method to delete a city
    public static function deleteCity($userId, $id) {
        // Check if the user is an admin
        if (UserAPI::isAdmin($userId)) {
            $db = new Database();
            $pdo = $db->connect();
            $stmt = $pdo->prepare('DELETE FROM cities WHERE id = ?');
            $stmt->execute([$id]);
            return true;
        } else {
            // Non-admin users are not authorized to delete cities
            return false;
        }
    }
}
?>
