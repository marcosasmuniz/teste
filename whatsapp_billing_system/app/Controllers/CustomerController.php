<?php

declare(strict_types=1);

namespace App\Controllers;

// For now, we are not using the Customer model directly in these placeholders.
// use App\Models\Customer;

class CustomerController
{
    public function store()
    {
        header('Content-Type: application/json');
        $inputData = json_decode(file_get_contents('php://input'), true);

        if (json_last_error() !== JSON_ERROR_NONE && empty($_POST)) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Invalid JSON or no POST data']);
            return;
        }

        $received_data = $inputData ?? $_POST;

        http_response_code(201); // Created
        echo json_encode([
            'message' => 'Customer creation placeholder',
            'data' => $received_data
        ]);
    }

    public function show(string $id)
    {
        header('Content-Type: application/json');
        http_response_code(200); // OK
        echo json_encode([
            'message' => 'Get customer placeholder',
            'customer_id' => $id
        ]);
    }
}
