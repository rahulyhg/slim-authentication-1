<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

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
        $validation = $this->validator->validate([
            'name'      => v::notEmpty()->alnum()->length(5, 100),
            'email'     => v::notEmpty()->email()->unique('users.email'),
            'password'  => v::notEmpty()->noWhitespace()->length(6, 20),
        ]);

        if ($validation->fails()) {
            return $response->withRedirect($this->router->pathFor('auth.signup'));
        }

        User::create([
            'email'    => $request->getParam('email'),
            'name'     => $request->getParam('name'),
            'password' => password_hash($request->getParam('password'), PASSWORD_BCRYPT, [
                'cost' => 12,
            ])
        ]);

        return $response->withRedirect($this->router->pathFor('home'));
    }
}
