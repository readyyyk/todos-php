<?php
namespace Db;

const HOST = "127.0.0.1";
const PORT = "3306";
const USER = "root";
const PASSWORD = "wEidtYg-,4E%";
const DB_NAME = "todos";
const TABLES = [
    "todos" => ["id", ],
    "USERS" => "users",
];

const connection = new \mysqli(HOST, USER, PASSWORD, DB_NAME, PORT);
function executeQuery(string $query, array $params, $typesString = ""): false|\mysqli_stmt
{
    $typesString = $typesString ?: str_repeat("s", count($params));
    $stmt = connection->prepare($query);
    $stmt->bind_param($typesString, ...$params);
//    var_dump($query, "<br/><br/>", $params, "<hr/>");
    $stmt->execute();
    return $stmt;
}

