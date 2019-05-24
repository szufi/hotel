<?php
declare(strict_types=1);


namespace Hotel\Application\Listener;


use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\RequestInterface;
use Zend\Http\Request as HttpRequest;

class CorsListener extends AbstractListenerAggregate
{
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_FINISH, [$this, 'when'], 1);
    }

    public function when(MvcEvent $event)
    {
        /** @var RequestInterface $request */
        $request = $event->getRequest();
        if (!$request instanceof HttpRequest) {
            return null;
        }

        /** @var Response $response */
        $response = $event->getResponse();
        $headers  = $response->getHeaders();

        $headers->addHeaderLine('Access-Control-Allow-Origin: *');
        $headers->addHeaderLine('Access-Control-Allow-Methods: PUT, GET, POST, PATCH, DELETE, OPTIONS');
        $headers->addHeaderLine('Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept');

        /** @var Request $request */
        $request = $event->getRequest();
        if ($request->getMethod() === 'OPTIONS') {
            $response->setStatusCode(200);
        }
    }
}