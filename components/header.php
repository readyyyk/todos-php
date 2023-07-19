<?php session_start() ?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-lg">
        <ul class="navbar-nav me-auto mb-2">
            <?php if(isset($_SESSION["username"])) { ?>
                <li class="nav-item">
                    <a href="../login.php" class="btn btn-outline-primary">
                        <i class="bi bi-box-arrow-right"></i>
                        <?php
                            echo $_SESSION["username"];
                        ?>
                    </a>
                </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/"> Home </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../login.php"> Login </a>
            </li>
        </ul>
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit"> Search todos </button>
        </form>
    </div>
</nav>