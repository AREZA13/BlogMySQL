<?php

namespace App\Controller;

use App\Db;
use App\View;
use Monolog\Logger;

class User
{
    public function __construct(private readonly Logger $logger, private readonly Db $db)
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
}