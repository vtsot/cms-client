<?php

declare(strict_types=1);

namespace App\DTO\Data;

use App\Contract\Dictionary\Link\LinkTarget;
use App\Contract\Dictionary\Link\LinkType;
use App\DTOFactory\Data\LinkDTOFactory;

use function array_keys;
use function array_map;
use function array_values;
use function htmlspecialchars;
use function implode;
use function sprintf;

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
        public ?string $href = null,
    ) {
    }

    public function attributes(array $context = []): string
    {
        $active      = ($context['active'] ?? false);
        $activeClass = $context['active_class'] ?? 'active';
        $class       = (array) ($context['class'] ?? []);
        $attributes  = (array) ($context['attr'] ?? []);

        if ($active) {
            $class[] = $activeClass;
        }

        if ($class) {
            $attributes['class'] = implode(' ', $class);
        }

        if ($context['title'] ?? null) {
            $attributes['title'] = $context['title'];
        }

        if ($this->noFollow) {
            $attributes['rel'] = 'nofollow';
        }

        if ($this->target) {
            $attributes['target'] = $this->target->value;
        }

        return implode(
            ' ',
            array_map(
                static fn (string $k, string $v): string => sprintf('%s="%s"', $k, htmlspecialchars($v)),
                array_keys($attributes),
                array_values($attributes)
            )
        );
    }
}
