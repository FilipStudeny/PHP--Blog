<?php


function InputFieldsNotNull($name, $surname, $username, $email, $password, $passwordRepeat){
    $result = false;

    if(empty($name) || empty($surname) || empty($username) || empty($email) || empty($password) || empty($passwordRepeat)){
        $result = true;
    }else{
        $result = false;
    }

    return $result;
};
   
function InvalidUserName($username){
    $result = false;
    if(!preg_match("/^[a-zA-Z0-9]*$/",$username)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}


function InvalidUserEmail($email){
    $result = false;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}


function PasswordMatches($password, $passwordRepeat){
    $result = false;
    if($password !== $passwordRepeat){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

function UserNameTaken($connection, $username, $email){
    $SQL = "SELECT * FROM Users WHERE username = ? OR email = ?;";

    $stmt = mysqli_stmt_init($connection);
    
    if(!mysqli_stmt_prepare($stmt, $SQL)){
        header("location: ../signUp.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt,"ss",$username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function CreateNewUser($connection, $name, $surname, $username, $password, $email){
    $SQL = "INSERT INTO Users (username, name, email, password) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($connection);
    
    if(!mysqli_stmt_prepare($stmt, $SQL)){
        header("location: ../signUp.php?error=stmtFailed");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt,"ssss",$username, $name, $email, $hashedPassword);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../signUp.php?error=none");
    exit();

}


?>