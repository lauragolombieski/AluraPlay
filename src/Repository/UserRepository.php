<?php

namespace Dbseller\Aluraplay\Repository;

use Dbseller\Aluraplay\ConexaoBd;
use Dbseller\Aluraplay\Repository\VideoRepository;

class UserRepository {

    private VideoRepository $videoRepository;

    public function matchInfo($email){
        $pdo = ConexaoBd::createConnexion();
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1,$email);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}