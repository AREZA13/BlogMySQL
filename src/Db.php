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
