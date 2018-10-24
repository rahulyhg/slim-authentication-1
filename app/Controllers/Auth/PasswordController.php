<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

class PasswordController extends Controller
{
    /**
     * @param Request $request
     * @param Response $response
     * @return string
     */
    public function showChangePasswordForm(Request $request, Response $response)
    {
        return $this->view->render($response, 'auth/password/change.twig');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function changePassword(Request $request, Response $response)
    {
        $validation = $this->validator->validate([
            'password_old' => v::noWhitespace()->notEmpty()->matchesPassword(
                $this->auth->user()->password
            ),
            'password'     => v::noWhitespace()->notEmpty()->length(6, 20),
        ]);

        if ($validation->failed()) {
            return $this->redirect('auth.changePwd');
        }

        $this->auth->user()->setPassword(
            $request->getParam('password')
        );

        $this->flash->addMessage('success', 'Your password has been changed successfully !');

        return $this->redirect('home');
    }
}