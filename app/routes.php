<?php

/**
 * Web Routes
 */

$app->get('/', 'PagesController:index')->setName('home');

/** Auth routes **/

$app->group('', function ($app) {
    // Sign up
    $app->get('/auth/signup', 'AuthController:showSignUpForm')->setName('auth.signup');
    $app->post('/auth/signup', 'AuthController:signup');

    // Sign in
    $app->get('/auth/signin', 'AuthController:showSignInForm')->setName('auth.signin');
    $app->post('/auth/signin', 'AuthController:signin');
})->add(new \App\Middlewares\GuestMiddleware($container));

$app->group('', function ($app) {
    // Sign out
    $app->get('/auth/signout', 'AuthController:signout')->setName('auth.signout');

    // Change password
    $app->get('/auth/change-password', 'PasswordController:showChangePasswordForm')->setName('auth.changePwd');
    $app->post('/auth/change-password', 'PasswordController:changePassword');

})->add(new \App\Middlewares\AuthMiddleware($container));