<?php
declare(strict_types=1);


namespace Hotel\Application\Listener\Factory;


use Hotel\Application\Listener\ExceptionListener;
use Interop\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ExceptionListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var LoggerInterface $logger */
        $logger = $container->get('app_log');

        return new ExceptionListener($logger);
    }
}