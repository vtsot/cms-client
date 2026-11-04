<?php

declare(strict_types=1);

namespace App\DTOFactory\Data\Page;

use App\Contract\Dictionary\PageType;
use App\DTO\Data\Page\PageInfoDTO;

readonly class PageInfoDTOFactory
{
    public function fromAPICollection(array $collection): array
    {
        $result = [];

        foreach ($collection as $item) {
            $result[] = $this->fromAPI($item);
        }

        return $result;
    }

    public function fromAPI(array $data): PageInfoDTO
    {
        return new PageInfoDTO(
            id: $data['id'] ?? '',
            slug: $data['slug'] ?? '',
            type: PageType::Page,
            isHomepage: $data['is_homepage'] ?? false,
            title: $data['title'] ?? null,
            content: $data['content'] ?? null,
            sources: $data['sources'] ?? null,
        );
    }
}
