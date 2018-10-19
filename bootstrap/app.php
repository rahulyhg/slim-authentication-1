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

$container['PagesController'] = function (\Slim\Container $container) {
    return new \App\Controllers\PagesController($container);
};

require __DIR__ . '/../app/routes.php';