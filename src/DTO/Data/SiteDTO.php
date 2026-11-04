<?php

declare(strict_types=1);

namespace App\DTO\Data;

use App\DTOFactory\Data\SiteDTOFactory;

/**
 * @see SiteDTOFactory
 *
 * @property array<int, NavigationDTO> $mainNavigation
 */
readonly class SiteDTO
{
    public function __construct(
        public string $domain,
        public ?string $title,
        public ?string $description,
        public ?string $homepage,
        public ?array $mainNavigation,
    ) {
    }
}
