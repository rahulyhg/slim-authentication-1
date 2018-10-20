<?php

/**
 * Database configuration file
 */

return [

    'mysql' => [
        'driver'    => 'mysql',
        'host'      => '127.0.0.1',
        'database'  => getenv('DATABASE_NAME'),
        'username'  => getenv('DATABASE_USER'),
        'password'  => getenv('DATABASE_PASSWORD'),
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ],

];
