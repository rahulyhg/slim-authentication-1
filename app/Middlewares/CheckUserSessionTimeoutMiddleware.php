<?php

namespace App\Middlewares;

/**
 * Class CheckUserSessionTimeoutMiddleware
 * @package App\Middlewares
 */
class CheckUserSessionTimeoutMiddleware extends Middleware
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
            $timeout = $_SESSION['user']['timeout'];

            if ((time() - $timeout) >= 10) {
                $this->container->auth->logout();
                return $response->withRedirect(
                    $this->container->router->pathFor('home')
                );
            }

            $_SESSION['user']['timeout'] = time();
        }


        return $next($request, $response);
    }
}