<?php

namespace App\Controller;

use App\Db;
use App\View;
use Exception;
use Monolog\Logger;

class User
{
    public function __construct(
        private readonly Logger $logger,
        private readonly Db     $db
    )
    {
    }

    public function getById(int $id): never
    {
        $this->logger->warning("User.php getById() method called with User getById: (int $id)");
        $user = $this->db->getUserById($id);

        if ($user === false) {
            http_response_code(404);
            exit();
        }

        View::getUserById($user);
    }

    public function register(): never
    {
        $login = $_POST['login'];
        $password = $_POST['password'];

        if ($this->db->createNewUser($login, $password)) {
            $userArray = $this->db->getUserByLoginAndPassword($login, $password);
            $_SESSION['user_id'] = $userArray['id'];
            header("Location: /");
        } else {
            echo 'fail';
        }

        exit();
    }

    public function login(): never
    {
        $login = $_POST['login'];
        $password = $_POST['password'];

        try {
            $userArray = $this->db->getUserByLoginAndPassword($login, $password);
            $_SESSION['user_id'] = $userArray['id'];
        } catch (Exception $e) {
        }

        header("Location: /");
        exit;
    }
}