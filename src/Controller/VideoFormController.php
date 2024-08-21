<?php 

namespace Dbseller\Aluraplay\Controller;

use Dbseller\Aluraplay\Repository\VideoRepository;
use League\Plates\Engine;
use Nyholm\Psr7\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoFormController extends ControllerWithHtml implements RequestHandlerInterface {

    private VideoRepository $videoRepository;
    private Engine $templates;

    public function __construct(VideoRepository $videoRepository,
    Engine $templates){
        $this->videoRepository = $videoRepository;
        $this->templates = $templates;
    }

    public function handle(ServerRequestInterface $request):ResponseInterface {

            $id = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT);
            $video = null;
            if ($id !== false && $id !== null) {
                $video = $this->videoRepository->find($id);

            }
            
            return new Response(200, [], $this->templates->render('video-form', ['video' => $video]));
    }
}