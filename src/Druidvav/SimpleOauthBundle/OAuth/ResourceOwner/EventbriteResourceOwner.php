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

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * EventbriteResourceOwner.
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 *
 * @final since 1.4
 */
class EventbriteResourceOwner extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritdoc}
     */
    protected $paths = [
        'identifier' => 'user.user_id',
        'nickname' => 'user.first_name',
        'firstname' => 'user.first_name',
        'lastname' => 'user.last_name',
        'realname' => ['user.first_name', 'user.last_name'],
        'email' => 'email',
    ];

    /**
     * {@inheritdoc}
     */
    protected function doGetTokenRequest($url, array $parameters = [])
    {
        return $this->httpRequest($url, http_build_query($parameters, '', '&'), [], 'POST');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'authorization_url' => 'https://www.eventbrite.com/oauth/authorize',
            'access_token_url' => 'https://www.eventbrite.com/oauth/token',
            'infos_url' => 'https://www.eventbrite.com/json/user_get',

            'use_bearer_authorization' => true,
        ]);
    }
}
