<?php session_start() ?>
<!doctype html>
<html lang="en">
    <?php include("./head.html"); ?>
<body>
    <?php include('./header.php'); ?>

    <div class="card p-4 bg-secondary bg-opacity-10 shadow position-absolute top-50 start-50 translate-middle">
        <form action="<?php echo htmlspecialchars($_SESSION["PHP_SELF"]) ?>" method="POST" style="width: 225px;">
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
$_SESSION['usernameInput'] = $_POST["username"];
$_SESSION['passwordInput'] = $_POST["password"];
    if(isset($_POST["submit"])){
        $_SESSION["username"] = $_POST["username"];
        header("location: /");
    }


