<?php
declare(strict_types=1);


namespace Hotel\Application\Test\Listener;


use Hotel\Application\Listener\CorsListener;
use Hotel\Application\Test\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Zend\Http\Headers;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;

class CorsListenerTest extends TestCase
{
    public function testItAddsCorsHeaders(): void
    {
        $headers = $this->createMock(Headers::class);
        $headers
            ->method('addHeaderLine')
            ->withConsecutive(
                ['Access-Control-Allow-Origin: *'],
                ['Access-Control-Allow-Methods: PUT, GET, POST, PATCH, DELETE, OPTIONS'],
                ['Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept'
            ]);

        $request = $this->createMock(Request::class);

        $response = $this->createMock(Response::class);
        $response
            ->expects($this->once())
            ->method('getHeaders')
            ->willReturn($headers);

        /** @var MvcEvent|MockObject $mvcEvent */
        $mvcEvent = $this->createMock(MvcEvent::class);
        $mvcEvent
            ->expects($this->once())
            ->method('getRequest')
            ->willReturn($request);
        $mvcEvent->expects($this->once())
            ->method('getResponse')
            ->willReturn($response);


        $listener = new CorsListener();
        $listener->when($mvcEvent);
    }
}