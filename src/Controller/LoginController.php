<?php

declare(strict_types= 1);

namespace Dbseller\Aluraplay\Controller;
use Dbseller\Aluraplay\ConexaoBd;
use Dbseller\Aluraplay\Helper\FlashMassageTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Dbseller\Aluraplay\Repository\UserRepository;


class LoginController implements RequestHandlerInterface{

    use FlashMassageTrait; 

    private \PDO $pdo;

    public function __construct(){
        $this->pdo = ConexaoBd::createConnexion();
    }

    public function handle(ServerRequestInterface $request):ResponseInterface {
        $email = filter_input(INPUT_POST,"email", FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST,"password");
        
        $user = new UserRepository();
        $userData = $user->matchInfo($email);
        $correctPassword = password_verify($password, $userData['password'] ?? '');

        // if (password_needs_rehash($userData['password'], PASSWORD_ARGON2ID)) {
        //     $statement = $this->pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
        //     $statement->bindValue(1, password_hash($password, PASSWORD_ARGON2ID));
        //     $statement->bindValue(2, $userData['id']);
        //     $statement->execute();
        // }

        if ($correctPassword) {
            $_SESSION['logado'] = true;
            return new Response(302, [
                'Location' => '/'
            ]);
        } else {
            $this->addErrorMessage('Usuário ou senha inválidos');
            return new Response(302, [
                'Location' => '/login']);
        }
    }
}