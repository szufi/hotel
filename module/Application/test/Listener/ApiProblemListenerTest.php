<?php
declare(strict_types=1);

namespace Hotel\Application\Test\Listener;


use Hotel\Application\Exception\ApiProblemException;
use Hotel\Application\Listener\ApiProblemListener;
use Hotel\Application\Test\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class ApiProblemListenerTest extends TestCase
{
    public function testItTransformExceptionToApiResponse(): void
    {
        $exception = new ApiProblemException('Test API response', 409);

        $result = $this->createMock(ViewModel::class);
        $result
            ->expects($this->once())
            ->method('getVariable')
            ->with('exception')
            ->willReturn($exception);

        $response = $this->createMock(Response::class);
        $response
            ->expects($this->once())
            ->method('setStatusCode')
            ->with(409);

        /** @var MvcEvent|MockObject $mvcEvent */
        $mvcEvent = $this->createMock(MvcEvent::class);
        $mvcEvent
            ->expects($this->once())
            ->method('getResult')
            ->willReturn($result);
        $mvcEvent
            ->expects($this->once())
            ->method('setViewModel')
            ->with(new JsonModel([
                'code'    => $exception->getCode(),
                'message' => $exception->getMessage()
            ]));
        $mvcEvent->expects($this->once())
            ->method('getResponse')
            ->willReturn($response);


        $listener = new ApiProblemListener();
        $listener->when($mvcEvent);
    }
}