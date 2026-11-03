<?php

declare(strict_types=1);

namespace App\DTO\Data;

/**
 * @see NavigationDTOFactory
 */
readonly class NavigationDTO
{
    public function __construct(
        public ?string $title,
        public mixed /* ?LinkDTO */ $link,
        public array $children = [],
    ) {
    }
}
