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
     * @param $id
     * @return Service|object
     * @throws ServiceNotFoundException
     */
    public function getService($id)
    {
        if (!$this->serviceLocator->has($id)) {
            throw new ServiceNotFoundException();
        }
        return $this->serviceLocator->get($id);
    }

    /**
     * @param Request $request
     * @return Service|object
     * @throws ServiceNotFoundException
     */
    public function getServiceByRequest(Request $request)
    {
        $service = $this->getService($request->query->get('service'));
        if (!$service->getResourceOwner()->handles($request)) {
            throw new ServiceNotFoundException();
        }
        return $service;
    }
}
