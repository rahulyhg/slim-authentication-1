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
     * @return mixed
     */
    public function showSignInForm(Request $request, Response $response)
    {
        return $this->view->render($response, 'auth/signin.twig');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function signup(Request $request, Response $response): Response
    {
        $validation = $this->validator->validate([
            'name'      => v::notEmpty()->alnum()->length(5, 100),
            'email'     => v::notEmpty()->email()->unique('users.email'),
            'password'  => v::notEmpty()->noWhitespace()->length(6, 20),
        ]);

        if ($validation->fails()) {
            return $this->redirect('auth.signup');
        }

        $user = User::create([
            'email'    => $request->getParam('email'),
            'name'     => $request->getParam('name'),
            'password' => password_hash($request->getParam('password'), PASSWORD_BCRYPT, [
                'cost' => 12,
            ])
        ]);

        $this->auth->signin($user);

        return $this->redirect('home');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function signin(Request $request, Response $response): Response
    {
        $validation = $this->validator->validate([
            'email'     => v::notEmpty()->email(),
            'password'  => v::notEmpty()->noWhitespace()->length(6, 20),
        ]);

        if ($validation->fails()) {
            return $this->redirect('auth.signin');
        }

        $auth = $this->auth->attempt(
            $request->getParam('email'),
            $request->getParam('password')
        );

        if (! $auth) {
            return $this->redirect('auth.signin');
        }

        return $this->redirect('home');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function signout(Request $request, Response $response): Response
    {
        $this->auth->logout();

        return $this->redirect('home');
    }
}
