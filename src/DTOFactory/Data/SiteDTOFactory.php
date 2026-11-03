<?php

declare(strict_types=1);

namespace App\DTOFactory\Data;

use App\DTO\Data\SiteDTO;

readonly class SiteDTOFactory
{
    public function __construct(
        private NavigationDTOFactory $navigationDTOFactory,
    ) {
    }

    public function fromAPI(array $data): SiteDTO
    {
        $mainNavigation = $data['main_navigation'] ?? null
            ? $this->navigationDTOFactory->fromAPICollection($data['main_navigation'])
            : null;

        return new SiteDTO(
            domain: $data['domain'] ?? null,
            title: $data['title'] ?? null,
            description: $data['description'] ?? null,
            homepage: $data['homepage'] ?? null,
            mainNavigation: $mainNavigation,
        );
    }
}
