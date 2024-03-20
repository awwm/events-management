<?php

require_once('./classes/User.php');
require_once('./config/database.php');
require_once('./vendor/autoload.php');

use Firebase\JWT\JWT;

class UserAPI {
    private static $jwt_secret;

    // Method to generate a JWT token upon successful login
    public static function generateToken($userId) {
        $token = array(
            "userId" => $userId,
            "exp" => time() + (60 * 60) // Token expiration time (1 hour)
        );
        $algorithm = 'HS256';
        return JWT::encode($token, $_ENV['JWT_SECRET'], $algorithm);
    }

    // Method to validate a JWT token
    public static function validateToken($token) {
        try {
            $decoded = JWT::decode($token, $_ENV['JWT_SECRET'], array('HS256'));
            return $decoded->userId;
        } catch (Exception $e) {
            return null;
        }
    }

    // Method to handle user registration
    public static function registerAdmin() {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->email) && !empty($data->password) && !empty($data->username) && isset($data->role)) {
            // Check if the user already exists
            $db = new Database();
            $pdo = $db->connect();
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->execute([$data->email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // User already exists
                http_response_code(400);
                echo json_encode(array("message" => "User with this email already exists"));
            } else {
                // Create the user
                $hashedPassword = password_hash($data->password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)');
                $stmt->execute([$data->username, $data->email, $hashedPassword, $data->role]);

                // Generate JWT token
                $userId = $pdo->lastInsertId(); // Get the ID of the newly inserted user
                $token = self::generateToken($userId);

                // Return success message
                http_response_code(201);
                echo json_encode(array("message" => "User registered successfully", "token" => $token));
            }
        } else {
            // Missing email or password
            http_response_code(400);
            echo json_encode(array("message" => "Email and password are required"));
        }
    }

    // Method to handle user registration
    public static function register() {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->email) && !empty($data->password) && !empty($data->username)) {
            // Check if the user already exists
            $db = new Database();
            $pdo = $db->connect();
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->execute([$data->email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // User already exists
                http_response_code(400);
                echo json_encode(array("message" => "User with this email already exists"));
            } else {
                // Create the user
                $hashedPassword = password_hash($data->password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
                $stmt->execute([$data->username, $data->email, $hashedPassword]);

                // Generate JWT token
                $userId = $pdo->lastInsertId(); // Get the ID of the newly inserted user
                $token = self::generateToken($userId);

                // Return success message
                http_response_code(201);
                echo json_encode(array("message" => "User registered successfully", "token" => $token));
            }
        } else {
            // Missing email or password
            http_response_code(400);
            echo json_encode(array("message" => "Email and password are required"));
        }
    }

    // Method to handle user login
    public static function login() {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->email) && !empty($data->password)) {
            // Retrieve the user from the database
            $db = new Database();
            $pdo = $db->connect();
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->execute([$data->email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify the password
            if ($user && password_verify($data->password, $user['password'])) {
                // Password is correct, generate and return the JWT token
                http_response_code(200);
                echo json_encode(array("token" => self::generateToken($user['id'])));
            } else {
                // Password is incorrect or user doesn't exist
                http_response_code(401);
                echo json_encode(array("message" => "Invalid credentials"));
            }
        } else {
            // Missing email or password
            http_response_code(400);
            echo json_encode(array("message" => "Email and password are required"));
        }
    }

    // Method to check if a user is an admin
    public static function isAdmin($userId) {
        // Retrieve the user from the database
        $db = new Database();
        $pdo = $db->connect();
        $stmt = $pdo->prepare('SELECT role FROM users WHERE id = ?');
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the user is an admin
        return $user && $user['role'] == 1;
    }
}
?>
