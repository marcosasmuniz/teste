<?php

declare(strict_types=1);

namespace App\Models;

class Customer
{
    public ?int $id;
    public ?string $asaas_customer_id;
    public string $name;
    public string $email;
    public string $whatsapp_number;
    public ?string $cpf_cnpj;
    public ?string $created_at; // Assuming string representation for simplicity
    public ?string $updated_at; // Assuming string representation for simplicity

    public function __construct(
        ?int $id,
        ?string $asaas_customer_id,
        string $name,
        string $email,
        string $whatsapp_number,
        ?string $cpf_cnpj,
        ?string $created_at,
        ?string $updated_at
    ) {
        $this->id = $id;
        $this->asaas_customer_id = $asaas_customer_id;
        $this->name = $name;
        $this->email = $email;
        $this->whatsapp_number = $whatsapp_number;
        $this->cpf_cnpj = $cpf_cnpj;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAsaasCustomerId(): ?string
    {
        return $this->asaas_customer_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getWhatsappNumber(): string
    {
        return $this->whatsapp_number;
    }

    public function getCpfCnpj(): ?string
    {
        return $this->cpf_cnpj;
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
