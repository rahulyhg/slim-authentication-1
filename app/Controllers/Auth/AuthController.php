<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function showSignUpForm(Request $request, Response $response)
    {
        return $this->view->render($response, 'auth/signup.twig');
    }

    /**
     * @param Request $request
     * @param Response $response
     */
    public function signup(Request $request, Response $response)
    {

    }
}