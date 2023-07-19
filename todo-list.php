<?php
session_start();
include("./todo.php");
?>

<main class="d-flex justify-content-center">
    <section class="container-lg">
        <div class="row g-3 gx-3 mt-0" data-masonry='{"percentPosition": true }'>
            <?php
                require('./add-todo.php');
            ?>
            <?php
            $todo_array = [
                new Todo("Title", "ongoing"),
                new Todo("mkl as d asd  asd  asd  a xzc xz c asndjasjnkd njkdsanjksda knjsanjkdsnjkadasnjkd njk asdnjkka njds", "expired"),
                new Todo("Passive", "passive"),
                new Todo("Lorem ipsum dolor sit amet, consectetur adipisicing elit. NonLorem ipsum dolor sit amet, consectetur adipisicing elit. Non nostrum porro quae quaerat quos. Eligendi molestiae non nostrum numquam odit reprehenderit repudiandae similique soluta. A accusamus blanditiis cumque deserunt quas?", "passive"),
                new Todo("Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non nostrum porro quae quaerat quos. Eligendi molestiae non nostrum numquam odit reprehenderit repudiandae similique soluta. A accusamus blanditiis cumque deserunt quas?", "passive"),
                new Todo("Important", "important"),
                new Todo("Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non nostrum porro quae quaerat quos. Eligendi molestiae non nostrum numquam odit reprehenderit repudiandae similique soluta. A accusamus blanditiis cumque deserunt quas?", "done"),
            ];
            foreach ($todo_array as $todo) {
                echo $todo->render();
            }
            ?>
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
