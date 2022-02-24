<?php

//CHEK IF USER ACCESED PAGE THROUH LINK
if(isset($_POST["submit"])){

    $commentBody =  $_POST["commentBody"];
    $poster = $_POST["username"];
    $postID = $_POST["postID"];

    //ERROR HANDLERS
    require_once "functions.php";
    require_once "DatabaseHandler.php";


    if(PostFieldsEmpty($postID, $commentBody) !== false){
        header("location: ../postDetail.php?postID=$postID'error=emptyinput");
        exit();
    }

    if(EmptyField($commentBody) !== false){
        header("location: ../postDetail.php?postID=$postID'error=emptyCommentBody");
        exit();
    }


    CreateNewComment($connection, $commentBody ,$poster, $postID);

}else{

    header("location: ../postDetail.php?postID=$postID");
    exit();

}

?>