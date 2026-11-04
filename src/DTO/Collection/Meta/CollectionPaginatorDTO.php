<?php

declare(strict_types=1);

namespace App\DTO\Collection\Meta;

final readonly class CollectionPaginatorDTO
{
    public function __construct(
        public int $page,
        public int $perPage,
        public int $total,
    ) {
    }
}
