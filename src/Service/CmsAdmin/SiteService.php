<?php

declare(strict_types=1);

namespace App\Service\CmsAdmin;

use App\DTO\Data\SiteDTO;
use App\DTOFactory\Data\SiteDTOFactory;
use App\Exception\CommunicationException;
use App\Service\CmsAdmin\Traits\ResolveErrorsDetailsTrait;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

final readonly class SiteService
{
    use ResolveErrorsDetailsTrait;

    public function __construct(
        private AuthService $auth,
        private SiteDTOFactory $siteDTOFactory,
        #[Autowire(service: 'cms_admin.site_content.http_client')]
        private HttpClientInterface $httpClient,
    ) {
    }

    public function getSite(?bool $throwException = false): ?SiteDTO
    {
        try {
            $token   = $this->auth->login();
            $request = $this->httpClient->request('GET', '', [
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

        return $this->siteDTOFactory->fromAPI($response);
    }
}
