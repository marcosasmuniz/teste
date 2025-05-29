<?php

// cron_send_reminders.php
// Placeholder for automated billing reminder script

require_once __DIR__ . '/vendor/autoload.php'; // Assuming Composer autoloader
require_once __DIR__ . '/app/Services/AsaasService.php';
require_once __DIR__ . '/app/Services/WhaticketService.php';
require_once __DIR__ . '/app/Models/MessageTemplate.php'; // And other models if needed
require_once __DIR__ . '/config/config.php'; // For API keys, DB credentials

echo "Starting automated reminder process...\n";

// --- Configuration Loading ---
// 1. Load API keys and database credentials from config.php or environment variables.
//    Example: $asaasApiKey = ASAAS_API_KEY; $whaticketApiKey = WHATICKET_API_KEY; etc.

// --- Service Initialization ---
// 2. Initialize AsaasService and WhaticketService with their respective API keys and base URLs.
//    Example: $asaasService = new App\Services\AsaasService($asaasApiKey);
//    Example: $whaticketService = new App\Services\WhaticketService($whaticketApiKey, WHATICKET_API_URL);

// --- Database Connection (Conceptual) ---
// 3. Establish a database connection (e.g., using PDO).
//    Example: $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
//    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// --- Main Logic ---
// 4. Fetch Overdue/Due Invoices:
//    - Query the Asaas API (via AsaasService) for invoices that are due soon or overdue.
//      - Define criteria: e.g., invoices due in X days, invoices overdue by Y days.
//      - Potentially, first fetch customers from your local DB or Asaas, then their invoices.
//    echo "Fetching invoices from Asaas...\n";
//    // $invoices = $asaasService->getFilteredInvoices(['status' => 'OVERDUE']); // Example
//    // $invoices_due_soon = $asaasService->getFilteredInvoices(['due_date_after' => 'today', 'due_date_before' => 'today+5days']);

// 5. Iterate Through Invoices:
//    - For each relevant invoice:
//        a. Fetch Customer Details:
//           - Get customer details (especially WhatsApp number) from your local database or Asaas using the customer ID from the invoice.
//           echo "Processing invoice [INVOICE_ID] for customer [CUSTOMER_ID]...\n";
//           // $customer = fetchCustomerFromDb($invoice->customerId, $pdo); OR $customer = $asaasService->getCustomer($invoice->asaasCustomerId);

//        b. Determine Appropriate Message Template:
//           - Based on invoice status (due soon, overdue, specific overdue period), select a message template from the `message_templates` table in your database.
//           // $template = fetchMessageTemplateFromDb('overdue_reminder_level_1', $pdo);

//        c. Personalize Message:
//           - Replace placeholders in the template content (e.g., {{customer_name}}, {{invoice_id}}, {{due_date}}, {{payment_link}}) with actual data.
//           // $personalizedMessage = str_replace(['{{customer_name}}', '{{payment_link}}'], [$customer->name, $invoice->paymentLink], $template->content);

//        d. Check if Reminder Already Sent Recently:
//           - Query the `sent_messages` table to avoid sending too many reminders for the same invoice in a short period.
//           // $alreadySent = checkIfReminderSentRecently($invoice->id, $template->id, $pdo);

//        e. Send Message via Whaticket:
//           - If no recent reminder was sent:
//             // if (!$alreadySent) {
//             //    echo "Sending reminder to " . $customer->whatsappNumber . " for invoice " . $invoice->id . "\n";
//             //    $response = $whaticketService->sendMessage($customer->whatsappNumber, $personalizedMessage);
//             //    logMessageInDb($customer->id, $invoice->id, $template->id, $personalizedMessage, $response, $pdo);
//             // } else {
//             //    echo "Reminder already sent recently for invoice " . $invoice->id . "\n";
//             // }

// 6. Logging:
//    - Log all actions, successes, and failures (e.g., to `application_logs` table or a file).
//    echo "Logging results...\n";

// --- Cleanup ---
// 7. Close database connection if applicable.

echo "Automated reminder process finished.\n";

// --- Helper Function Stubs (Conceptual) ---
/*
function fetchCustomerFromDb(string $customerId, PDO $pdo) {
    // Placeholder: SELECT * FROM customers WHERE id = :customerId
    return null; // Replace with actual DB query
}

function fetchMessageTemplateFromDb(string $templateName, PDO $pdo) {
    // Placeholder: SELECT * FROM message_templates WHERE name = :templateName
    return null; // Replace with actual DB query
}

function checkIfReminderSentRecently(string $invoiceId, string $templateId, PDO $pdo, string $interval = '1 DAY') {
    // Placeholder: SELECT COUNT(*) FROM sent_messages WHERE invoice_id = :invoiceId AND message_template_id = :templateId AND sent_at > NOW() - INTERVAL :interval
    return false; // Replace with actual DB query
}

function logMessageInDb(string $customerId, string $invoiceId, string $templateId, string $content, array $apiResponse, PDO $pdo) {
    // Placeholder: INSERT INTO sent_messages (...) VALUES (...)
}
*/
