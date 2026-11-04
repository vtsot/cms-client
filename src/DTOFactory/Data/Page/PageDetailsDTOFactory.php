<?php

declare(strict_types=1);

namespace App\DTOFactory\Data\Page;

use App\Contract\Dictionary\PageSitemapChangeFrequency;
use App\Contract\Dictionary\PageSitemapPriority;
use App\Contract\Dictionary\PageType;
use App\DTO\Data\Page\PageDetailsDTO;

readonly class PageDetailsDTOFactory
{
    public function __construct(
        private ArticleInfoDTOFactory $articleInfoDTOFactory,
    ) {
    }

    public function fromAPI(array $data): PageDetailsDTO
    {
        return new PageDetailsDTO(
            id: $data['id'] ?? '',
            slug: $data['slug'] ?? '',
            type: PageType::Page,
            isHomepage: $data['is_homepage'] ?? null,
            title: $data['title'] ?? null,
            content: $data['content'] ?? null,
            relatedArticlesTitle: $data['related_articles_title'] ?? null,
            relatedArticles: $this->articleInfoDTOFactory->fromAPICollection($data['related_articles'] ?? []),
            sources: $data['sources'] ?? null,
            redirect: $data['redirect'] ?? null,
            codeBlock: $data['code_block'] ?? null,
            metaTitle: $data['meta_title'] ?? null,
            metaKeywords: $data['meta_keywords'] ?? null,
            metaDescription: $data['meta_description'] ?? null,
            ogTitle: $data['og_title'] ?? null,
            ogDescription: $data['og_description'] ?? null,
            ogImage: $data['og_image'] ?? null,
            indexed: $data['indexed'] ?? null,
            sitemapChangeFrequency: PageSitemapChangeFrequency::tryFrom((string) ($data['sitemap_change_frequency'] ?? '')) ?? PageSitemapChangeFrequency::DEFAULT,
            sitemapPriority: PageSitemapPriority::tryFrom((string) ($data['sitemap_priority'] ?? '')) ?? PageSitemapPriority::DEFAULT,
        );
    }
}
