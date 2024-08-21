<?php

declare(strict_types= 1);

namespace Dbseller\Aluraplay\Controller;

use Dbseller\Aluraplay\ConexaoBd;
use Dbseller\Aluraplay\Helper\FlashMassageTrait;
use Dbseller\Aluraplay\Repository\VideoRepository;
use Dbseller\Aluraplay\Entity\Video;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NewVideoController implements RequestHandlerInterface{
    
        use FlashMassageTrait;

        private VideoRepository $videoRepository;

        public function __construct(VideoRepository $videoRepository){
            $this->videoRepository = $videoRepository;
        }

        public function handle(ServerRequestInterface $request):ResponseInterface {
            
        $url = $_POST['url'];
        if ($url==false) {
            $this->addErrorMessage('URL não informada!');
            return new Response(302, [
                'Location' => '/novo-video'
            ]);
        }
        $titulo = $_POST['titulo'];
        if ($titulo==false) {
            $this->addErrorMessage('Titulo não informado!');
            return new Response(302, [
                'Location' => '/novo-video'
            ]);
        }

        $video = new Video($url, $titulo);
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $safeFileName = uniqid('upload') . '_' . pathinfo($_FILES['image']['name'], PATHINFO_BASENAME);

            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../../public/img/uploads/' . $safeFileName);
            $video->setFilePah($safeFileName);
        }

        if ($this->videoRepository-> add ($video) == false) {
            $this->addErrorMessage('Erro ao adicionar video!');
            return new Response(302, [
                'Location' => '/novo-video'
            ]);
        } else {
            return new Response(302, [
                'Location' => '/'
            ]);
        }
    }
}