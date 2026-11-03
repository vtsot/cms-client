<?php

declare(strict_types=1);

namespace App\DTOFactory\Data;

use App\DTO\Data\BannerDTO;

readonly class BannerDTOFactory
{
    public function __construct(
        private LinkDTOFactory $linkDTOFactory,
    ) {
    }

    public function fromAPI(array $data): BannerDTO
    {
        $link = $data['link'] ?? null
            ? $this->linkDTOFactory->fromAPI($data['link'])
            : null;

        return new BannerDTO(
            title: $data['title'] ?? null,
            imageAlt: $data['image_alt'] ?? null,
            desktopImage: $data['desktop_image'] ?? null,
            mobileImage: $data['mobile_image'] ?? null,
            link: $link,
        );
    }
}
