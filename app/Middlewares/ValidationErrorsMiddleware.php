<?php

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface as Response;

class ValidationErrorsMiddleware extends Middleware
{
    /**
     * @param $request
     * @param $response
     * @param $next
     * @return Response
     */
    public function __invoke($request, $response, $next): Response
    {
        $this->container->view
            ->getEnvironment()
            ->addGlobal('errors', $_SESSION['errors'] ?? []);

        unset($_SESSION['errors']);

        return $next($request, $response);
    }
}