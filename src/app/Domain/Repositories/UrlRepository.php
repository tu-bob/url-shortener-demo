<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entity\Url;
use App\Exceptions\Domain\Repositories\DuplicateShortCodeException;

interface UrlRepository
{
    public function findByOriginalUrl(string $originalUrl): ?Url;

    public function findByShortCode(string $shortCode): ?Url;

    /**
     * @throws DuplicateShortCodeException
     */
    public function save(Url $url): Url;
}
