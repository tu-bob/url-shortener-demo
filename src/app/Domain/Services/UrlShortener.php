<?php

declare(strict_types=1);

namespace App\Domain\Services;

interface UrlShortener
{
    public function encode(string $url): string;

    public function decode(string $url): ?string;
}
