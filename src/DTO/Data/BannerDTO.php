<?php

declare(strict_types=1);

namespace App\DTO\Data;

use App\DTOFactory\Data\BannerDTOFactory;

/**
 * @see BannerDTOFactory
 */
readonly class BannerDTO
{
    public function __construct(
        public ?string $title,
        public ?string $imageAlt,
        public ?string $desktopImage,
        public ?string $mobileImage,
        public ?LinkDTO $link,
    ) {
    }
}
