<?php

declare(strict_types=1);

namespace App\Service\CmsAdmin\Traits;

use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Throwable;

use function array_keys;
use function array_map;
use function implode;
use function sprintf;

trait ResolveErrorsDetailsTrait
{
    private function errorsDetails(ResponseInterface $response): array
    {
        try {
            return $response->toArray(false); // false = don't throw on 4xx/5xx
        } catch (HttpExceptionInterface|TransportExceptionInterface|DecodingExceptionInterface|Throwable) {
            return []; // the error body may be HTML, not JSON
        }
    }

    private function errorsDetailsAsString(ResponseInterface $response): ?string
    {
        if (!$errors = $this->errorsDetails($response)) {
            return null;
        }

        return implode('; ', array_map(
            static fn ($key, $val) => sprintf('%s: %s', $key, $val),
            array_keys($errors),
            $errors
        ));
    }
}
