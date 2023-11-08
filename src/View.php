<?php

namespace App;

class View
{
    public static function generateHtmlStart(): string
    {
        return '<!doctype html>
            <html lang="ru">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>Article</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
                      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
                      crossorigin="anonymous">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
                        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
                        crossorigin="anonymous">
                </script>
            </head>
            <body>
            ';
    }

    public static function generateHtmlEnd(): string
    {
        return '<div class="d-flex justify-content-center">
                <a href="/" class="btn btn-danger btn-lg">Back to article list</a></div>
                </body>
                </html>';
    }

    /** показывает страницу со статьей
     * @param array{id: int, user_id: int, title: string, content: string} $article
     */
    public static function article(array $article): never
    {
        echo self::generateHtmlStart() . "<div class='container mt-5'>
              <h1 class='text-center'>Article # " . $article['id'] . " (created by user #" . $article['user_id'] . ")</h1>
              <h2 class='pt-5 text-center'>" . $article['title'] . "</h2>
              <p>" . $article['content'] . '</p></div>
              ' . self::generateHtmlEnd();
        exit();
    }

    public static function articleAll($articles): never
    {
        $articlesTableRows = '';

        foreach ($articles as $article) {
            $articlesTableRows .= "<tr> 
            <td> " . $article['id'] . "</td>
            <td>  " . $article['title'] . "</td>
            <td> " . $article['content'] . " </td>
            <td> " . $article['user_id'] . " </td>
        </tr>";
        }

        echo self::generateHtmlStart() .
            ' <body>
                <div class="d-flex justify-content-center pt-4 mb-5">
        <a href="/" class="btn btn-warning btn-lg">Return back to List</a>
                </div>' . '
                <h1 class="text-center">Articles table</h1>
                <h2 class="pt-5 text-center">Articles count: '
            . count($articles) . '</h2>
                <div class="row justify-content-end">
    <div class="mw-50" style="width: 400px;">
        <form class="input-group" action="/">
            <input type="text" id="<?= SEARCH_KEY_NAME ?>" name="<?= SEARCH_KEY_NAME ?>" class="form-control rounded"
                   placeholder="Search by title" aria-label="Search"/>
            <button type="submit" class="btn btn-primary rounded">search</button>
        </form>
    </div>
</div>
    <table class="table table-hover">
    <thead>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Content</th>
        <th>User ID</th>
    </tr>
    </thead>
   
     <tbody> 
     ' . $articlesTableRows . '
    </tbody>
</table>
        <div class="d-flex justify-content-center pt-4">
        <a href="/create-article" class="btn btn-primary btn-lg">Create new article</a>
    </div>
                </body>';
        exit();
    }

    public static function getUserById($user): never
    {
        echo self::generateHtmlStart() . '  
                <div class="container mt-5"> 
                ' . "<h1 class='text-center'>User # " . $user['id'] . " (user Login #" . $user['login'] . ")</h1>
                <h2 class='pt-5 text-center'>" . $user['password_hashed'] . "</h2>
                <p>" . $user['content'] . '</p> ' . self::generateHtmlEnd() . '
                </div>';
        exit();
    }

    public static function articleCreateForm(): never
    {
        echo '<h1 class="text-center">Create article</h1>
        <form action="" method="post">     
            <input type="hidden" name="<?= NEW_ARTICLE_KEY_NAME ?>" value="true">
        
            <div class="row">
                <div class="col">
                    <label class="form-label" for="<?= TITLE_KEY_NAME ?>">Title</label>
                    <input name="<?= TITLE_KEY_NAME ?>" id="<?= TITLE_KEY_NAME ?>" placeholder="Most original title"
                           type="text" maxlength="60" class="form-control" required>
                    <div class="invalid-feedback">No more than 60 symbols</div>
                </div>
            </div>
        
            <div class="row mt-2">
                <div class="col">
                    <label class="form-label" for="<?= CONTENT_KEY_NAME ?>">Content</label>
                    <textarea name="<?= CONTENT_KEY_NAME ?>" id="<?= CONTENT_KEY_NAME ?>" placeholder="Most talented content"
                              rows="5" class="form-control" required></textarea>
                </div>
            </div>
        
            <div class="d-flex justify-content-center">
                <button type="submit" name="submit" class="btn btn-primary btn-lg m-4">Submit</button>
            </div>
        
        </form>';
        exit();
    }

    public static function loginAndCreateForm(): never
    {
        echo self::generateHtmlStart() . '<form action="/register" method="post">
                    <input type="hidden" name="register" value="1">
                    <div class="mb-3 row">
                        <label for="login" class="col-sm-2 col-form-label">Login</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="login"
                                   name="login">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password"
                                   name="password">
                        </div>
                    </div>
                    <div class="d-flex flex-row-reverse">
                        <button type="button" class="btn btn-secondary ms-2" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger ms-2">Register</button>
                    </div>
                </form>
                <form action="/login" method="post">
                    <div class="mb-3 row">
                        <label for="login" class="col-sm-2 col-form-label">Login</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="login"
                                   name="login">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password"
                                   name="password">
                        </div>
                    </div>
                    <div class="d-flex flex-row-reverse">
                        <button type="button" class="btn btn-secondary ms-2" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary ms-2">Login</button>
                    </div>
                </form>' . self::generateHtmlEnd();
        exit();

    }
}

