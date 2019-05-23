<?php
declare(strict_types=1);

namespace Hotel\Application;


use Hotel\Application\Controller\ApartmentsController;
use Hotel\Application\Controller\Factory\LoginControllerFactory;
use Hotel\Application\Controller\LoginController;
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
use Hotel\Application\Listener\Factory\ProtectedRouteListenerFactory;
use Hotel\Application\Listener\ProtectedRouteListener;

return [
    'router'                => require_once __DIR__ . '\router.config.php',
    'controllers'           => [
        'factories'  => [
            LoginController::class => LoginControllerFactory::class,
        ],
        'invokables' => [
            ApartmentsController::class,
            ReservationsController::class,
        ],
    ],
    'service_manager'       => [
        'factories'  => [
            ConnectionListener::class     => ConnectionListenerFactory::class,
            ProtectedRouteListener::class => ProtectedRouteListenerFactory::class,
        ],
        'invokables' => [
            CorsListener::class,
            ExceptionListener::class,
            ApiProblemListener::class,
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
        ExceptionListener::class,
        ApiProblemListener::class,
        ConnectionListener::class,
        ProtectedRouteListener::class
    ],
    'view_manager'          => [
        'strategies'         => [
            'ViewJsonStrategy',
        ],
        'display_exceptions' => false,
    ],
];