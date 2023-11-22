<?php

namespace App;

use Exception;
use PDO;
use PDOException;

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

    public function updateArticle(int $article_id, string $title, string $content, int $user_id): bool
    {
        $sql = "UPDATE articles SET title = :title, content = :content WHERE id = :articleId AND user_id = :user_id";
        $pdoStatement = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        return $pdoStatement->execute([':title' => $title, ':content' => $content, ':articleId' => $article_id, ':user_id' => $user_id]);
    }

    public function getArticleAll(): array|false
    {
        $sql = "SELECT * FROM articles";
        $pdoStatement = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $pdoStatement->execute();
        return $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createArticle(string $title, string $content, int $user_id): bool
    {
        try {
            $sql = "INSERT INTO articles (title, content, user_id) VALUES (?, ?, ?)";
            $pdoStatement = $this->pdo->prepare($sql);
            return $pdoStatement->execute([$title, $content, $user_id]);
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function deleteArticle(int $id): bool
    {

        $sql = "DELETE FROM articles WHERE id = :articleId";
        $pdoStatement = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        return $pdoStatement->execute(['articleId' => $id]);
    }

    public function getArticleBySearch(string $search): array
    {
        $sql = "SELECT * FROM articles WHERE title LIKE :search OR content LIKE :search";
        $sth = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute(['search' => "%$search%"]);
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById(int $id): array|false
    {
        $sql = "SELECT * FROM users WHERE id = :userId";
        $pdoStatement = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $pdoStatement->execute(['userId' => $id]);
        return $pdoStatement->fetch(PDO::FETCH_ASSOC);
    }

    public function createNewUser(string $login, string $password): bool
    {
        try {
            $sql = "INSERT INTO users (login, password_hashed) VALUES (?, ?)";
            $pdoStatement = $this->pdo->prepare($sql);
            return $pdoStatement->execute([$login, password_hash($password, CRYPT_STD_DES)]);
            // return $pdoStatement->execute([$login, openssl_encrypt($password, 'aes-128-cbc', PASSPHRASE) ]);
        } catch (PDOException $exception) {
            return false;
        }
    }

    /** @return false|array{id: int|string, login: string, password_hashed: string}
     * @throws Exception
     */
    public function getUserByLoginAndPassword($login, $password): array|false
    {
        $sql = "SELECT * FROM users WHERE login = ?";
        $pdoStatement = $this->pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $pdoStatement->execute([$login]);
        $userArray = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $userArray['password_hashed'])) {
            return $userArray;
        }

        throw new Exception("user password and stored hash not equal");
    }

}
