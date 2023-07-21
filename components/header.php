<?php session_start() ?>
<?php
$_SESSION["logged_user"] = [
    "id"=>1,
    "username"=>"test",
];
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-lg">
        <ul class="navbar-nav flex-row me-auto">
            <?php if(isset($_SESSION["logged_user"]["id"])) { ?>
                <li class="nav-item me-2">
                    <a href="../login.php" class="btn btn-outline-primary">
                        <i class="bi bi-box-arrow-right"></i>
                        <?php
                            echo $_SESSION["logged_user"]["username"];
                        ?>
                    </a>
                </li>
            <?php } ?>
            <li class="nav-item me-2">
                <a class="nav-link active" aria-current="page" href="/"> Home </a>
            </li>
            <li class="nav-item me-auto">
                <a class="nav-link" href="../login.php"> Login </a>
            </li>
        </ul>
        <form class="d-flex" role="search">
            <input disabled class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit"> Search todos </button>
        </form>
    </div>
</nav>