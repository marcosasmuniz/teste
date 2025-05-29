<?php

declare(strict_types=1);

namespace App\Services;

// It's good practice to add use statements for any external classes if they were used,
// e.g., use GuzzleHttp\Client;
// use GuzzleHttp\Exception\RequestException;

class AsaasService
{
    private string $apiKey;
    private string $baseUrl = 'https://www.asaas.com/api/v3'; // Default Asaas API base URL

    public function __construct(string $apiKey, ?string $baseUrl = null)
    {
        $this->apiKey = $apiKey;
        if ($baseUrl) {
            $this->baseUrl = $baseUrl;
        }
    }

    /**
     * Retrieves invoices for a given Asaas customer ID.
     *
     * @param string $asaasCustomerId The Asaas customer ID.
     * @return array An array of invoice data, or an empty array if none are found or on error.
     */
    public function getInvoicesByCustomer(string $asaasCustomerId): array
    {
        // TODO: Implement actual API call
        // 1. Endpoint: GET /customers/{$asaasCustomerId}/payments (or similar, verify Asaas documentation)
        //    The URL would be constructed as: $this->baseUrl . '/customers/' . $asaasCustomerId . '/payments'

        // 2. HTTP Client Setup (e.g., Guzzle):
        //    - Instantiate the client: $client = new \GuzzleHttp\Client();
        //    - It's recommended to manage the client instance via dependency injection or a factory.

        // 3. Making the GET Request:
        //    try {
        //        $response = $client->request('GET', $url, [
        //            'headers' => [
        //                'access_token' => $this->apiKey, // Or 'Authorization' => 'Bearer ' . $this->apiKey
        //                'Accept'       => 'application/json',
        //            ],
        //            'query' => [ // Optional query parameters, e.g., for pagination or filtering
        //                // 'status' => 'PENDING',
        //                // 'limit' => 10,
        //                // 'offset' => 0,
        //            ]
        //        ]);
        //    } catch (\GuzzleHttp\Exception\RequestException $e) {
        //        // Handle request exceptions (e.g., network errors, 4xx/5xx responses)
        //        // Log the error: error_log($e->getMessage());
        //        return []; // Return empty array on error
        //    }

        // 4. Handling the Response:
        //    - Get status code: $statusCode = $response->getStatusCode();
        //    - If $statusCode === 200:
        //        $body = $response->getBody()->getContents();
        //        $data = json_decode($body, true);
        //        // Check for json_decode errors if necessary: if (json_last_error() !== JSON_ERROR_NONE) { ... }
        //        // The $data variable would typically contain a list of invoices.
        //        // e.g., $data['data'] if the invoices are nested under a 'data' key.
        //        return $data['data'] ?? []; // Adjust based on actual Asaas response structure
        //    - Else (e.g., 401, 403, 404, 500):
        //        // Handle non-200 success responses appropriately
        //        // Log error: error_log("Asaas API error: Status " . $statusCode . " Body: " . $response->getBody()->getContents());
        //        return [];

        // 5. Expected Structure (example, verify with Asaas docs):
        //    An array of invoice-like associative arrays or objects, e.g.:
        //    [
        //        [
        //            'id' => 'pay_123',
        //            'dueDate' => '2024-08-15',
        //            'value' => 100.50,
        //            'status' => 'PENDING',
        //            'invoiceUrl' => 'https://sandbox.asaas.com/i/pay_123'
        //            // ... other invoice fields
        //        ],
        //        // ... more invoices
        //    ]

        return []; // Placeholder return
    }

    /**
     * Retrieves customer details for a given Asaas customer ID.
     *
     * @param string $asaasCustomerId The Asaas customer ID.
     * @return ?array Customer data as an associative array, or null if not found or on error.
     */
    public function getCustomer(string $asaasCustomerId): ?array
    {
        // TODO: Implement actual API call
        // 1. Endpoint: GET /customers/{$asaasCustomerId} (Verify Asaas documentation)
        //    The URL would be: $this->baseUrl . '/customers/' . $asaasCustomerId

        // 2. HTTP Client Setup: Similar to getInvoicesByCustomer (e.g., Guzzle).

        // 3. Making the GET Request:
        //    Similar headers and error handling as getInvoicesByCustomer.
        //    $response = $client->request('GET', $url, [
        //        'headers' => [
        //            'access_token' => $this->apiKey,
        //            'Accept'       => 'application/json',
        //        ]
        //    ]);

        // 4. Handling the Response:
        //    - If status code 200:
        //        $body = $response->getBody()->getContents();
        //        $customerData = json_decode($body, true);
        //        return $customerData;
        //    - Else (e.g., 404 Not Found):
        //        return null;

        // 5. Expected Structure (example, verify with Asaas docs):
        //    An associative array representing the customer, e.g.:
        //    [
        //        'id' => 'cus_abc',
        //        'name' => 'John Doe',
        //        'email' => 'john.doe@example.com',
        //        'cpfCnpj' => '12345678900'
        //        // ... other customer fields
        //    ]

        return null; // Placeholder return
    }

    /**
     * Retrieves invoice details for a given Asaas invoice ID.
     *
     * @param string $asaasInvoiceId The Asaas invoice ID (payment ID).
     * @return ?array Invoice data as an associative array, or null if not found or on error.
     */
    public function getInvoice(string $asaasInvoiceId): ?array
    {
        // TODO: Implement actual API call
        // 1. Endpoint: GET /payments/{$asaasInvoiceId} (Verify Asaas documentation)
        //    The URL would be: $this->baseUrl . '/payments/' . $asaasInvoiceId

        // 2. HTTP Client Setup: Similar to getInvoicesByCustomer (e.g., Guzzle).

        // 3. Making the GET Request:
        //    Similar headers and error handling as getInvoicesByCustomer.
        //    $response = $client->request('GET', $url, [
        //        'headers' => [
        //            'access_token' => $this->apiKey,
        //            'Accept'       => 'application/json',
        //        ]
        //    ]);

        // 4. Handling the Response:
        //    - If status code 200:
        //        $body = $response->getBody()->getContents();
        //        $invoiceData = json_decode($body, true);
        //        return $invoiceData;
        //    - Else (e.g., 404 Not Found):
        //        return null;

        // 5. Expected Structure (example, verify with Asaas docs):
        //    An associative array representing the invoice, e.g.:
        //    [
        //        'id' => 'pay_123',
        //        'customer' => 'cus_abc',
        //        'dueDate' => '2024-08-15',
        //        'value' => 100.50,
        //        'status' => 'PENDING',
        //        'invoiceUrl' => 'https://sandbox.asaas.com/i/pay_123'
        //        // ... other invoice fields
        //    ]

        return null; // Placeholder return
    }
}
