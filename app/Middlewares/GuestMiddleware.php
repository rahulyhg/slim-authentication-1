<?php

namespace App\Middlewares;

class GuestMiddleware extends Middleware
{
    /**
     * @param $request
     * @param $response
     * @param $next
     * @return mixed
     */
    public function __invoke($request, $response, $next)
    {
        if ($this->container->auth->check()) {
            return $response->withRedirect(
                $this->container->router->pathFor('home')
            );
        }

        return $next($request, $response);
    }
}