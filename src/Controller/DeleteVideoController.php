<?php

namespace Dbseller\Aluraplay\Controller;

use Dbseller\Aluraplay\ConexaoBd;
use Dbseller\Aluraplay\Helper\FlashMassageTrait;
use Dbseller\Aluraplay\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DeleteVideoController implements RequestHandlerInterface {
    
    use FlashMassageTrait;

    private VideoRepository $videoRepository;

    public function __construct(VideoRepository $videoRepository){
        $this->videoRepository = $videoRepository;
    }

    public function handle(ServerRequestInterface $request):ResponseInterface {

        $pdo = ConexaoBd::createConnexion();

        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        if ($id === null || $id === false) {
            $this->addErrorMessage('ID inválido');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $videoRepository = new VideoRepository($pdo);
        
        $videoRepository->deleteData($id);

        $sucesso = $videoRepository->remove($id);
        if ($sucesso==false) {
            $this->addErrorMessage('Erro ao remover vídeo.');
            return new Response(302, [
                'Location' => '/'
            ]);
        } else {
            $this->addErrorMessage('');
            return new Response(302, [
                'Location' => '/'
            ]);
        }
    }
}