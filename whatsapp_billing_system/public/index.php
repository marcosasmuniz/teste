<?php

declare(strict_types=1);

// Set default content type to JSON for all responses
header('Content-Type: application/json');

// Temporary manual includes - replace with autoloader later
require_once __DIR__ . '/../app/Controllers/CustomerController.php';
require_once __DIR__ . '/../app/Controllers/InvoiceController.php';
require_once __DIR__ . '/../app/Controllers/MessageController.php';

use App\Controllers\CustomerController;
use App\Controllers\InvoiceController;
use App\Controllers\MessageController;

$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? '';

// Remove query string from URI and base path if your app is in a subdirectory
$basePath = '/whatsapp_billing_system/public'; // Adjust if your entry point is elsewhere or no base path
if (strpos($requestUri, $basePath) === 0) {
    $requestUri = substr($requestUri, strlen($basePath));
}
$uriParts = explode('?', $requestUri);
$route = trim($uriParts[0], '/');

// Basic routing logic
switch ($route) {
    case 'api/customers':
        if ($requestMethod === 'POST') {
            $controller = new CustomerController();
            $controller->store();
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Method Not Allowed']);
        }
        break;

    case preg_match('/^api\/customers\/([a-zA-Z0-9_-]+)$/', $route, $matches) ? $route : '':
        if ($requestMethod === 'GET') {
            $controller = new CustomerController();
            $controller->show($matches[1]); // $matches[1] contains the id
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Method Not Allowed']);
        }
        break;

    case 'api/invoices':
        if ($requestMethod === 'GET') {
            $controller = new InvoiceController();
            $controller->index();
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Method Not Allowed']);
        }
        break;

    case 'api/messages/send':
        if ($requestMethod === 'POST') {
            $controller = new MessageController();
            $controller->send();
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Method Not Allowed']);
        }
        break;

    default:
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'Route Not Found']);
        break;
}
