<?php

declare(strict_types=1);

namespace Dbseller\Aluraplay\Controller\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface Controller
{
    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface;
}