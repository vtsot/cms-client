<?php

declare(strict_types=1);

namespace App\DTOFactory\Data;

use App\DTO\Data\TokenDTO;

class TokenDTOFactory
{
    public function fromAPI(array $data): TokenDTO
    {
        return new TokenDTO(
            token: $data['token'],
            refreshToken: $data['refresh_token'],
            refreshTokenExpiration: $data['refresh_token_expiration'],
        );
    }
}
