<?php

declare(strict_types= 1);

namespace Dbseller\Aluraplay\Controller;
use Dbseller\Aluraplay\Entity\Video;
use Dbseller\Aluraplay\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JsonVideoListController implements RequestHandlerInterface {
    private VideoRepository $videoRepository;

    public function __construct(VideoRepository $videoRepository){
        $this->videoRepository = $videoRepository;
    }
    
    public function handle(ServerRequestInterface $request):ResponseInterface{
        $videoList = array_map(function(Video $video): array {
            return [
                'url' => $video->url,
                'title' => $video->titulo,
                'file_path' => $video->getFilePath() === null ? null : '/img/uploads/' . $video->getFilePath(),
            ];
        }, $this->videoRepository->all());

        return new Response (200, [ 'Content-Type' => 'application/json'], json_encode($videoList));
    }
}