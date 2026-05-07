<?php
namespace Druidvav\SimpleOauthBundle\Service;

use Druidvav\SimpleOauthBundle\Exception\ServiceNotFoundException;
use Druidvav\SimpleOauthBundle\Service;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class OAuthService
{
    private $serviceLocator;

    public function __construct(ContainerInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @param string $id
     * @return Service
     * @throws ServiceNotFoundException
     */
    public function getService(string $id): Service
    {
        if (!$this->serviceLocator->has($id)) {
            throw new ServiceNotFoundException();
        }
        $service = $this->serviceLocator->get($id);
        if (!$service instanceof Service) {
            throw new ServiceNotFoundException();
        }
        return $service;
    }

    /**
     * @param Request $request
     * @return Service
     * @throws ServiceNotFoundException
     */
    public function getServiceByRequest(Request $request): Service
    {
        $serviceId = $request->attributes->get('service');
        if (null === $serviceId) {
            $serviceId = $request->query->get('service');
        }
        if (null === $serviceId) {
            throw new ServiceNotFoundException();
        }

        $service = $this->getService($serviceId);
        if (!$service->getResourceOwner()->handles($request)) {
            throw new ServiceNotFoundException();
        }
        return $service;
    }
}
