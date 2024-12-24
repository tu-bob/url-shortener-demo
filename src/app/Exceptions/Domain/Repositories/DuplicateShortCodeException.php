<?php

declare(strict_types=1);

namespace App\Exceptions\Domain\Repositories;

use Exception;

class DuplicateShortCodeException extends Exception
{
    public function __construct(string $shortCode, Exception $previous = null)
    {
        parent::__construct(
            message: "Short code '$shortCode' is already in use.",
            code: $previous?->getCode() ?? 23000,
            previous: $previous
        );
    }
}
