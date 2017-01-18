<?php
return [
    'application' => [
        'directory' => APP_PATH . '/app',
        'dispatcher' => ['catchException' => true],
        'view' => APP_PATH . '/resource/views',
        'compile' => APP_PATH . '/storage/frame/views',
    ],
    'database' => [
        'driver'    => 'mysql',
        'host'      => '127.0.0.1',
        'database'  => 'test',
        'username'  => 'root',
        'password'  => '123456',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => ''
    ]
];
