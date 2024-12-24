<?php

declare(strict_types=1);

namespace App\UseCases;

use App\Domain\Services\UrlShortener;

readonly class EncodeUrlUseCase
{
    public function __construct(
        private UrlShortener $urlRepository
    ) {
    }

    public function execute(string $originalUrl): string
    {
        return $this->urlRepository->encode($originalUrl);
    }
}
