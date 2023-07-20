<!doctype html>
<html lang="en">
    <?php include("./components/head.html"); ?>
<body>
    <?php include('./components/header.php'); ?>

    <main class="d-flex justify-content-center">
        <section class="container-lg">
            <div class="row g-3 gx-3 mt-0" data-masonry='{"percentPosition": true }'>
                <?php include "./todo-list.php"; ?>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
</body>

</html>
