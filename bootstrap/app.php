<?php

session_start();

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

    return $view;
};

// Registering custom rules
\Respect\Validation\Validator::with('App\\Validation\\Rules\\');

$container['validator'] = function (\Slim\Container $container) {
  return new \App\Validation\Validator($container->request);
};

$container['PagesController'] = function (\Slim\Container $container) {
    return new \App\Controllers\PagesController($container);
};

$container['AuthController'] = function (\Slim\Container $container) {
    return new \App\Controllers\Auth\AuthController($container);
};

// Adding middlewares to application layer
$app->add(new \App\Middlewares\ValidationErrorsMiddleware($container));
$app->add(new \App\Middlewares\OldInputMiddleware($container));

require __DIR__ . '/../app/routes.php';