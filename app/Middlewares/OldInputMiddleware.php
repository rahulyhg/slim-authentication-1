<?php

namespace App\Middlewares;

class OldInputMiddleware extends Middleware
{
    /**
     * @param $request
     * @param $response
     * @param $next
     * @return mixed
     */
    public function __invoke($request, $response, $next)
    {
        $this->getView()->addGlobal('old', $_SESSION['old'] ?? []);

        $_SESSION['old'] = $request->getParams();

        return $next($request, $response);
    }
}