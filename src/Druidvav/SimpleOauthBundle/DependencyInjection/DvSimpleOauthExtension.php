<?php

namespace Druidvav\SimpleOauthBundle\DependencyInjection;

use Druidvav\SimpleOauthBundle\OAuth\RequestDataStorage\SessionStorage;
use Druidvav\SimpleOauthBundle\Service;
use Druidvav\SimpleOauthBundle\Service\OAuthService;
use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DvSimpleOauthExtension extends Extension
{
    /**
     * @param  array            $configs
     * @param  ContainerBuilder $container
     * @return void
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $definition = new Definition(Client::class);
        $definition->addArgument([ 'timeout' => 10 ]);
        $container->setDefinition('dv.oauth.guzzle', $definition);

        $definition = new Definition(SessionStorage::class);
        $definition->addArgument(new Reference('request_stack'));
        $container->setDefinition('dv.oauth.storage.session', $definition);

        $serviceIds = $this->enableServices($config['services'], $config, $container);

        $locatorServices = [];
        foreach ($serviceIds as $id) {
            $locatorServices[$id] = new Reference('dv.oauth.service.' . $id);
        }

        $locatorDefinition = new Definition(ServiceLocator::class, [$locatorServices]);
        $locatorDefinition->addTag('container.service_locator');
        $container->setDefinition('dv.oauth.service_locator', $locatorDefinition);

        $definition = new Definition(OAuthService::class);
        $definition->addArgument(new Reference('dv.oauth.service_locator'));
        $container->setDefinition(OAuthService::class, $definition);
        $container->setAlias('dv.oauth', OAuthService::class)->setPublic(true);
    }

    private function enableServices($config, $globalConfig, ContainerBuilder $container): array
    {
        $serviceIds = [];
        foreach ($config as $id => $serviceConfig) {
            $className = 'Druidvav\\SimpleOauthBundle\\OAuth\\ResourceOwner\\' . ucfirst($serviceConfig['resource_owner']) . 'ResourceOwner';

            $definition = new Definition($className);
            $definition->addArgument(new Reference('dv.oauth.guzzle'));
            $definition->addArgument(new Reference('security.http_utils'));
            $definition->addArgument($serviceConfig['options']);
            $definition->addArgument($serviceConfig['resource_owner']);
            $definition->addArgument(new Reference('dv.oauth.storage.session'));
            $container->setDefinition('dv.oauth.service.' . $id . '.resource_owner', $definition);

            $definition = new Definition(Service::class);
            $definition->addArgument($id);
            $definition->addArgument($serviceConfig['title']);
            $definition->addArgument(new Reference('dv.oauth.service.' . $id . '.resource_owner'));
            $definition->addMethodCall('setUrlGenerator', [ new Reference('router') ]);
            $definition->addMethodCall('setRedirectUriRoute', [ $globalConfig['redirect_uri_route'] ]);
            $container->setDefinition('dv.oauth.service.' . $id, $definition);

            $serviceIds[] = $id;
        }
        return $serviceIds;
    }
}
