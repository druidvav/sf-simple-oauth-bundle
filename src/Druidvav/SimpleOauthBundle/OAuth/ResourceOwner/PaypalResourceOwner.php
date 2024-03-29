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

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * PaypalResourceOwner.
 *
 * @author Berny Cantos <be@rny.cc>
 *
 * @final since 1.4
 */
class PaypalResourceOwner extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritdoc}
     */
    protected $paths = [
        'identifier' => 'user_id',
        'nickname' => 'email',
        'email' => 'email',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'sandbox' => false,
            'scope' => 'openid email',
            'authorization_url' => 'https://www.paypal.com/webapps/auth/protocol/openidconnect/v1/authorize',
            'access_token_url' => 'https://api.paypal.com/v1/identity/openidconnect/tokenservice',
            'infos_url' => 'https://api.paypal.com/v1/identity/openidconnect/userinfo/?schema=openid',
        ]);

        $resolver->addAllowedTypes('sandbox', 'bool');

        $sandboxTransformation = function (Options $options, $value) {
            if (!$options['sandbox']) {
                return $value;
            }

            return preg_replace('~\.paypal\.~', '.sandbox.paypal.', $value, 1);
        };

        $resolver
            ->setNormalizer('authorization_url', $sandboxTransformation)
            ->setNormalizer('access_token_url', $sandboxTransformation)
            ->setNormalizer('infos_url', $sandboxTransformation)
        ;
    }
}
