<?php

namespace App\Controller;

use App\Db;
use App\View;
use Monolog\Logger;

class Article
{
    public function __construct(private readonly Logger $logger, private readonly Db $db)
    {
    }

    public function getById(int $id): never
    {
        $this->logger->warning("Article.php getById() method called with article ID: int $id");
        $article = $this->db->getArticleById($id);
        View::article($article);
    }

    public function getAll(): never
    {
        $this->logger->warning("Article.php getById() method called with getAll()");
        $articles = $this->db->getArticleAll();
        View::articleAll($articles);
    }

    public function showArticleTemplate(): never
    {
        View::createArticle();
    }

    public function createArticle(): never
    {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $user_id = $_SESSION['user_id'];

        if ($this->db->createArticle($content, $title, $user_id)) {
            header("Location: /");
        }

        exit();
    }


    public function deleteArticle(int $id): never
    {
        if ($this->db->deleteArticle($id)) {
            header("Location: /");
        }

        exit();
    }
}

