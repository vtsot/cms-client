<?php

declare(strict_types=1);

namespace App\DTOFactory\Data;

use App\Contract\Dictionary\Link\LinkTarget;
use App\Contract\Dictionary\Link\LinkType;
use App\DTO\Data\LinkDTO;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use function in_array;

readonly class LinkDTOFactory
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function fromAPI(array $data): LinkDTO
    {
        $url  = LinkType::Link->value === ($data['type'] ?? null) && ($data['url'] ?? null) ? $data['url'] : null;
        $slug = in_array($data['type'] ?? null, [LinkType::Page->value, LinkType::Article->value], true) && ($data['slug'] ?? null)
            ? $data['slug']
            : null;

        $type   = ($data['type'] ?? null) ? LinkType::tryFrom($data['type']) : null;
        $target = ($data['target'] ?? null) ? LinkTarget::tryFrom($data['target']) : null;

        $refType = UrlGeneratorInterface::ABSOLUTE_PATH;
        $href    = match (true) {
            $type === LinkType::Page && $slug === 'homepage' => $this->urlGenerator->generate('web.homepage', [], $refType),
            $type === LinkType::Page && $slug,
            $type === LinkType::Article && $slug => $this->urlGenerator->generate('web.cms', ['slug' => $slug], $refType),
            $type === LinkType::Link && $url     => $url,

            default => null,
        };

        return new LinkDTO(
            url: $url,
            slug: $slug,
            type: $type,
            target: $target,
            noFollow: (bool) ($data['no_follow'] ?? false),
            href: $href,
        );
    }
}
