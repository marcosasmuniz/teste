<?php

declare(strict_types=1);

namespace App\Services;

// It's good practice to add use statements for any external classes if they were used,
// e.g., use GuzzleHttp\Client;
// use GuzzleHttp\Exception\RequestException;

class WhaticketService
{
    private string $apiKey;
    private string $baseUrl; // e.g., 'https://api.whaticket.com/api' or 'https://yourdomain.whaticket.com/api'

    public function __construct(string $apiKey, string $baseUrl)
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = rtrim($baseUrl, '/'); // Ensure no trailing slash for consistent endpoint construction
    }

    /**
     * Sends a message to a recipient via the Whaticket API.
     *
     * @param string $recipientPhoneNumber The recipient's phone number (usually with country code).
     * @param string $messageBody The content of the message.
     * @param ?string $messageId An optional unique ID for the message (for idempotency or tracking).
     * @return array An associative array indicating the status of the message sending attempt.
     */
    public function sendMessage(string $recipientPhoneNumber, string $messageBody, ?string $messageId = null): array
    {
        // TODO: Implement actual API call to Whaticket (DialogChat)
        // 1. Endpoint: POST /messages/send (or similar, verify official Whaticket/DialogChat API documentation)
        //    The full URL would be constructed as: $this->baseUrl . '/messages/send'
        //    It's crucial to check the specific Whaticket instance's API documentation for the correct endpoint.
        //    Some Whaticket setups might use a path like /api/messages/send or include a specific instance ID.

        // 2. HTTP Client Setup (e.g., Guzzle):
        //    - Instantiate the client: $client = new \GuzzleHttp\Client();
        //    - Recommended: Manage the client instance via dependency injection or a factory.

        // 3. Preparing the Request Data (Payload):
        //    $payload = [
        //        'number' => $recipientPhoneNumber, // Or 'phone', 'destination', 'to' - check Whaticket docs
        //        'message' => $messageBody,         // Or 'body', 'text', 'content' - check Whaticket docs
        //    ];
        //    if ($messageId !== null) {
        //        $payload['customId'] = $messageId; // Or 'messageId', 'external_id' - check Whaticket docs
        //    }

        // 4. Making the POST Request:
        //    try {
        //        $response = $client->request('POST', $this->baseUrl . '/messages/send', [
        //            'headers' => [
        //                'Authorization' => 'Bearer ' . $this->apiKey, // Common for token-based auth
        //                // Or 'X-API-Key' => $this->apiKey, if Whaticket uses a different scheme
        //                'Accept'        => 'application/json',
        //                'Content-Type'  => 'application/json',
        //            ],
        //            'json' => $payload, // Guzzle automatically encodes this to JSON
        //        ]);
        //    } catch (\GuzzleHttp\Exception\RequestException $e) {
        //        // Handle request exceptions (network errors, 4xx/5xx responses from Whaticket)
        //        // Log the error: error_log("Whaticket API error: " . $e->getMessage());
        //        // If $e->hasResponse(), you can get more details:
        //        // $responseBody = $e->getResponse()->getBody()->getContents();
        //        // error_log("Whaticket response error: " . $responseBody);
        //        return [
        //            'status' => 'error',
        //            'message' => 'Failed to send message due to request exception.',
        //            'details' => $e->getMessage()
        //        ];
        //    }

        // 5. Handling the Response:
        //    - Get status code: $statusCode = $response->getStatusCode();
        //    - If $statusCode is 200, 201, or another success code (check Whaticket docs):
        //        $body = $response->getBody()->getContents();
        //        $responseData = json_decode($body, true);
        //        // Check for json_decode errors: if (json_last_error() !== JSON_ERROR_NONE) { ... }
        //
        //        // Expected success structure (example, verify with Whaticket docs):
        //        // {
        //        //   "status": "success" or "true" or "OK",
        //        //   "id": "whaticket_internal_message_id_12345", (or similar field for their ID)
        //        //   "message": "Message sent successfully" (or similar confirmation)
        //        // }
        //        return [
        //            'status' => 'success', // Or map from $responseData['status']
        //            'message_id' => $responseData['id'] ?? null, // Adjust key based on actual response
        //            'details' => $responseData['message'] ?? 'Message processed by Whaticket.',
        //            'raw_response' => $responseData // Optional: include the full response for debugging
        //        ];
        //    - Else (e.g., 400 Bad Request, 401 Unauthorized, 403 Forbidden, 500 Internal Server Error):
        //        $body = $response->getBody()->getContents();
        //        // Log error: error_log("Whaticket API error: Status " . $statusCode . " Body: " . $body);
        //        return [
        //            'status' => 'error',
        //            'message' => 'Whaticket API returned an error.',
        //            'status_code' => $statusCode,
        //            'details' => json_decode($body, true) ?? $body // Attempt to parse error, or return raw
        //        ];

        // Placeholder return for the skeleton method
        return [
            'status' => 'pending', // Using 'pending' as it's a placeholder before actual implementation
            'message_id' => $messageId ?? 'simulated_id_' . uniqid(),
            'details' => 'Message submission placeholder. API call not yet implemented.'
        ];
    }
}
