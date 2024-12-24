<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entity\Url;
use App\Domain\Repositories\UrlRepository;
use App\Exceptions\Domain\Repositories\DuplicateShortCodeException;
use Illuminate\Support\Str;

class RandomUrlShortener implements UrlShortener
{
    private const BASE_SHORT_URL = 'http://short.est';

    public function __construct(
        private readonly UrlRepository $urlRepository,
    ) {
    }

    public function encode(string $url): string
    {
        $existingUrl = $this->urlRepository->findByOriginalUrl($url);

        if ($existingUrl) {
            return $this->formatUrl($existingUrl->getShortCode());
        }

        $newUrl = $this->shortenUrl($url);

        return $this->formatUrl($newUrl->getShortCode());
    }

    public function decode(string $url): ?string
    {
        $shortCode = Str::after($url, self::BASE_SHORT_URL . '/');
        $entity = $this->urlRepository->findByShortCode($shortCode);

        return $entity?->getOriginalUrl();
    }

    private function formatUrl(string $shortCode): string
    {
        return sprintf('%s/%s', self::BASE_SHORT_URL, $shortCode);
    }

    private function shortenUrl(string $url): Url
    {
        while(true) {
            try {
                $newUrl = new Url(
                    originalUrl: $url,
                    shortCode: Str::random(6),
                );

                $this->urlRepository->save($newUrl);
                break;
            } catch (DuplicateShortCodeException) {
                // If the short code already exists, generate a new one
                continue;
            }
        }

        return $newUrl;
    }
}
