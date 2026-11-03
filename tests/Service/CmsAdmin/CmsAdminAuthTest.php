<?php

declare(strict_types=1);

namespace App\Tests\Service\CmsAdmin;

use App\Exception\CommunicationException;
use App\Service\CmsAdmin\AuthService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\JsonMockResponse;
use Symfony\Component\HttpClient\Response\MockResponse;

use const JSON_THROW_ON_ERROR;

final class CmsAdminAuthTest extends KernelTestCase
{
    public function testLoginSendsCredentialsAndReturnsTokens(): void
    {
        $response = new JsonMockResponse(['token' => 'jwt', 'refresh_token' => 'refresh']);

        $tokens = $this->createAuth($response)->login();

        self::assertSame(['token' => 'jwt', 'refresh_token' => 'refresh'], $tokens);
        self::assertSame('POST', $response->getRequestMethod());
        self::assertSame('https://api.cms-admin.local/sites/auth/login', $response->getRequestUrl());
        self::assertSame(
            ['username', 'password'],
            array_keys(json_decode($response->getRequestOptions()['body'], true, 512, JSON_THROW_ON_ERROR)),
        );
    }

    public function testLoginWrapsRejectedRequestWithApiMessage(): void
    {
        $auth = $this->createAuth(new JsonMockResponse(['code' => 401, 'message' => 'Invalid credentials.'], ['http_code' => 401]));

        try {
            $auth->login();
            self::fail('Expected a CommunicationException.');
        } catch (CommunicationException $e) {
            self::assertSame(401, $e->getCode());
            self::assertSame('Invalid credentials.', $e->getMessage());
            self::assertNotNull($e->getPrevious());
        }
    }

    public function testLoginWrapsServerErrorWithHtmlBody(): void
    {
        $auth = $this->createAuth(new MockResponse('<html>Internal Server Error</html>', ['http_code' => 500]));

        try {
            $auth->login();
            self::fail('Expected a CommunicationException.');
        } catch (CommunicationException $e) {
            self::assertSame(500, $e->getCode());
            self::assertStringContainsString('500', $e->getMessage());
        }
    }

    public function testLoginWrapsTransportFailure(): void
    {
        $auth = $this->createAuth(new MockResponse(info: ['error' => 'Connection refused']));

        $this->expectException(CommunicationException::class);
        $this->expectExceptionMessage('Connection refused');

        $auth->login();
    }

    public function testLoginWrapsThrownTransportException(): void
    {
        $auth = $this->createAuth(static fn () => throw new TransportException('DNS failure'));

        $this->expectException(CommunicationException::class);
        $this->expectExceptionMessage('DNS failure');

        $auth->login();
    }

    public function testLoginWrapsInvalidJsonInSuccessfulResponse(): void
    {
        $auth = $this->createAuth(new MockResponse('not json', ['http_code' => 200]));

        $this->expectException(CommunicationException::class);

        $auth->login();
    }

    private function createAuth(callable|MockResponse $response): AuthService
    {
        static::getContainer()->set(
            'cms_admin.site_auth.http_client',
            new MockHttpClient($response),
        );

        return static::getContainer()->get(AuthService::class);
    }
}
