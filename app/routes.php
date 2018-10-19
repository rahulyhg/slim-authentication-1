<?php

/**
 * Web Routes
 */

$app->get('/', 'PagesController:index');

// Auth routes
$app->get('/auth/signup', 'AuthController:showSignUpForm')->setName('auth.signup');
$app->post('/auth/signup', 'AuthController:signup');