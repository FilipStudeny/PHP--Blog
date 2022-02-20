<?php
    include_once "./Components/header.php";

        //ERROR HANDLERS
        require_once "guards/functions.php";
        require_once "guards/DatabaseHandler.php";
?>

<main class="PageBody">
    <?= RenderAllPosts($connection); ?>
</main>

<?php
    include_once "./Components/footer.php"
?>