<?php session_start() ?>
<!doctype html>
<html lang="en">
    <?php include("./components/head.html"); ?>
<body>
    <?php include('./components/header.php'); ?>

    <div class="card p-4 bg-secondary bg-opacity-10 shadow position-absolute top-50 start-50 translate-middle">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" style="width: 225px;">
            <div class="mb-2 position-relative">
                <label class="form-label mb-0" for="username"> Username </label>
                <input name="username"
                       value="<?php echo $_SESSION["usernameInput"] ?>"
                       required
                       id="username"
                       type="text"
                       class="form-control">
                <div class="invalid-feedback form-text lh-1"> User not found! </div>
            </div>
            <div class="mb-4">
                <label class="form-label mb-0" for="password"> Password </label>
                <input name="password"
                       value="<?php echo $_SESSION["passwordInput"] ?>"
                       required
                       id="password"
                       type="text"
                       class="form-control">
                <div class="invalid-feedback form-text lh-1"> Password is wrong! </div>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" name="submit" class="btn btn-primary">Submit <i class="bi bi-box-arrow-in-right"></i> </button>
                <a href="register.php" class="btn btn-outline-secondary"> <i class="bi bi-person-plus-fill"></i> Register</a>
            </div>
        </form>
    </div>
</body>
</html>

<?php
require_once "./Db/Db.php";
require_once "./Db/Manager.php";
require_once "./Db/UserManager.php";
use Db\UserManager;

const userManager = new UserManager();

if(isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"]==="POST"){
    $_SESSION['usernameInput'] = $_POST["username"];
    $_SESSION['passwordInput'] = $_POST["password"];
    if(empty($_POST["username"]) || empty($_POST["password"])){
        header("location: /login?".urlencode("error=Neither username nor password can't be empty"));
    }

    $loginResult = \userManager->login($_POST["username"], $_POST["password"]);

    if($loginResult instanceof Exception){
        header("location: /login.php?".urlencode("error={$loginResult->getMessage()}"));
        return;
    }
    $_SESSION['logged_user'] = $loginResult;
    header("location: /");
}


