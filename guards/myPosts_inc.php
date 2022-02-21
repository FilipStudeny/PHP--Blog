<?php

//CHEK IF USER ACCESED PAGE THROUH LINK
if(isset($_POST["submit"])){

    $postID = $_POST["postID"];  

    //ERROR HANDLERS
    require_once "functions.php";
    require_once "DatabaseHandler.php";


    DeletePost($connection,$postID);

}else{
    header("location: ../myPosts.php");
    exit();

}


?>