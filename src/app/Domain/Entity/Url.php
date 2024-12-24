<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Carbon\CarbonImmutable;

class Url
{
    public function __construct(
        private ?int $id = null,
        private string $originalUrl = '',
        private string $shortCode = '',
        private ?CarbonImmutable $createdAt = null,
        private ?CarbonImmutable $updatedAt = null
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getOriginalUrl(): string
    {
        return $this->originalUrl;
    }

    public function setOriginalUrl(string $originalUrl): void
    {
        $this->originalUrl = $originalUrl;
    }

    public function getShortCode(): string
    {
        return $this->shortCode;
    }

    public function setShortCode(string $shortCode): void
    {
        $this->shortCode = $shortCode;
    }

    public function getCreatedAt(): ?CarbonImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?CarbonImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?CarbonImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?CarbonImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
