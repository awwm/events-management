<?php

require_once('../config/database.php');
require_once('../vendor/autoload.php');
require_once('UserAPI.php');

class CategoryAPI {
    // Method to list all categories
    public static function listCategories() {
        $db = new Database();
        $pdo = $db->connect();
        $stmt = $pdo->query('SELECT * FROM categories');
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }

    // Method to add a category
    public static function addCategory($userId, $name) {
        // Check if the user is an admin
        if (UserAPI::isAdmin($userId)) {
            $db = new Database();
            $pdo = $db->connect();
            $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
            $stmt->execute([$name]);
            return $pdo->lastInsertId();
        } else {
            // Non-admin users are not authorized to add categories
            return false;
        }
    }

    // Method to edit a category
    public static function editCategory($userId, $id, $name) {
        // Check if the user is an admin
        if (UserAPI::isAdmin($userId)) {
            $db = new Database();
            $pdo = $db->connect();
            $stmt = $pdo->prepare('UPDATE categories SET name = ? WHERE id = ?');
            $stmt->execute([$name, $id]);
            return true;
        } else {
            // Non-admin users are not authorized to edit categories
            return false;
        }
    }

    // Method to delete a category
    public static function deleteCategory($userId, $id) {
        // Check if the user is an admin
        if (UserAPI::isAdmin($userId)) {
            $db = new Database();
            $pdo = $db->connect();
            $stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
            $stmt->execute([$id]);
            return true;
        } else {
            // Non-admin users are not authorized to delete categories
            return false;
        }
    }
}
?>
