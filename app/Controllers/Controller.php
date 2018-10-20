<?php

namespace App\Controllers;

use Slim\Container;

class Controller
{
    /**
     * @var Container $container
     */
    protected $container;

    /**
     * Controller constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $property
     * @return mixed
     */
    public function __get(string $property)
    {
        return $this->container->{$property} ?? null;
    }
}