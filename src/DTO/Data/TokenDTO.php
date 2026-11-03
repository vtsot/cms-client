<?php

declare(strict_types=1);

namespace App\DTO\Data;

use App\DTOFactory\Data\TokenDTOFactory;

/**
 * @see TokenDTOFactory
 */
readonly class TokenDTO
{
    public function __construct(
        public string $token,
        public string $refreshToken,
        public int $refreshTokenExpiration,
    ) {
    }
}
