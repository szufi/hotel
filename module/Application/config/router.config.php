<?php
declare(strict_types=1);

namespace Hotel\Application;

use Hotel\Application\Controller\ApartmentsController;
use Hotel\Application\Controller\ReservationsController;
use Zend\Router\Http\Segment;

return [
    'routes' => [
        'apartments'   => [
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
];