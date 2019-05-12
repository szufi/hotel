<?php
declare(strict_types=1);


namespace Hotel\Application\Listener;


use Illuminate\Database\Capsule\Manager as Capsule;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

class ConnectionListener extends AbstractListenerAggregate
{
    /** @var array */
    private $config;

    /**
     * ConnectionListener constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'when'], 1);
    }

    public function when(MvcEvent $event)
    {
        $capsule = new Capsule();

        $capsule->addConnection($this->config);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}