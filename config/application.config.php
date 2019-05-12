<?php
declare(strict_types=1);

return [
    'modules'                 => require __DIR__ . '/modules.config.php',
    'module_listener_options' => [
        'module_paths'             => [
            './module',
            './vendor',
        ],
        'config_cache_enabled'     => false,
        'module_map_cache_enabled' => false,
        'config_glob_paths'        => [
            realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local}.php',
        ],
    ],
];