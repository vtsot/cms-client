<?php

declare(strict_types=1);

namespace App\DTOFactory\Data\Page;

use App\Contract\Dictionary\PageType;
use App\DTO\Data\Page\ArticleInfoDTO;

readonly class ArticleInfoDTOFactory
{
    public function fromAPICollection(array $collection): array
    {
        $result = [];

        foreach ($collection as $item) {
            $result[] = $this->fromAPI($item);
        }

        return $result;
    }

    public function fromAPI(array $data): ArticleInfoDTO
    {
        return new ArticleInfoDTO(
            id: $data['id'] ?? '',
            slug: $data['slug'] ?? '',
            type: PageType::Article,
            title: $data['title'] ?? null,
            imageAlt: $data['imageAlt'] ?? null,
            image: $data['image'] ?? null,
            description: $data['description'] ?? null,
            content: $data['content'] ?? null,
            sources: $data['sources'] ?? null,
        );
    }
}
