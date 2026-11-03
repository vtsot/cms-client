<?php

declare(strict_types=1);

namespace App\DTO\Data;

use App\Contract\Dictionary\Link\LinkTarget;
use App\Contract\Dictionary\Link\LinkType;
use App\DTOFactory\Data\LinkDTOFactory;

/**
 * @see LinkDTOFactory
 */
readonly class LinkDTO
{
    public function __construct(
        public ?string $url = null,
        public ?string $slug = null,
        public ?LinkType $type = LinkType::Page,
        public ?LinkTarget $target = LinkTarget::Top,
        public ?bool $noFollow = false,
    ) {
    }
}
