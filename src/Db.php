<?php

namespace App;

use PDO;

class Db
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    /** @return false|array{id: int, user_id: int, title: string, content: string} */
    public function getArticleById(int $id): array|false
    {
        $sql = "SELECT * FROM articles WHERE id = :articleId";
        $pdoStatement = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $pdoStatement->execute(['articleId' => $id]);
        return $pdoStatement->fetch(PDO::FETCH_ASSOC);
    }

    public function getArticleAll(): array|false
    {
        $sql = "SELECT * FROM articles";
        $pdoStatement = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $pdoStatement->execute();
        return $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById(int $id): array|false
    {
        $sql = "SELECT * FROM users WHERE id = :userId";
        $pdoStatement = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $pdoStatement->execute(['userId' => $id]);
        return $pdoStatement->fetch(PDO::FETCH_ASSOC);
    }
}
