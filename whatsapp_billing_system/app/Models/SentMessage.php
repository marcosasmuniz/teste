<?php

declare(strict_types=1);

namespace App\Models;

class SentMessage
{
    public ?int $id;
    public ?int $customer_id;
    public ?int $invoice_id;
    public ?int $message_template_id;
    public string $message_content_sent;
    public string $recipient_whatsapp_number;
    public string $status;
    public ?string $whaticket_message_id;
    public ?string $sent_at; // Assuming string representation
    public ?string $error_message;

    public function __construct(
        ?int $id,
        ?int $customer_id,
        ?int $invoice_id,
        ?int $message_template_id,
        string $message_content_sent,
        string $recipient_whatsapp_number,
        string $status,
        ?string $whaticket_message_id,
        ?string $sent_at,
        ?string $error_message
    ) {
        $this->id = $id;
        $this->customer_id = $customer_id;
        $this->invoice_id = $invoice_id;
        $this->message_template_id = $message_template_id;
        $this->message_content_sent = $message_content_sent;
        $this->recipient_whatsapp_number = $recipient_whatsapp_number;
        $this->status = $status;
        $this->whaticket_message_id = $whaticket_message_id;
        $this->sent_at = $sent_at;
        $this->error_message = $error_message;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomerId(): ?int
    {
        return $this->customer_id;
    }

    public function getInvoiceId(): ?int
    {
        return $this->invoice_id;
    }

    public function getMessageTemplateId(): ?int
    {
        return $this->message_template_id;
    }

    public function getMessageContentSent(): string
    {
        return $this->message_content_sent;
    }

    public function getRecipientWhatsappNumber(): string
    {
        return $this->recipient_whatsapp_number;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getWhaticketMessageId(): ?string
    {
        return $this->whaticket_message_id;
    }

    public function getSentAt(): ?string
    {
        return $this->sent_at;
    }

    public function getErrorMessage(): ?string
    {
        return $this->error_message;
    }
}
