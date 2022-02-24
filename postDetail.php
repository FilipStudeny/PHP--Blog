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

<section class="CommentsSection">
    <section class="CommentFormSection">
        <form class="CommentForm" action="guards/comments_inc.php" method="post">
            <textarea  name="commentBody" rows="10" cols="100" placeholder="Comment text..."></textarea>
            <button type="submit" name="submit">Post comment</button>
            <input style="display: none;" name="username" value= <?= $_SESSION["username"] ?>>
            <input style="display: none;" name="postID" value= <?= $postID ?>>

        </form>
    </section>

    <?=  RenderAllComments($connection, $postID) ?>
</section>
</main>

<?php
    include_once "./Components/footer.php"
?>