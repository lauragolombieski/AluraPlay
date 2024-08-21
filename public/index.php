<?php

declare (strict_types= 1);

require_once '../vendor/autoload.php';

$routes = require_once __DIR__ . '/../config/routes.php';
/**
 * @var \Psr\Container\ContainerInterface $diContainer
 */
$diContainer = require_once __DIR__ . '/../config/dependencies.php';

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

session_start();
$isLoginRoute = $pathInfo === '/login';
if (!array_key_exists('logado', $_SESSION) && !$isLoginRoute) {
    header('Location: /login');
    return;
}

if (isset($_SESSION['logado'])) {
    $originalInfo = $_SESSION['logado'];
    unset($_SESSION['logado']);
    session_regenerate_id();
    $_SESSION['logado'] = $originalInfo;
}

$key = "$httpMethod|$pathInfo";
if (array_key_exists($key, $routes)) {
$controllerClass = $routes["$httpMethod|$pathInfo"];

$controller = $diContainer->get($controllerClass);
} else {
    echo "TESTE ERRO";
}

$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $psr17Factory,
    $psr17Factory,
    $psr17Factory,
    $psr17Factory
);

$request = $creator->fromGlobals();

/**
 * @var \Psr\Http\Server\RequestHandlerInterface $controller
 */
$response = $controller->handle($request);

http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s:%s', $name, $value), false);
    }
}

echo $response->getBody();
