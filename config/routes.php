<?php

declare(strict_types= 1);
use Dbseller\Aluraplay\Controller\DeleteImageController;
use Dbseller\Aluraplay\Controller\JsonVideoListController;
use Dbseller\Aluraplay\Controller\LoginController;
use Dbseller\Aluraplay\Controller\LoginFormController;
use Dbseller\Aluraplay\Controller\DeleteVideoController;
use Dbseller\Aluraplay\Controller\EditVideoController;
use Dbseller\Aluraplay\Controller\NewJsonVideoController;
use Dbseller\Aluraplay\Controller\NewVideoController;
use Dbseller\Aluraplay\Controller\VideoFormController;
use Dbseller\Aluraplay\Controller\VideoListController;
use Dbseller\Aluraplay\Controller\LogoutController;

return [
    'GET|/' => VideoListController::class,
    'GET|/novo-video' => VideoFormController::class,
    'POST|/novo-video' => NewVideoController::class,
    'GET|/editar-video' => VideoFormController::class,
    'POST|/editar-video' => EditVideoController::class,
    'GET|/remover-video' => DeleteVideoController::class,
    'GET|/login' => LoginFormController::class,
    'POST|/login' => LoginController::class,
    'GET|/logout' => LogoutController::class,
    'GET|/deletar-capa' => DeleteImageController::class,
    'GET|/videos-json' => JsonVideoListController::class,
    'POST|/videos' => NewJsonVideoController::class,
];