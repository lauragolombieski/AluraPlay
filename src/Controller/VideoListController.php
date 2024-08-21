<?php

declare(strict_types= 1);

namespace Dbseller\Aluraplay\Controller;

use Dbseller\Aluraplay\Repository\VideoRepository;
use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoListController extends ControllerWithHtml implements RequestHandlerInterface {

    private VideoRepository $videoRepository;
    private Engine $templates;

    public function __construct(VideoRepository $videoRepository,
    Engine $templates){
        $this->videoRepository = $videoRepository;
        $this->templates = $templates;
    }

    public function handle(ServerRequestInterface $request):ResponseInterface {

        
        $videoList = $this->videoRepository->all();
        return new Response (200, [], $this->templates->render('video-list', ['videoList' => $videoList]));
    }
}