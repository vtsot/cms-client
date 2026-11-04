<?php

declare(strict_types=1);

namespace App\DTOFactory\Data\Page;

use App\Contract\Dictionary\PageSitemapChangeFrequency;
use App\Contract\Dictionary\PageSitemapPriority;
use App\Contract\Dictionary\PageType;
use App\DTO\Data\Page\ArticleDetailsDTO;

readonly class ArticleDetailsDTOFactory
{
    public function fromAPI(array $data): ArticleDetailsDTO
    {
        return new ArticleDetailsDTO(
            id: $data['id'] ?? '',
            slug: $data['slug'] ?? '',
            type: PageType::Article,
            title: $data['title'] ?? null,
            imageAlt: $data['image_alt'] ?? null,
            image: $data['image'] ?? null,
            description: $data['description'] ?? null,
            content: $data['content'] ?? null,
            sources: $data['sources'] ?? null,
            redirect: $data['redirect'] ?? null,
            codeBlock: $data['code_block'] ?? null,
            metaTitle: $data['meta_title'] ?? null,
            metaKeywords: $data['meta_keywords'] ?? null,
            metaDescription: $data['meta_description'] ?? null,
            ogTitle: $data['og_title'] ?? null,
            ogDescription: $data['og_description'] ?? null,
            ogImage: $data['og_image'] ?? null,
            indexed: $data['indexed'] ?? true,
            sitemapChangeFrequency: PageSitemapChangeFrequency::tryFrom((string) ($data['sitemap_change_frequency'] ?? '')) ?? PageSitemapChangeFrequency::DEFAULT,
            sitemapPriority: PageSitemapPriority::tryFrom((string) ($data['sitemap_priority'] ?? '')) ?? PageSitemapPriority::DEFAULT,
        );
    }
}
