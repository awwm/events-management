<?php

require_once('vendor/autoload.php');

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Include necessary files
require_once('api/CityAPI.php');
require_once('api/CategoryAPI.php');
require_once('api/EventAPI.php');
require_once('api/UserAPI.php');

// Enable CORS (Cross-Origin Resource Sharing)
// header('Access-Control-Allow-Origin: *'); // Allow requests from any origin
header("Access-Control-Allow-Origin: http://localhost:8082");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, POST'); // Allow GET and POST requests
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Allow Content-Type and Authorization headers

// // Include necessary files
// require_once('config/database.php');

// // Create an instance of the Database class
// $database = new Database();

// // Attempt to connect to the database
// $pdo = $database->initSchema();

// // Check if the connection was successful
// if ($pdo) {
//     echo "Database connection successful";
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
            EventAPI::listEvents();
        } elseif ($method == 'POST') {
            EventAPI::addEvent();
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
