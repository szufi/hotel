<?php
declare(strict_types=1);


namespace Hotel\Application\Listener;


use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;

class CorsListener extends AbstractListenerAggregate
{
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_FINISH, [$this, 'when'], 1);
    }

    public function when(MvcEvent $event)
    {
        /** @var Response $response */
        $response = $event->getResponse();
        $response->getHeaders()->addHeaderLine('Access-Control-Allow-Origin: *');
    }
}