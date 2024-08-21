<?php

declare(strict_types= 1);

namespace Dbseller\Aluraplay\Repository;
use PDO;
use Dbseller\Aluraplay\Entity\Video;

class VideoRepository {

    private $pdo;
    
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }


    public function add (Video $video): bool {
        $sql = 'INSERT INTO videos (url, title, image) VALUES (?,?,?)';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1,$video->url, PDO::PARAM_STR);
        $statement->bindValue(2,$video->titulo, PDO::PARAM_STR);
        $statement->bindValue(3,$video->getFilePath());

        $result = $statement->execute();

        $id = $this->pdo->LastInsertId();
        $video->setId(intval($id));
        
        return $result;
    }
    
    public function remove (int $id): bool {
        $sql = 'DELETE FROM videos WHERE id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        
        return $stmt->execute();
    }
    public function update (Video $video): bool {
        
        $updateImageSql = '';
        
        if ($video->getFilePath() !== null ) {
            $updateImageSql = ', image = :image';
        }

        $sql = "UPDATE videos SET url = :url, 
                        title = :title 
                        $updateImageSql
                        WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':url', $video->url);
        $stmt->bindValue(':title', $video->titulo);
        $stmt->bindValue(':id', $video->id, PDO::PARAM_INT);

        if($video->getFilePath() !== null){
            $stmt->bindValue(':image', $video->getFilePath());
        }

        return $stmt->execute();
    
    }

    /**
     * Summary of all
     * @return Video[]
     */
    public function all(): array {
    $videoData = $this->pdo->query('SELECT * FROM videos');
    $videos = $videoData->fetchAll(PDO::FETCH_ASSOC);

    $hydrate = function($video) {
        return $this->hydrateVideo($video);
    };

    return array_map($hydrate, $videos);
}

    public function find(int $id) {
        $stmt = $this->pdo->prepare('SELECT * FROM videos WHERE id =?;');
        $stmt->bindValue(1, $id);
        $stmt->execute();

        return $this->hydrateVideo($stmt->fetch(PDO::FETCH_ASSOC));
    }

    private function hydrateVideo(array $videoData): Video {
        $video = new Video($videoData['url'], $videoData['title']);
        $video->setId($videoData['id']);

        if($videoData['image'] !== null){
            $video->setFilePah($videoData['image']);
        }

        return $video;
    }

    public function removeImage(int $id) {

        $sql = 'UPDATE videos SET image = null WHERE id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        
        return $stmt->execute();
    }

    public function deleteData($id): string {
        $sql = 'SELECT image FROM videos WHERE id = ?;';
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        $data = $sql->fetch(PDO::FETCH_ASSOC);
        $caminho_do_arquivo = __DIR__ . ("/../../public/img/uploads/" . $data['image']);
        if (file_exists($caminho_do_arquivo)) {
            if (unlink($caminho_do_arquivo)) {
                return "Arquivo excluído com sucesso.";
            } else {
                return "Erro ao tentar excluir o arquivo.";
            }
        } else {
            return "Arquivo não encontrado.";
        }
    }
}