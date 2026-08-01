<?php

namespace Druidvav\SimpleOauthBundle\Tests\OAuth\ResourceOwner;

use Druidvav\SimpleOauthBundle\OAuth\RequestDataStorageInterface;
use Druidvav\SimpleOauthBundle\OAuth\ResourceOwner\AppleResourceOwner;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\HttpUtils;

final class AppleResourceOwnerTest extends TestCase
{
    public function testAccessTokenUsesFormPostParameters(): void
    {
        $resourceOwner = new TestableAppleResourceOwner(
            new Client(),
            $this->createStub(HttpUtils::class),
            [
                'client_id' => 'services-id',
                'client_secret' => 'client-secret',
            ],
            'apple',
            $this->createStub(RequestDataStorageInterface::class)
        );

        $request = Request::create('/callback?code=query-code&user=%7B%7D', 'POST', [
            'code' => 'post-code',
            'user' => json_encode([
                'name' => [
                    'firstName' => 'Ada',
                    'lastName' => 'Lovelace',
                ],
            ]),
        ]);

        $token = $resourceOwner->getAccessToken($request, 'https://example.com/callback');

        self::assertSame('post-code', $resourceOwner->tokenRequestParameters['code']);
        self::assertSame('Ada', $token['firstName']);
        self::assertSame('Lovelace', $token['lastName']);
    }
}

final class TestableAppleResourceOwner extends AppleResourceOwner
{
    public array $tokenRequestParameters = [];

    protected function doGetTokenRequest($url, array $parameters = [])
    {
        $this->tokenRequestParameters = $parameters;

        return new Response(200, [], json_encode([
            'access_token' => 'access-token',
            'id_token' => 'header.payload.signature',
        ]));
    }
}
