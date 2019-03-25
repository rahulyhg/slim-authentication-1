<?php

session_start();

use Psr\Container\ContainerInterface as Container;

require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
    ],
]);

$container = $app->getContainer();

// Loading .env file for configuration
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

// Loading database handler (Eloquent ORM)
$capsule = new Illuminate\Database\Capsule\Manager();
$dbConfig = require __DIR__ . '/../config/database.php'; // TODO: Make a config class for handling these kind of crap.
$capsule->addConnection($dbConfig['mysql']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function () use ($capsule) {
    return $capsule;
};

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views/', [
        'cache' => false
    ]);

    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    $view->getEnvironment()->addGlobal('auth', [
        'check' => $container->auth->check(),
        'user'  => $container->auth->user(),
    ]);

    $view->getEnvironment()->addGlobal('flash', $container->flash);

    return $view;
};

$container['flash'] = function () {
    return new \Slim\Flash\Messages;
};

$container['csrf'] = function (Container $container) {
  return new \Slim\Csrf\Guard;
};

$container['validator'] = function (Container $container) {
  return new \App\Validation\Validator($container->request);
};

// Registering custom rules
\Respect\Validation\Validator::with('App\\Validation\\Rules\\');

$container['auth'] = function (Container $container) {
    return new \App\Auth\Auth($container);
};

$container['PagesController'] = function (Container $container) {
    return new \App\Controllers\PagesController($container);
};

$container['AuthController'] = function (Container $container) {
    return new \App\Controllers\Auth\AuthController($container);
};

$container['PasswordController'] = function (Container $container) {
    return new \App\Controllers\Auth\PasswordController($container);
};

// Adding middlewares to application layer
$app->add(new \App\Middlewares\ValidationErrorsMiddleware($container));
$app->add(new \App\Middlewares\OldInputMiddleware($container));
$app->add(new \App\Middlewares\CsrfViewMiddleware($container));
$app->add(new \App\Middlewares\CheckUserSessionTimeoutMiddleware($container));
$app->add($container->csrf);

require __DIR__ . '/../app/routes.php';