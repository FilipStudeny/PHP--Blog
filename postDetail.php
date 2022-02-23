<?php
    include_once "./Components/header.php";

        //ERROR HANDLERS
        require_once "guards/functions.php";
        require_once "guards/DatabaseHandler.php";

    $username = $_SESSION["username"];
?>

<main class="PageBody">
<?php

if(isset($_REQUEST['postID']))

    $postID = $_REQUEST['postID'];
 
    ShowPostDetail($connection, $postID)

?>
</main>

<?php
    include_once "./Components/footer.php"
?>