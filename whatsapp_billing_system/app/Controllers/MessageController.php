<?php

declare(strict_types=1);

namespace App\Controllers;

// For now, we are not using the WhaticketService directly in this placeholder.
// use App\Services\WhaticketService;

class MessageController
{
    public function send()
    {
        header('Content-Type: application/json');
        $inputData = json_decode(file_get_contents('php://input'), true);

        if (json_last_error() !== JSON_ERROR_NONE && empty($_POST)) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Invalid JSON or no POST data']);
            return;
        }

        $received_data = $inputData ?? $_POST;

        http_response_code(200); // OK
        echo json_encode([
            'message' => 'Send message placeholder',
            'data' => $received_data
        ]);
    }
}
