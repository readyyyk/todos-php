<?php
require_once "./Db/Db.php";
require_once "Todo.php";
require_once "./Db/TodoManager.php";

use Db\TodoManager;
use Todo\Todo;

$todoManager = new TodoManager();
?>

<!doctype html>
<html lang="en">
    <?php include("./components/head.html"); ?>
<body>
    <?php include('./components/header.php'); ?>

    <main class="d-flex justify-content-center">
        <section class="container-lg">
            <div class="row g-3 gx-3 mt-0" data-masonry='{"percentPosition": true }'>
                <?php
                if (isset($_SESSION["logged_user"]["id"])) {
                    $todoData = $todoManager->getByOwnerId($_SESSION["logged_user"]["id"])
                        ->get_result()->fetch_all(MYSQLI_ASSOC);
                    $todoList = array_reduce(
                        $todoData,
                        function($acc, $cur) {
                            $acc[] = new Todo($cur["title"], $cur["state"], $cur["id"]);
                            return $acc;
                        },
                        []
                    );

                    // rendering todos
                    echo <<<HTML
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="card p-3  shadow position-relative bg-body" >
                                <form action="handlers/todo-add-action.php" method="POST">
                                    <label class="w-100">
                                        <textarea name="title" rows="3" maxlength="300" class="form-control" placeholder="Title" required    style="resize: none"></textarea>
                                    </label>
                                    <button type="submit" name="new" class="btn btn-success w-100 font-monospace">
                                        Add new <i class="bi bi-plus-circle "></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        HTML;
                    foreach ($todoList as $todo) {
                        echo $todo->render();
                    }
                } else {
                    echo "<h1> Login to interact </h1>";
                }
                ?>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
</body>

</html>
