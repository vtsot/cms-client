<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\JsonMockResponse;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpFoundation\Response;

final class DefaultControllerTest extends WebTestCase
{
    public function testHomepageRendersWhenLoginSucceeds(): void
    {
        $client = self::createClient();
        self::getContainer()->set(
            'cms_admin.site_auth.http_client',
            new MockHttpClient(new JsonMockResponse(['token' => 'jwt', 'refresh_token' => 'refresh'])),
        );

        $client->request('GET', '/');

        self::assertResponseIsSuccessful();
    }

    public function testHomepageShowsUnavailablePageWhenApiRejectsLogin(): void
    {
        $client = self::createClient();
        self::getContainer()->set(
            'cms_admin.site_auth.http_client',
            new MockHttpClient(new JsonMockResponse(['message' => 'secret api detail'], ['http_code' => 401])),
        );

        $client->request('GET', '/');

        self::assertResponseStatusCodeSame(Response::HTTP_SERVICE_UNAVAILABLE);
        self::assertSelectorExists('h1');
        self::assertStringNotContainsString('secret api detail', (string) $client->getResponse()->getContent());
    }

    public function testHomepageShowsUnavailablePageWhenApiIsUnreachable(): void
    {
        $client = self::createClient();
        self::getContainer()->set(
            'cms_admin.site_auth.http_client',
            new MockHttpClient(new MockResponse(info: ['error' => 'Connection refused'])),
        );

        $client->request('GET', '/');

        self::assertResponseStatusCodeSame(Response::HTTP_SERVICE_UNAVAILABLE);
        self::assertStringNotContainsString('Connection refused', (string) $client->getResponse()->getContent());
    }
}
