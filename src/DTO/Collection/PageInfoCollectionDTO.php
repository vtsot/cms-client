<?php

declare(strict_types=1);

namespace App\DTO\Collection;

use App\DTO\Data\Page\ArticleInfoDTO;
use App\DTO\Data\Page\PageInfoDTO;

final readonly class PageInfoCollectionDTO extends AbstractCollectionDTO
{
    /** @var PageInfoDTO[]|ArticleInfoDTO[] */
    public array $items;
}
