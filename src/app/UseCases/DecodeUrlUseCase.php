<?php

declare(strict_types=1);

namespace App\UseCases;

use App\Domain\Services\UrlShortener;

readonly class DecodeUrlUseCase
{
    public function __construct(
        private UrlShortener $urlRepository
    ) {
    }

    public function execute(string $shortUrl): ?string
    {
        return $this->urlRepository->decode($shortUrl);
    }
}
