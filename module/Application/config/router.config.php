<?php
declare(strict_types=1);

namespace Hotel\Application;

use Hotel\Application\Controller\ApartmentsController;
use Hotel\Application\Controller\LoginController;
use Hotel\Application\Controller\ReservationsController;
use Zend\Router\Http\Segment;

return [
    'routes' => [
        'login' => [
            'type'    => Segment::class,
            'options' => [
                'route'    => '/login[/:id]',
                'defaults' => [
                    'controller' => LoginController::class,
                ],
            ],
        ],
        'apartments'   => [
            'type'    => Segment::class,
            'options' => [
                'route'    => '/apartments',
                'defaults' => [
                    'controller' => ApartmentsController::class,
                    'protected' => [
                        'POST'
                    ]
                ],
            ],
        ],
        'reservations' => [
            'type'    => Segment::class,
            'options' => [
                'route'    => '/reservations[/:id]',
                'defaults' => [
                    'controller' => ReservationsController::class,
                    'protected' => [
                        'GET_LIST', 'PUT'
                    ]
                ],
            ],
        ],
    ],
];