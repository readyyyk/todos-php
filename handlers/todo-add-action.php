<?php
session_start();

const HTTP_BAD_REQUEST = 400;
const HTTP_UNAUTHORIZED = 401;
const HTTP_METHOD_NOT_ALLOWED = 405;

require_once "../Db/Db.php";
require_once "../Db/TodoManager.php";

use Db\TodoManager;

$todoManager = new TodoManager();

if ($_SERVER["REQUEST_METHOD"]!=="POST") {
    http_response_code(HTTP_METHOD_NOT_ALLOWED);
    header("location: /");
}
if (!isset($_SESSION["logged_user"])) {
    http_response_code(HTTP_UNAUTHORIZED);
    header("location: /");
}

$title = trim($_POST["title"]);
if (isset($_POST["new"]) && !empty($title)) {
    try {
        $todoManager->add($title, $_SESSION["logged_user"]["id"]);
        header("location: /");
    } catch (Exception $e) {
        var_dump($e);
    }
} else {
    http_response_code(HTTP_BAD_REQUEST);
    header("location: /");
}
