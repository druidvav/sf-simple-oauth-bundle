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
 * StravaResourceOwner.
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 *
 * @final since 1.4
 */
class StravaResourceOwner extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritdoc}
     */
    protected $paths = [
        'identifier' => 'id',
        'realname' => ['firstname', 'lastname'],
        'profilepicture' => 'profile_medium',
        'email' => 'email',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'authorization_url' => 'https://www.strava.com/oauth/authorize',
            'access_token_url' => 'https://www.strava.com/oauth/token',
            'infos_url' => 'https://www.strava.com/api/v3/athlete',
        ]);
    }
}
