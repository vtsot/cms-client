<?php

declare(strict_types=1);

namespace App\Service\CmsAdmin;

use App\DTO\Data\BannerDTO;
use App\DTOFactory\Data\BannerDTOFactory;
use App\Exception\CommunicationException;
use App\Service\CmsAdmin\Traits\ResolveErrorsDetailsTrait;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

final readonly class BannerService
{
    use ResolveErrorsDetailsTrait;

    public function __construct(
        private AuthService $auth,
        private BannerDTOFactory $bannerDTOFactory,
        #[Autowire(service: 'cms_admin.site_content.http_client')]
        private HttpClientInterface $httpClient,
    ) {
    }

    public function getBanner(?bool $throwException = false): ?BannerDTO
    {
        try {
            $token   = $this->auth->login();
            $request = $this->httpClient->request('GET', 'banners/random', [
                'auth_bearer' => $token->token,
            ]);

            $response = $request->toArray();
        } catch (HttpExceptionInterface|TransportExceptionInterface|DecodingExceptionInterface|Throwable $e) {
            $response = $e instanceof HttpExceptionInterface ? $e->getResponse() : null;
            $code     = $e instanceof HttpExceptionInterface ? $response->getStatusCode() : 0;
            $errors   = $response ? $this->errorsDetailsAsString($response) : null;

            if ($throwException) {
                throw new CommunicationException($errors ?? $e->getMessage(), $code, $e);
            }

            return null;
        }

        return $this->bannerDTOFactory->fromAPI($response);
    }
}
