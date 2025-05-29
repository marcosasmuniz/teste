<?php

declare(strict_types=1);

namespace App\Models;

class Invoice
{
    public ?int $id;
    public string $asaas_invoice_id;
    public ?int $customer_id; // Can be nullable if an invoice could exist without a customer temporarily
    public string $due_date;
    public float $amount;
    public string $status;
    public ?string $payment_link;
    public ?string $created_at;
    public ?string $updated_at;

    public function __construct(
        ?int $id,
        string $asaas_invoice_id,
        ?int $customer_id,
        string $due_date,
        float $amount,
        string $status,
        ?string $payment_link,
        ?string $created_at,
        ?string $updated_at
    ) {
        $this->id = $id;
        $this->asaas_invoice_id = $asaas_invoice_id;
        $this->customer_id = $customer_id;
        $this->due_date = $due_date;
        $this->amount = $amount;
        $this->status = $status;
        $this->payment_link = $payment_link;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAsaasInvoiceId(): string
    {
        return $this->asaas_invoice_id;
    }

    public function getCustomerId(): ?int
    {
        return $this->customer_id;
    }

    public function getDueDate(): string
    {
        return $this->due_date;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getPaymentLink(): ?string
    {
        return $this->payment_link;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }
}
