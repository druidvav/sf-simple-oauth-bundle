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
 * AmazonResourceOwner.
 *
 * @author Fabian Kiss <fabian.kiss@ymc.ch>
 *
 * @final since 1.4
 */
class AmazonResourceOwner extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritdoc}
     */
    protected $paths = [
        'identifier' => 'user_id',
        'nickname' => 'name',
        'realname' => 'name',
        'email' => 'email',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'authorization_url' => 'https://www.amazon.com/ap/oa',
            'access_token_url' => 'https://api.amazon.com/auth/o2/token',
            'infos_url' => 'https://api.amazon.com/user/profile',

            'scope' => 'profile',
        ]);
    }
}
