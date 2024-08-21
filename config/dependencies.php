<?php

use Dbseller\Aluraplay\ConexaoBd;
use DI\ContainerBuilder;
use League\Plates\Engine;

$builder = new ContainerBuilder();
$builder->addDefinitions([
    PDO::class => function (): PDO {
        return ConexaoBd::createConnexion();
    },
    Engine::class => function () {
        $templatePath = __DIR__ ."/../Views";
        return new Engine($templatePath);
    }
]);

/** @var \Psr\Container\ContainerInterface $container */
$container = $builder->build();

return $container;