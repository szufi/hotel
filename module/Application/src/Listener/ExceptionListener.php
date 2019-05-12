<?php
declare(strict_types=1);

namespace Hotel\Application\Listener;


use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class ExceptionListener extends AbstractListenerAggregate
{
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'when'], -1);
        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER_ERROR, [$this, 'when'], -1);
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

        $event->setViewModel(
            new JsonModel([
                'exception' => (string)$exception
            ])
        );
    }
}