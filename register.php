<?php session_start() ?>
<!doctype html>
<html lang="en">
    <?php include("./components/head.html"); ?>
<body>
    <?php include('./components/header.php'); ?>

    <div class="card p-4 bg-secondary bg-opacity-10 shadow position-absolute top-50 start-50 translate-middle">
        <form action="<?php echo htmlspecialchars($_SESSION["PHP_SELF"]) ?>" method="POST" style="width: 225px;">
            <div class="mb-2 position-relative">
                <label class="form-label mb-0" for="username"> Username </label>
                <input name="username"
                       value="<?php echo $_SESSION["usernameInput"] ?>"
                       id="username"
                       required
                       type="text"
                       class="form-control <?php echo isset($_GET["usernameError"]) ? "is-invalid" : "" ?>">
                <div class="invalid-feedback form-text lh-1"> <?php echo $_GET["usernameError"] ?> </div>
            </div>
            <div class="mb-2">
                <label class="form-label mb-0" for="password"> Password </label>
                <input name="password"
                       value="<?php echo $_SESSION["passwordInput"] ?>"
                       id="password"
                       required
                       type="text"
                       class="form-control <?php echo isset($_GET["passwordError"]) ? "is-invalid" : "" ?>">
                <div class="invalid-feedback form-text lh-1"> <?php echo $_GET["passwordError"] ?> </div>
            </div>
            <div class="mb-4">
                <label class="form-label mb-0" for="password2"> Password </label>
                <input name="password2"
                       value="<?php echo $_SESSION["password2Input"] ?>"
                       id="password2"
                       required
                       type="text"
                       class="form-control <?php echo isset($_GET["password2Error"]) ? "is-invalid" : "" ?>">
                <div class="invalid-feedback form-text lh-1"> <?php echo $_GET["password2Error"] ?> </div>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" name="submit" class="btn btn-primary">Submit <i class="bi bi-person-plus-fill"></i> </button>
                <a href="login.php" class="btn btn-outline-secondary"> <i class="bi bi-box-arrow-in-right"></i> Login</a>
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

if(isset($_POST["submit"])){
    $_SESSION['usernameInput'] = $_POST["username"];
    $_SESSION['passwordInput'] = $_POST["password"];
    $_SESSION['password2Input'] = $_POST["password2"];

    $currentLocation = htmlspecialchars($_SERVER["PHP_SELF"]);

    if(preg_match('/[^A-Za-z]/', $_POST["username"])){
        header("location: $currentLocation?usernameError=".urlencode("Username can contain only english characters!"));
        return;
    }
    if(strlen($_POST["password"])<3){
        header("location: $currentLocation?passwordError=".urlencode("Password must be at least 3 characters!"));
        return;
    }
    if($_POST["password2"] !== $_POST["password"]){
        header("location: $currentLocation?password2Error=".urlencode("Passwords are different!"));
        return;
    }

    $registerResult = \userManager->register($_POST["username"], $_POST["password"]);
    var_dump($registerResult);
    return;
    if($registerResult instanceof Exception){
        header("location: $currentLocation?error=".urlencode($registerResult->getMessage()));
        return;
    }

    $_SESSION['logged_user'] = $registerResult;
    header("location: /");
}



