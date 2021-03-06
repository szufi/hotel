<?php
declare(strict_types=1);

use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

return [
    'EnliteMonolog' => [
        'app_log'     => [
            'handlers' => [
                'default' => [
                    'name'      => StreamHandler::class,
                    'args'      => [
                        'stream' => 'data/log/application.log',
                        'level'  => Logger::WARNING,
                    ],
                    'formatter' => [
                        'name' => JsonFormatter::class
                    ],
                ],
            ],
        ],
        'console_log' => [
            'handlers' => [
                'default' => [
                    'name'      => StreamHandler::class,
                    'args'      => [
                        'stream' => 'data/log/console.log',
                        'level'  => Logger::INFO,
                    ],
                    'formatter' => [
                        'name' => JsonFormatter::class
                    ],
                ],
                'console' => [
                    'name' => StreamHandler::class,
                    'args' => [
                        'stream' => 'php://stdout',
                        'level'  => Logger::INFO,
                    ],
                ],
            ],
        ],
    ],
];