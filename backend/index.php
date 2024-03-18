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
        if ($method == 'POST') {
            UserAPI::login();
        }
        break;
    default:
        http_response_code(404);
        echo json_encode(array("message" => "Invalid API endpoint"));
        break;
}

?>
