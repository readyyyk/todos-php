<?php
namespace Todo;
?>

<div class="col-6 col-md-4 col-lg-3">
    <div class="card p-3  shadow position-relative bg-body" >
        <form action="<?php echo htmlspecialchars($_SESSION["PHP_SELF"]) ?>" method="POST">
            <label class="w-100">
                <textarea name="title" rows="3" maxlength="300" class="form-control" placeholder="Title"></textarea>
            </label>
            <button type="submit" class="btn btn-success w-100 font-monospace">
                Add new <i class="bi bi-plus-circle "></i>
            </button>
        </form>
    </div>
</div>

<?php
    if(isset($_POST["title"])){

    }
