<?php

declare(strict_types=1);

namespace App\DTO;

final readonly class ErrorDTO
{
    public function __construct(
        public int $code,
        public string $message,
        /** @var mixed[] */
        public ?array $errors = null,
    ) {
    }
}
