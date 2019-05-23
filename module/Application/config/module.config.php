<?php
declare(strict_types=1);

namespace Hotel\Application;


use Hotel\Application\Controller\ApartmentsController;
use Hotel\Application\Controller\ReservationsController;
use Hotel\Application\InputFilter\Apartment\CreateApartmentInputFilter;
use Hotel\Application\InputFilter\Apartment\GetApartmentInputFilter;
use Hotel\Application\InputFilter\Reservation\CreateReservationInputFilter;
use Hotel\Application\InputFilter\Reservation\UpdateReservationInputFilter;
use Hotel\Application\Listener\ApiProblemListener;
use Hotel\Application\Listener\ConnectionListener;
use Hotel\Application\Listener\CorsListener;
use Hotel\Application\Listener\ExceptionListener;
use Hotel\Application\Listener\Factory\ConnectionListenerFactory;

return [
    'router'                => require_once __DIR__ . '\router.config.php',
    'controllers'           => [
        'invokables' => [
            ApartmentsController::class,
            ReservationsController::class,
        ],
    ],
    'service_manager'       => [
        'factories'  => [
            ConnectionListener::class => ConnectionListenerFactory::class,
        ],
        'invokables' => [
            CorsListener::class,
            ApiProblemListener::class,
            ExceptionListener::class,
        ]
    ],
    'zf-content-validation' => [
        ApartmentsController::class   => [
            'POST' => CreateApartmentInputFilter::class,
            'GET'  => GetApartmentInputFilter::class,
        ],
        ReservationsController::class => [
            'POST' => CreateReservationInputFilter::class,
            'PUT'  => UpdateReservationInputFilter::class
        ]
    ],
    'input_filters'         => [
        'invokables' => [
            GetApartmentInputFilter::class,
            CreateApartmentInputFilter::class,

            CreateReservationInputFilter::class,
            UpdateReservationInputFilter::class
        ]
    ],
    'listeners'             => [
        CorsListener::class,
        ApiProblemListener::class,
        ExceptionListener::class,
        ConnectionListener::class
    ],
    'view_manager'          => [
        'strategies'         => [
            'ViewJsonStrategy',
        ],
        'display_exceptions' => false,
    ],
];