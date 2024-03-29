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
 * XingResourceOwner.
 *
 * @author othillo <othillo@othillo.nl>
 *
 * @final since 1.4
 */
class XingResourceOwner extends GenericOAuth1ResourceOwner
{
    /**
     * {@inheritdoc}
     */
    protected $paths = [
        'identifier' => 'users.0.id',
        'nickname' => 'users.0.display_name',
        'firstname' => 'users.0.first_name',
        'lastname' => 'users.0.last_name',
        'realname' => ['users.0.first_name', 'users.0.last_name'],
        'profilepicture' => 'users.0.photo_urls.large',
        'email' => 'users.0.active_email',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'authorization_url' => 'https://api.xing.com/v1/authorize',
            'request_token_url' => 'https://api.xing.com/v1/request_token',
            'access_token_url' => 'https://api.xing.com/v1/access_token',
            'infos_url' => 'https://api.xing.com/v1/users/me',
        ]);
    }
}
