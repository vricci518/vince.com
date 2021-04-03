<?php
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
// use Slim\App;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
// var_dump($_SERVER);

/**
 * Instantiate App
 *
 * In order for the factory to work you need to ensure you have installed
 * a supported PSR-7 implementation of your choice e.g.: Slim PSR-7 and a supported
 * ServerRequest creator (included with Slim PSR-7)
 */
$app = AppFactory::create();

/**
 * Add Error Handling Middleware
 *
 * @param bool $displayErrorDetails -> Should be set to false in production
 * @param bool $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool $logErrorDetails -> Display error details in error log
 * which can be replaced by a callable of your choice.
 
 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->setBasePath('/vince.com');

// Define app routes
$app->get('/hello/{name}', function (Request $request, Response $response, $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});

$app->get('/comic/{name}', function (Request $request, Response $response, $args) {
    $name = $args['name'];
    $response->getBody()->write("It was $name all along!");
    return $response;
});

$app->get('/color/{color}', function (Request $request, Response $response, $args) {
    $color = $args['color'];
    $response->getBody()->write('https://www.google.com/search?q=' . $color);
    return $response
        ->withHeader('Location', 'https://www.google.com/search?q=' . $color)
        ->withStatus(302);
});

// Run app
$app->run();
