<?php

/**
 * Web Routes
 */

$app->get('/', 'PagesController:index')->setName('home');

// Auth routes
$app->get('/auth/signup', 'AuthController:showSignUpForm')->setName('auth.signup');
$app->post('/auth/signup', 'AuthController:signup');