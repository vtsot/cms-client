<?php

declare(strict_types=1);

namespace App\DTO\Data\Page;

use App\Contract\Dictionary\PageSitemapChangeFrequency;
use App\Contract\Dictionary\PageSitemapPriority;
use App\Contract\Dictionary\PageType;

/**
 * @see ArticleDetailsDTOFactory
 */
readonly class ArticleDetailsDTO
{
    public function __construct(
        public string $id,
        public string $slug,
        public PageType $type,
        public ?string $title,
        public ?string $imageAlt,
        public ?string $image,
        public ?string $description,
        public ?string $content,
        public ?string $sources,
        public ?string $redirect,
        public ?string $codeBlock,
        public ?string $metaTitle,
        public ?string $metaKeywords,
        public ?string $metaDescription,
        public ?string $ogTitle,
        public ?string $ogDescription,
        public ?string $ogImage,
        public ?bool $indexed,
        public ?PageSitemapChangeFrequency $sitemapChangeFrequency = PageSitemapChangeFrequency::DEFAULT,
        public ?PageSitemapPriority $sitemapPriority = PageSitemapPriority::DEFAULT,
    ) {
    }
}
