<?php

declare(strict_types=1);

namespace App\Controllers;

// For now, we are not using the AsaasService directly in this placeholder.
// use App\Services\AsaasService;

class InvoiceController
{
    public function index()
    {
        header('Content-Type: application/json');
        $customerId = $_GET['customer_id'] ?? null;

        if (!$customerId) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'customer_id query parameter is required']);
            return;
        }

        http_response_code(200); // OK
        echo json_encode([
            'message' => 'Get invoices placeholder',
            'customer_id' => $customerId
        ]);
    }
}
