<?php
declare(strict_types=1);

namespace Hotel\Application\Listener\Factory;


use Hotel\Application\Listener\ConnectionListener;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ConnectionListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var array $config */
        $config = $container->get('config');

        $name    = $config['database']['name'];
        $host    = $config['database']['host'];
        $dialect = $config['database']['dialect'];

        $user = $config['database']['user'];
        $pass = $config['database']['pass'];

        return new ConnectionListener([
            'driver'    => $dialect,

            'host'      => $host,
            'database'  => $name,

            'username'  => $user,
            'password'  => $pass,

            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',

            'prefix'    => '',
        ]);
    }
}