<?php

//CHEK IF USER ACCESED PAGE THROUH LINK
if(isset($_POST["submit"])){

    $username = $_POST["username"];    
    $password = $_POST["password"];

    //ERROR HANDLERS
    require_once "functions.php";
    require_once "DatabaseHandler.php";


    if(InputFieldsLogin($username, $password) !== false){
        header("location: ../login.php?error=emtpyinput");
        exit();
    }

    LoginUser($connection, $username, $password);


}else{
    header("location: ../login.php");
    exit();
}

?>
