<?php

declare(strict_types=1);

namespace App\DTO\Data\Page;

use App\Contract\Dictionary\PageType;
use App\DTOFactory\Data\Page\ArticleInfoDTOFactory;

/**
 * @see ArticleInfoDTOFactory
 */
readonly class ArticleInfoDTO
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
    ) {
    }
}
