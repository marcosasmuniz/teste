<?php

declare(strict_types=1);

namespace App\Models;

class MessageTemplate
{
    public ?int $id;
    public string $name;
    public string $content;
    public ?string $type;
    public ?string $created_at;
    public ?string $updated_at;

    public function __construct(
        ?int $id,
        string $name,
        string $content,
        ?string $type,
        ?string $created_at,
        ?string $updated_at
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->content = $content;
        $this->type = $type;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getType(): ?string
    {
        return $this->type;
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
