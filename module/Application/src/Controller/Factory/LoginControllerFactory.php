<?php
declare(strict_types=1);

namespace Hotel\Application\Controller\Factory;


use Hotel\Application\Controller\LoginController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class LoginControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var array $config */
        $config    = $container->get('config');
        $secretKey = $config['jwt']['key'];

        return new LoginController($secretKey);
    }
}