<?php
declare(strict_types=1);

namespace Hotel\Application\Console\Factory;


use Hotel\Application\Console\StatusController;
use Interop\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class StatusControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var LoggerInterface $logger */
        $logger = $container->get('console_log');

        return new StatusController($logger);
    }
}