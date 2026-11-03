<?php

declare(strict_types=1);

namespace App\DTO\Data;

use App\DTOFactory\Data\SiteDTOFactory;

/**
 * @see SiteDTOFactory
 */
readonly class SiteDTO
{
    public function __construct(
        public string $domain,
        public ?string $title,
        public ?string $description,
        public ?string $homepage,
        /** @var NavigationDTO[] */
        public ?array $mainNavigation,
    ) {
    }
}
