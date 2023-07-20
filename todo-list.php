<?php
namespace Todo;
session_start();

include "Db.php";
include "TodoManager.php";
include "Todo.php";

const t = new TodoManager();

$todoData = t->getByOwner(1)->get_result()->fetch_all(MYSQLI_ASSOC);
$todoList = array_reduce(
    $todoData,
    function($acc, $cur) {
        $acc[] = new Todo($cur["title"], $cur["state"]);
        return $acc;
    },
    []
);
function TodoList($todo_array = []): void
{
    require('./add-todo.php');
    foreach ($todo_array as $todo) {
        echo $todo->render();
    }
}



TodoList($todoList);
