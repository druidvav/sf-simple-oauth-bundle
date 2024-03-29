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
 * BitlyResourceOwner.
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 *
 * @final since 1.4
 */
class BitlyResourceOwner extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritdoc}
     */
    protected $paths = [
        'identifier' => 'data.login',
        'nickname' => 'data.display_name',
        'realname' => 'data.full_name',
        'profilepicture' => 'data.profile_image',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'use_bearer_authorization' => false,
            'authorization_url' => 'https://bitly.com/oauth/authorize',
            'access_token_url' => 'https://api-ssl.bitly.com/oauth/access_token',
            'infos_url' => 'https://api-ssl.bitly.com/v3/user/info?format=json',
        ]);
    }
}
