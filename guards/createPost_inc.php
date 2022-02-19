<?php

//CHEK IF USER ACCESED PAGE THROUH LINK
if(isset($_POST["submit"])){

    $username =  $_POST["username"];
    $postTitle = $_POST["postTitle"];
    $postBody = $_POST["postBody"];

    //ERROR HANDLERS
    require_once "functions.php";
    require_once "DatabaseHandler.php";


    if(PostFieldsEmpty($postTitle, $postBody) !== false){
        header("location: ../createPost.php?error=emptyinput");
        exit();
    }

    if(EmptyField($postTitle) !== false){
        header("location: ../createPost.php?error=emptyPostTitle");
        exit();
    }

    if(EmptyField($postBody) !== false){
        header("location: ../signUp.php?error=emptyPostBody");
        exit();
    }

    CreateNewPost($connection, $username, $postTitle ,$postBody);

}else{
    header("location: ../createPost.php");
    exit();

}


?>