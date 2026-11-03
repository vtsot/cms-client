<?php

declare(strict_types=1);

namespace App\DTOFactory\Data;

use App\Contract\Dictionary\Link\LinkTarget;
use App\Contract\Dictionary\Link\LinkType;
use App\DTO\Data\LinkDTO;

use function in_array;

readonly class LinkDTOFactory
{
    public function fromAPI(array $data): LinkDTO
    {
        $url  = LinkType::Link->value === ($data['type'] ?? null) && ($data['url'] ?? null) ? $data['url'] : null;
        $slug = in_array($data['type'] ?? null, [LinkType::Page->value, LinkType::Article->value], true) && ($data['slug'] ?? null)
            ? $data['slug']
            : null;

        return new LinkDTO(
            $url,
            $slug,
            ($data['type'] ?? null) ? LinkType::tryFrom($data['type']) : null,
            ($data['target'] ?? null) ? LinkTarget::tryFrom($data['target']) : null,
            (bool) ($data['no_follow'] ?? false),
        );
    }
}
