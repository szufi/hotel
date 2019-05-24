<?php
declare(strict_types=1);

return [
    'database' => [
        'name'    => 'hotel',
        'host'    => 'localhost',
        'user'    => 'root',
        'pass'    => '',
        'dialect' => 'mysql'
    ],
    'jwt'      => [
        'algorithm' => 'HS256',
        'key'       => 'secret_key',
    ],
];