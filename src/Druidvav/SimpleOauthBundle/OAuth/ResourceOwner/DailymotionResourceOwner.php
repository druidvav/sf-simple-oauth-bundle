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
 * DailymotionResourceOwner.
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 *
 * @final since 1.4
 */
class DailymotionResourceOwner extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritdoc}
     */
    protected $paths = [
        'identifier' => 'id',
        'nickname' => 'screenname',
        'realname' => 'fullname', // requires 'userinfo' scope
        'email' => 'email', // requires 'email' scope
        'profilepicture' => 'avatar_medium_url',
    ];

    /**
     * {@inheritdoc}
     */
    public function getAuthorizationUrl($redirectUri, array $extraParameters = [])
    {
        return parent::getAuthorizationUrl($redirectUri, array_merge(['display' => $this->options['display']], $extraParameters));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'authorization_url' => 'https://api.dailymotion.com/oauth/authorize',
            'access_token_url' => 'https://api.dailymotion.com/oauth/token',
            'infos_url' => 'https://api.dailymotion.com/me',

            'display' => null,
        ]);

        // @link http://www.dailymotion.com/doc/api/authentication.html#dialog-form-factors
        $resolver->setAllowedValues('display', ['page', 'popup', 'mobile', null]);
    }
}
