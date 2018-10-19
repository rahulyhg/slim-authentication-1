<?php

/**
 * Database configuration file
 */

return [

    'mysql' => [
        'host'      => '127.0.0.1',
        'dbname'    => getenv('DATABASE_NAME'),
        'username'  => getenv('DATABASE_USER'),
        'password'  => getenv('DATABASE_PASSWORD'),
    ],

];
