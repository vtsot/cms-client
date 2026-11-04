<?php

declare(strict_types=1);

namespace App\DTO\Collection;

use App\DTO\Collection\Meta\CollectionFiltersDTO;
use App\DTO\Collection\Meta\CollectionMetaDTO;
use App\DTO\Collection\Meta\CollectionPaginatorDTO;

abstract readonly class AbstractCollectionDTO
{
    public function __construct(
        /** @var object[]|mixed[] */
        public array $items,

        public ?CollectionMetaDTO $meta,
    ) {
    }

    public static function fromArray(array $items, array $paginator = [], array $filters = [], ?array $debug = null): static
    {
        $paginatorDTO = new CollectionPaginatorDTO(
            page: $paginator['page'] ?? 1,
            perPage: $paginator['per_page'] ?? 1,
            total: $paginator['total'] ?? 0,
        );

        $filtersDTO = new CollectionFiltersDTO(
            query: $filters['query'] ?? null,
            sort: $filters['sort'] ?? null,
            availableSortBy: $filters['available_sort_by'] ?? null,
            availableFilters: $filters['available_filters'] ?? null,
            appliedFilters: $filters['applied_filters'] ?? null,
        );

        return new static(
            items: $items,
            meta: new CollectionMetaDTO(paginator: $paginatorDTO, filters: $filtersDTO, debug: $debug),
        );
    }
}
