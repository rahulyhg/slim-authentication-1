<?php

namespace App\Controllers\Auth;

use App\Models\User;
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
     * @return Response
     */
    public function signup(Request $request, Response $response)
    {
        User::create([
            'email'    => $request->getParam('email'),
            'name'     => $request->getParam('name'),
            'password' => password_hash($request->getParam('password'), PASSWORD_BCRYPT, [
                'cost' => 12,
            ])
        ]);

        return $response->withRedirect(
            $this->router->pathFor('home')
        );
    }
}
