<?php

namespace App\Middlewares;

use Slim\Container;

class Middleware
{
    /**
     * @var Container $container
     */
    protected $container;

    /**
     * Middleware constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}