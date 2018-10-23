<?php

namespace App\Middlewares;

class CsrfViewMiddleware extends Middleware
{
    /**
     * @param $request
     * @param $response
     * @param $next
     * @return mixed
     */
    public function __invoke($request, $response, $next)
    {
        $csrf = $this->container->csrf;

        $this->getView()->addGlobal('csrf', [
            'field' => '
                <input type="hidden" name="' . $csrf->getTokenNameKey() . '" value="' . $csrf->getTokenName() . '">
                <input type="hidden" name="' . $csrf->getTokenValueKey() . '" value="' . $csrf->getTokenValue() . '">
            ',
        ]);
        
        return $next($request, $response);
    }
}