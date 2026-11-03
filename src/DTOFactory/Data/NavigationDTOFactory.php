<?php

declare(strict_types=1);

namespace App\DTOFactory\Data;

use App\DTO\Data\NavigationDTO;

use function array_key_exists;
use function is_array;

readonly class NavigationDTOFactory
{
    public function __construct(
        private LinkDTOFactory $linkDTOFactory,
    ) {
    }

    /**
     * @return array<int, NavigationDTO>
     */
    public function fromAPICollection(array $collection): array
    {
        $result = [];

        foreach ($collection as $item) {
            $result[] = $this->fromAPI($item);
        }

        return $result;
    }

    public function fromAPI(array $data): NavigationDTO
    {
        $children = [];

        if (array_key_exists('children', $data) && is_array($data['children'])) {
            $children = $this->fromAPICollection($data['children']);
        }

        return new NavigationDTO(
            title: $data['title'] ?? null,
            link: ($data['link']['type'] ?? null) ? $this->linkDTOFactory->fromAPI($data['link']) : null,
            children: $children,
        );
    }
}
