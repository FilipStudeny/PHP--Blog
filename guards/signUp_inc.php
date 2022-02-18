<?php

//CHEK IF USER ACCESED PAGE THROUH LINK
if(isset($_POST["submit"])){

    $name = $_POST["name"];
    $surname = $_POST["surname"];   
    $username = $_POST["username"];    
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["passwordRepeat"];

    //ERROR HANDLERS
    require_once "functions.php";
    require_once "DatabaseHandler.php";


    if(InputFieldsNotNull($name, $surname, $username, $email, $password, $passwordRepeat) !== false){
        header("location: ../signUp.php?error=emtpyinput");
        exit();
    }

    if(InvalidUserName($username) !== false){
        header("location: ../signUp.php?error=InvalidUsername");
        exit();
    }

    if(InvalidUserEmail($email) !== false){
        header("location: ../signUp.php?error=InvalidEmail");
        exit();
    }

    if(PasswordMatches($password, $passwordRepeat) !== false){
        header("location: ../signUp.php?error=InvalidPasswordMatch");
        exit();
    }

    if(UserNameTaken($connection, $username, $email) !== false){
        header("location: ../signUp.php?error=UsernameAlreadyTaken");
        exit();
    }

    CreateNewUser($connection, $name, $surname, $username, $password, $email);


}else{
    header("location: ../signUp.php");
    exit();

}


?>