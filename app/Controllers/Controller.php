<?php

namespace App\Controllers;

use Slim\Container;
use Psr\Http\Message\ResponseInterface as Response;

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

    /**
     * @param string $route
     * @return Response
     */
    protected function redirect(string $route): Response
    {
        return $this->response->withRedirect(
            $this->router->pathFor($route)
        );
    }
}