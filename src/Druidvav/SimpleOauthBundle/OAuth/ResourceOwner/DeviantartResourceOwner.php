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
 * DeviantartResourceOwner.
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 *
 * @final since 1.4
 */
class DeviantartResourceOwner extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritdoc}
     */
    protected $paths = [
        'identifier' => 'username',
        'nickname' => 'username',
        'profilepicture' => 'usericonurl',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'authorization_url' => 'https://www.deviantart.com/oauth2/draft15/authorize',
            'access_token_url' => 'https://www.deviantart.com/oauth2/draft15/token',
            'infos_url' => 'https://www.deviantart.com/api/draft15/user/whoami',
        ]);
    }
}
