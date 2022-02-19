<?php

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">
    <title>PHP - Blog</title>
</head>
<body>
    <header class="PageHead">
        <h1 class="PageTitle">Blog</h1>
        <div class="HeadContent">
            <nav class="Links">
                <a href="/">Home</a>
                <?php
                if(isset($_SESSION["username"])){
                    echo "<a href='/createPost.php'>Create new Post</a>";
                }else{
                    echo "<a href='login.php'>Create new Post</a>";
                }

                ?>
                <a>About</a>
            </nav>
            <?php
                if(isset($_SESSION["username"])){
                    echo "<nav class='AuthPanel'>";
                    echo "<p>" . $_SESSION["username"] . "</p>";
                    echo "<a href='guards/logout_inc.php'>Logout</a>";
                    echo "</nav>;";
                }else{
                    echo "<nav class='AuthPanel'>";
                    echo "<a href='signUp.php'>Sign up</a>";
                    echo "<a href='login.php'>Login</a>";
                    echo "</nav>;";
                }


            ?>
           
        </div>
       

    </header>
