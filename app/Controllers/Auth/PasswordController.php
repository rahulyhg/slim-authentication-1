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
     *
     */
    public function changePassword()
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

        dd('Passed.');
    }
}