<?php

require_once('./classes/Event.php');
require_once('./config/database.php');
require_once('UserAPI.php');

class EventAPI {
    // Method to list all events
    public static function listEvents() {
        $db = new Database();
        $pdo = $db->connect();
        $stmt = $pdo->query('SELECT * FROM events');
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $events;
    }

    // Method to add an event
    public static function addEvent($userId, $name, $cityId, $categoryIds, $featuredImage, $shortDescription, $longDescription) {
        $db = new Database();
        $pdo = $db->connect();
        $stmt = $pdo->prepare('INSERT INTO events (user_id, name, city_id, category_ids, featured_image, short_description, long_description) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$userId, $name, $cityId, $categoryIds, $featuredImage, $shortDescription, $longDescription]);
        return $pdo->lastInsertId();
    }

    // Method to edit an event
    public static function editEvent($userId, $id, $name, $cityId, $categoryIds, $featuredImage, $shortDescription, $longDescription) {
        // Check if the user is authorized to edit the event
        if (UserAPI::isAdmin($userId)) {
            $db = new Database();
            $pdo = $db->connect();
            $stmt = $pdo->prepare('UPDATE events SET name = ?, city_id = ?, category_ids = ?, featured_image = ?, short_description = ?, long_description = ? WHERE id = ?');
            $stmt->execute([$name, $cityId, $categoryIds, $featuredImage, $shortDescription, $longDescription, $id]);
            return true;
        } else {
            // Check if the event belongs to the user
            $db = new Database();
            $pdo = $db->connect();
            $stmt = $pdo->prepare('SELECT user_id FROM events WHERE id = ?');
            $stmt->execute([$id]);
            $event = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($event && $event['user_id'] == $userId) {
                // User is authorized to edit the event
                $stmt = $pdo->prepare('UPDATE events SET name = ?, city_id = ?, category_ids = ?, featured_image = ?, short_description = ?, long_description = ? WHERE id = ?');
                $stmt->execute([$name, $cityId, $categoryIds, $featuredImage, $shortDescription, $longDescription, $id]);
                return true;
            } else {
                // User is not authorized to edit the event
                return false;
            }
        }
    }

    // Method to delete an event
    public static function deleteEvent($userId, $id) {
        // Check if the user is an admin
        if (UserAPI::isAdmin($userId)) {
            $db = new Database();
            $pdo = $db->connect();
            $stmt = $pdo->prepare('DELETE FROM events WHERE id = ?');
            $stmt->execute([$id]);
            return true;
        } else {
            // Check if the event belongs to the user
            $db = new Database();
            $pdo = $db->connect();
            $stmt = $pdo->prepare('SELECT user_id FROM events WHERE id = ?');
            $stmt->execute([$id]);
            $event = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($event && $event['user_id'] == $userId) {
                // User is authorized to delete the event
                $stmt = $pdo->prepare('DELETE FROM events WHERE id = ?');
                $stmt->execute([$id]);
                return true;
            } else {
                // User is not authorized to delete the event
                return false;
            }
        }
    }
}
?>
