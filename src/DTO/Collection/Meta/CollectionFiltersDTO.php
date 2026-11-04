<?php

declare(strict_types=1);

namespace App\DTO\Collection\Meta;

final readonly class CollectionFiltersDTO
{
    public function __construct(
        public ?string $query = null,
        public ?string $sort = null,
        public ?array $availableSortBy = [],
        public ?array $availableFilters = [],
        public ?array $appliedFilters = [],
    ) {
    }
}
