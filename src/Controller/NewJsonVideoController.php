<?php

declare(strict_types= 1);

namespace Dbseller\Aluraplay\Controller;
use Dbseller\Aluraplay\Entity\Video;
use Dbseller\Aluraplay\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NewJsonVideoController implements RequestHandlerInterface {

    private VideoRepository $videoRepository;

    public function __construct(VideoRepository $videoRepository){
        $this->videoRepository = $videoRepository;
    }

    public function handle(ServerRequestInterface $request):ResponseInterface {
        $request = $request->getBody()->getContents();
        $videoData = json_decode($request, true);
        $video = new Video($videoData['url'], $videoData['title']);
        $this->videoRepository->add($video);
        
        return new Response(201);
    }
}                                                