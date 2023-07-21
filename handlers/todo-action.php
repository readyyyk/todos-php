<?php

require_once "../Db/Db.php";
require_once "../Db/TodoManager.php";

use \Db\TodoManager;

const todoManager = new TodoManager();

if ($_SERVER["REQUEST_METHOD"]==="POST"){
    if (isset($_POST["delete"])){
        todoManager->deleteById((int)$_POST["id"]);
        header("location: /");
        return;
    }
    if (isset($_POST["make-passive"])){
        todoManager->updateById(["state"=>"passive"], (int)$_POST["id"]);
        header("location: /");
        return;
    }
    if (isset($_POST["make-ongoing"])){
        todoManager->updateById(["state"=>"ongoing"], (int)$_POST["id"]);
        header("location: /");
        return;
    }
    if (isset($_POST["make-done"])){
        todoManager->updateById(["state"=>"done"], (int)$_POST["id"]);
        header("location: /");
        return;
    }
    if (isset($_POST["make-important"])){
        todoManager->updateById(["state"=>"important"], (int)$_POST["id"]);
        header("location: /");
        return;
    }
}
