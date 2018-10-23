<?php

/**
 * Web Routes
 */

$app->get('/', 'PagesController:index')->setName('home');

/** Auth routes **/

// Sign up
$app->get('/auth/signup', 'AuthController:showSignUpForm')->setName('auth.signup');
$app->post('/auth/signup', 'AuthController:signup');

// Sign in
$app->get('/auth/signin', 'AuthController:showSignInForm')->setName('auth.signin');
$app->post('/auth/signin', 'AuthController:signin');

// Sign out
$app->get('/auth/signout', 'AuthController:signout')->setName('auth.signout');