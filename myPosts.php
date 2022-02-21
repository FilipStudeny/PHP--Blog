<?php
    include_once "./Components/header.php";

        //ERROR HANDLERS
        require_once "guards/functions.php";
        require_once "guards/DatabaseHandler.php";

    $username = $_SESSION["username"];
?>

<main class="PageBody">
    <?= RenderMyPosts($connection,$username) ?>

    <?php
    if(isset($_GET["error"])){
        if($_GET["error"] == "deleteerror"){
            echo "<p>ERROR DELETING POST TRY AGAIN !</p>";
        }
    }
    ?>
</main>

<?php
    include_once "./Components/footer.php"
?>