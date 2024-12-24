<?php

declare(strict_types=1);

namespace App\Infrastructure\Db\Mappers;

use App\Domain\Entity\Url;
use App\Models\Url as UrlModel;

class UrlMapper
{
    public function toEntity(UrlModel $urlModel): Url
    {
        return new Url(
            id: $urlModel->id,
            originalUrl: $urlModel->original_url,
            shortCode: $urlModel->short_code,
            createdAt: $urlModel->created_at?->toImmutable(),
            updatedAt: $urlModel->updated_at?->toImmutable()
        );
    }

    public function toModel(Url $url): UrlModel
    {
        $urlModel = new UrlModel();
        $urlModel->id = $url->getId();
        $urlModel->original_url = $url->getOriginalUrl();
        $urlModel->short_code = $url->getShortCode();

        if ($url->getCreatedAt()) {
            $urlModel->created_at = $url->getCreatedAt();
        }

        if ($url->getUpdatedAt()) {
            $urlModel->updated_at = $url->getUpdatedAt();
        }

        $urlModel->exists = $url->getId() !== null;

        return $urlModel;
    }
}
