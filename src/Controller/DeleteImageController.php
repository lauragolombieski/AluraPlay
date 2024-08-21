<?php       

declare(strict_types= 1);

namespace Dbseller\Aluraplay\Controller;

use Dbseller\Aluraplay\ConexaoBd;
use Dbseller\Aluraplay\Helper\FlashMassageTrait;
use Dbseller\Aluraplay\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DeleteImageController implements RequestHandlerInterface {

    use FlashMassageTrait;

    private VideoRepository $videoRepository;

    public function __construct(VideoRepository $videoRepository){
        $this->videoRepository = $videoRepository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface {

        $pdo = ConexaoBd::createConnexion();

        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        if ($id === null || $id === false) {
            $this->addErrorMessage('Erro ao receber o ID.');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $videoRepository = new VideoRepository($pdo);
        
        $videoRepository->deleteData($id);

        $sucesso = $videoRepository->removeImage($id);
        if ($sucesso==false) {
            $this->addErrorMessage('Erro ao remover a capa.');
            return new Response(302, [
                'Location' => '/'
            ]);
        } else {
            return new Response(302, [
                'Location' => '/'
            ]);
        }
    }
}