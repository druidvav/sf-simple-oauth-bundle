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
 * EveOnlineResourceOwner.
 *
 * @author Ivan Stankovic <ivan.stankovic@webstorm.rs>
 *
 * @final since 1.4
 */
class EveOnlineResourceOwner extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritdoc}
     */
    protected $paths = [
        'identifier' => 'CharacterID',
        'nickname' => 'CharacterName',
        'realname' => 'CharacterName',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'authorization_url' => 'https://login.eveonline.com/oauth/authorize',
            'access_token_url' => 'https://login.eveonline.com/oauth/token',
            'infos_url' => 'https://login.eveonline.com/oauth/verify',
            'use_commas_in_scope' => true,
        ]);
    }
}
