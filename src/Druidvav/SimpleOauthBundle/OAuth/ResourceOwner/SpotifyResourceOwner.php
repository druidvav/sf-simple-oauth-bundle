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
 * @author Janne Savolainen <janne.savolainen@sempre.fi>
 *
 * @final since 1.4
 */
class SpotifyResourceOwner extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritdoc}
     */
    protected $paths = [
        'identifier' => 'id',
        'nickname' => 'id',
        'realname' => 'display_name',
        'email' => 'email',
    ];

    /**
     * {@inheritdoc}
     */
    public function getUserInformation(array $accessToken = null, array $extraParameters = [])
    {
        $url = $this->normalizeUrl($this->options['infos_url'], [
            'access_token' => $accessToken['access_token'],
        ]);

        $content = $this->doGetUserInformationRequest($url)->getBody();

        $response = $this->getUserResponse();
        $response->setData((string) $content);
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
            'authorization_url' => 'https://accounts.spotify.com/authorize',
            'access_token_url' => 'https://accounts.spotify.com/api/token',
            'infos_url' => 'https://api.spotify.com/v1/me',
        ]);
    }
}
