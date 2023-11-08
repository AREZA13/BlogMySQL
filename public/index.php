<?php
declare(strict_types=1);
require_once dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "global.php";

use App\Controller;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use App\Db;

$actual_link = $_SERVER['REQUEST_URI'];

$parsedActualLink = explode('/', $actual_link);
$firstElement = $parsedActualLink[1];
$secondElement = $parsedActualLink[2];
$logger = new Logger('monolog');
$logger->pushHandler(new StreamHandler('../logs/monolog.log', Level::Warning));

try {
    $dbConnectionDsnString = "mysql:host=" . MYSQL_SERVER_NAME . ";dbname=" . MYSQL_DATABASE;
    $pdo = new PDO($dbConnectionDsnString, MYSQL_USER, MYSQL_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Throwable $e) {
    throw new PDOException("Connection failed. Throwable name: '" . $e::class . "'. Message : " . $e->getMessage());
}

$db = new Db($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (($firstElement == 'article' && !empty($secondElement))) {
        (new Controller\Article($logger, $db))->getById((int)$secondElement);
    } elseif ($firstElement == 'article' && empty($secondElement)) {
        (new Controller\Article($logger, $db))->getAll();
    } elseif ($firstElement == 'user' && !empty($secondElement)) {
        (new Controller\User($logger, $db))->getById((int)$secondElement);
    } elseif ($firstElement == 'user' && empty($secondElement)) {
        echo "Enter User ID in url";
    }
}