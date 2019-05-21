<?php
declare(strict_types=1);

namespace Hotel\Application;


use Hotel\Application\Controller\ApartmentsController;
use Hotel\Application\Controller\ReservationsController;
use Hotel\Application\Listener\ApiProblemListener;
use Hotel\Application\Listener\ConnectionListener;
use Hotel\Application\Listener\ExceptionListener;
use Hotel\Application\Listener\Factory\ConnectionListenerFactory;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router'          => [
        'routes' => [
            'apartments' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/apartments',
                    'defaults' => [
                        'controller' => ApartmentsController::class,
                    ],
                ],
            ],
            'reservations' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/reservations[/:id]',
                    'defaults' => [
                        'controller' => ReservationsController::class,
                    ],
                ],
            ],
        ],
    ],
    'controllers'     => [
        'factories' => [
            ApartmentsController::class => InvokableFactory::class,
            ReservationsController::class => InvokableFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            ApiProblemListener::class => InvokableFactory::class,
            ExceptionListener::class  => InvokableFactory::class,
            ConnectionListener::class => ConnectionListenerFactory::class
        ]
    ],
    'listeners'       => [
        ApiProblemListener::class,
        ExceptionListener::class,
        ConnectionListener::class
    ],
    'view_manager'    => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
        'display_exceptions' => false,
    ],
];