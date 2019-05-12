<?php
declare(strict_types=1);


namespace Hotel\Application\Listener;


use Hotel\Application\Exception\ApiProblemException;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class ApiProblemListener extends AbstractListenerAggregate
{
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER, [$this, 'when'], 1001);
    }

    public function when(MvcEvent $event)
    {
        $result = $event->getResult();
        if (!$result instanceof ViewModel) {
            return;
        }

        $exception = $result->getVariable('exception', null);
        if (!$exception) {
            return;
        }

        if (!$exception instanceof ApiProblemException) {
            return;
        }

        $event->setViewModel(
            new JsonModel([
                'code'    => $exception->getCode(),
                'message' => $exception->getMessage()
            ])
        );

        /** @var Response $response */
        $response = $event->getResponse();
        $response->setStatusCode($exception->getCode());

        $result->setVariable('exception', null);
    }
}