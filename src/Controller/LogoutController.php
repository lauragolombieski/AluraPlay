<?php

declare(strict_types= 1);  

namespace Dbseller\Aluraplay\Controller;
use Dbseller\Aluraplay\Helper\FlashMassageTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LogoutController implements RequestHandlerInterface {

    use FlashMassageTrait;

    public function handle(ServerRequestInterface $request):ResponseInterface {
        $_SESSION['logado'] = false;
        unset($_SESSION['logado']);
            $this->addErrorMessage('Você está deslogado!');
            return new Response(302, [
                'Location' => '/'
            ]);
    }
}