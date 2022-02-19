<?php
    include_once "./Components/header.php"

?>

<main class="PageBody">

<section class="SignUpSection">
    <form class="SignUpForm" action="guards/createPost_inc.php" method="post">
        <h3 class="CreatePostTitle">Create new Post + <?= $_SESSION["username"]  ?></h3>
        <div>
            <input type="text" name="postTitle" placeholder="Post title...">
        </div>
        <div>
            <textarea class="PostTextArea" name="postBody" rows="10" cols="100" placeholder="Post text..."></textarea>
        </div>
        
        <button type="submit" name="submit">Sign Up</button>
        <input style="display: none;" name="username" value= <?= $_SESSION["username"] ?>>
    </form>
<?php

    if(isset($_GET["error"])){
        if($_GET["error"] == "emptyinput"){
            echo "<p>ALL FIELDS REQUIRED !</p>";

        }else if($_GET["error"] == "emptyPostTitle"){
            echo "<p>EMPTY POST TITLE !</p>";  

        }else if($_GET["error"] == "emptyPostBody"){
            echo "<p>EMPTY POST BODY !</p>"; 

        }else if($_GET["error"] == "stmtFailed"){
            echo "<p>SOMETHING WENT WRONG TRY AGAIN !</p>";  

        }else if($_GET["error"] == "none"){
            echo "<p>SUCCESS</p>";   
        }
    }
?>
</section>



</main>
<?php
    include_once "./Components/footer.php"
?>