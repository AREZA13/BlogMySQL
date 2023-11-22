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

    public function showCreateArticleTemplate(): never
    {
        View::createArticle();
    }

    public function showEditArticleTemplate(int $id): never
    {
        $article = $this->db->getArticleById($id);
        View::articleEdit($article);
    }

    public function createArticle(): never
    {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $user_id = (int)$_SESSION['user_id'];

        if ($this->db->createArticle($content, $title, $user_id)) {
            header("Location: /");
        }

        exit();
    }

    public function updateArticle(): never
    {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $user_id = (int)$_SESSION['user_id'];
        $article_id = (int)$_POST['article_id'];

        if ($this->db->updateArticle($article_id, $title, $content, $user_id)) {
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

    public function searchByQuery() : never
    {
        try {
            $search = $_GET['search'];
            $articles = $this->db->getArticleBySearch($search);
            View::articleAll($articles);
            }catch (\Exception $e){}

    exit();
    }

}

