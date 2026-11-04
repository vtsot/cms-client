<?php

declare(strict_types=1);

namespace App\DTO\Data\Page;

use App\Contract\Dictionary\PageType;
use App\DTOFactory\Data\Page\PageInfoDTOFactory;

/**
 * @see PageInfoDTOFactory
 */
readonly class PageInfoDTO
{
    public function __construct(
        public string $id,
        public string $slug,
        public PageType $type,
        public ?bool $isHomepage,
        public ?string $title,
        public ?string $content,
        public ?string $sources,
    ) {
    }
}
