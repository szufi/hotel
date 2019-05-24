<?php
declare(strict_types=1);

namespace Hotel\Application\Listener;


use Psr\Log\LoggerInterface;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class ExceptionListener extends AbstractListenerAggregate
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

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

        $this->logger->error('Unexpected exception occurred', [
            'time'      => time(),
            'exception' => (string)$exception,
        ]);

        $event->setViewModel(
            new JsonModel([
                'message' => (string)$exception
            ])
        );
    }
}