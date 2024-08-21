<?php

declare(strict_types= 1);

namespace Dbseller\Aluraplay\Controller;

use Dbseller\Aluraplay\Helper\FlashMassageTrait;
use Dbseller\Aluraplay\Repository\VideoRepository;
use Dbseller\Aluraplay\Entity\Video;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EditVideoController implements RequestHandlerInterface {
    
    use FlashMassageTrait;

    private VideoRepository $videoRepository;

    public function __construct(VideoRepository $videoRepository){
        $this->videoRepository = $videoRepository;
    }

    public function handle(ServerRequestInterface $request):ResponseInterface {

        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        if ($id===false||$id===null) {
            $this->addErrorMessage('ID inválido');
            return new Response(302, [
                'Location' => '/editar-video'
            ]);
        }

        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if ($url==false) {
            $this->addErrorMessage('Url inválida, tente novamente.');
            return new Response(302, [
                'Location' => '/'
            ]);
        }
        $titulo = filter_input(INPUT_POST, 'titulo');
        if ($titulo==false) {
            $this->addErrorMessage('Titulo inválido');
            return new Response(302, [
                'Location' => '/editar-video'
            ]);
        }

        $video = new Video($url, $titulo);
        $video->setId($id);

        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../../public/img/uploads/' . $_FILES['image']['name']);
            $video->setFilePah($_FILES['image']['name']);
        }

        if ($this->videoRepository->update($video)==false) {
            $this->addErrorMessage('Erro ao atualizar.');
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