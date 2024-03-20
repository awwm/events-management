<?php

require_once('vendor/autoload.php');

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Get allowed IPs from .env file
$allowedIPs = $_ENV['ALLOWED_IPS'];

// Include necessary files
require_once('api/CityAPI.php');
require_once('api/CategoryAPI.php');
require_once('api/EventAPI.php');
require_once('api/UserAPI.php');

// Enable CORS (Cross-Origin Resource Sharing)
// Allow requests from any origin
header("Access-Control-Allow-Origin: *");
// Allow credentials (cookies, authorization headers, etc.) to be included in requests
header("Access-Control-Allow-Credentials: true");
// Allow specific HTTP methods (GET, POST, etc.)
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// Allow specific headers in the request
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// // Include necessary files
// require_once('config/database.php');

// // Create an instance of the Database class
// $database = new Database();

// // Attempt to connect to the database
// $pdo = $database->initSchema();

// // Check if the connection was successful
// if ($pdo) {
//     echo "Database tables created";
// } else {
//     echo "Database connection failed";
// }

// Define the base API path
$basePath = '/api/';

// Extract the endpoint from the URL
$requestUri = $_SERVER['REQUEST_URI'];
$endpoint = substr($requestUri, strpos($requestUri, $basePath) + strlen($basePath));

// Parse the endpoint and method from the request
$parts = explode('/', $endpoint);
$api = $parts[0];
$method = $_SERVER['REQUEST_METHOD'];

// Route requests to the appropriate API endpoint and method
switch ($api) {
    case 'CityAPI':
        if ($method == 'GET') {
            CityAPI::listCities();
        } elseif ($method == 'POST') {
            CityAPI::addCity();
        }
        break;
    case 'CategoryAPI':
        if ($method == 'GET') {
            CategoryAPI::listCategories();
        } elseif ($method == 'POST') {
            CategoryAPI::addCategory();
        }
        break;
    case 'EventAPI':
        if ($method == 'GET') {
            if (isset($_GET['userId'])) {
                $userId = $_GET['userId'];
                EventAPI::listUserEvents($userId);
            } else {
                EventAPI::listEvents();
            }
        } elseif ($method == 'POST') {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            // Pass the required arguments to the addEvent method
            $userId = $data['userId'];
            $name = $data['title'];
            $city = $data['city'];
            $category = $data['category'];
            $shortDescription = $data['shortDescription'];
            $longDescription = $data['longDescription'];
            $featuredImage = null;

            EventAPI::addEvent($userId, $name, $city, $category, $featuredImage, $shortDescription, $longDescription);
        }
        break;
    case 'UserAPI':
        // Determine action based on the request body
        $data = json_decode(file_get_contents("php://input"));
        if ($method == 'POST') {
            if (isset($data->register)) {
                // Regular user registration
                UserAPI::register();
            } elseif (isset($data->registerAdmin)) {
                // Admin user registration
                UserAPI::registerAdmin();
            } else {
                // User login
                UserAPI::login();
            }
        }
        break;
    default:
        http_response_code(404);
        echo json_encode(array("message" => "Invalid API endpoint"));
        break;
}

?>
