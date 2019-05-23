<?php
declare(strict_types=1);


namespace Hotel\Application\Listener\Factory;


use Hotel\Application\Listener\ProtectedRouteListener;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ProtectedRouteListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var array $config */
        $config = $container->get('config');

        $secretKey = $config['jwt']['key'];
        $algorithm = $config['jwt']['algorithm'];

        return new ProtectedRouteListener($secretKey, $algorithm);
    }
}