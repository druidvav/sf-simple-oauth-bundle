<?php

/*
 * This file is part of the HWIOAuthBundle package.
 *
 * (c) Hardware Info <opensource@hardware.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Druidvav\SimpleOauthBundle\OAuth\ResourceOwner;

use Druidvav\SimpleOauthBundle\OAuth\OAuthToken;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * TraktResourceOwner.
 *
 * @author Julien DIDIER <julien@didier.io>
 *
 * @final since 1.4
 */
class TraktResourceOwner extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritdoc}
     */
    protected $paths = [
        'identifier' => 'username',
        'nickname' => 'username',
        'realname' => 'name',
        'profilepicture' => 'images.avatar.full',
    ];

    /**
     * {@inheritdoc}
     */
    public function getUserInformation(array $accessToken, array $extraParameters = [])
    {
        $content = $this->httpRequest($this->normalizeUrl($this->options['infos_url']), null, [
            'Authorization' => 'Bearer '.$accessToken['access_token'],
            'Content-Type' => 'application/json',
            'trakt-api-key' => $this->options['client_id'],
            'trakt-api-version' => 2,
        ]);

        $response = $this->getUserResponse();
        $response->setData((string) $content->getBody());
        $response->setResourceOwner($this);
        $response->setOAuthToken(new OAuthToken($accessToken));

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'authorization_url' => 'https://api-v2launch.trakt.tv/oauth/authorize',
            'access_token_url' => 'https://api-v2launch.trakt.tv/oauth/token',
            'infos_url' => 'https://api-v2launch.trakt.tv/users/me?extended=images',
        ]);
    }
}
