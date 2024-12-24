<?php

declare(strict_types=1);

namespace App\Infrastructure\Db\Repositories;

use App\Domain\Entity\Url;
use App\Domain\Repositories\UrlRepository as UrlRepositoryInterface;
use App\Exceptions\Domain\Repositories\DuplicateShortCodeException;
use App\Infrastructure\Db\Mappers\UrlMapper;
use App\Models\Url as UrlModel;
use Illuminate\Database\UniqueConstraintViolationException;

readonly class UrlRepository implements UrlRepositoryInterface
{
    public function __construct(
        private UrlMapper $urlMapper
    ) {
    }

    public function findByOriginalUrl(string $originalUrl): ?Url
    {
        $model = UrlModel::query()
            ->where('original_url', $originalUrl)
            ->first();

        if ($model === null) {
            return null;
        }

        return $this->urlMapper->toEntity($model);
    }

    public function findByShortCode(string $shortCode): ?Url
    {
        $model = UrlModel::query()
            ->where('short_code', $shortCode)
            ->first();

        if ($model === null) {
            return null;
        }

        return $this->urlMapper->toEntity($model);
    }

    /**
     * @throws DuplicateShortCodeException
     */
    public function save(Url $url): Url
    {
        try {
            $model = $this->urlMapper->toModel($url);
            $model->save();
        } catch (UniqueConstraintViolationException $e) {
            throw new DuplicateShortCodeException($url->getShortCode(), $e);
        }

        return $this->urlMapper->toEntity($model);
    }
}
