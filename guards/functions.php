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

    $newTable = "CREATE TABLE " . $username . " ( 
                postID INT(6) AUTO_INCREMENT PRIMARY KEY,
                postName VARCHAR(150) NOT NULL,
                postBody VARCHAR(500) NOT NULL,
                timeCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP )";
    
    mysqli_query($connection, $newTable);

    header("location: ../signUp.php?error=none");
    exit();

}

function InputFieldsLogin($username, $password){
    $result = false;

    if(empty($username) || empty($password)){
        $result = true;
    }else{
        $result = false;
    }

    return $result;
}

function LoginUser($connection, $username, $password){
    $userAlreadyExists = UserNameTaken($connection, $username, $username);

    if( $userAlreadyExists === false){
        header("location: ../login.php?error=UserDoesNotExist");
        exit();
    }

    $hashedPassword = $userAlreadyExists["password"];
    $checkedPassword = password_verify($password, $hashedPassword);

    if($checkedPassword === false){
        header("location: ../login.php?error=IncorrectPassword");
        exit();
    }else if($checkedPassword === true){
        session_start();
        $_SESSION["username"] = $userAlreadyExists["username"];
        
        header("location: ../index.php");
        exit();
    }
}

function PostFieldsEmpty($postTitle, $postBody){
    $result = false;

    if(empty($postTitle || empty($postBody))){
        $result = true;
    }else{
        $result = false;
    }

    return $result;
}

function EmptyField($text){
    $result = false;

    if(empty($text)){
        $result = true;
    }else{
        $result = false;
    }

    return $result;
}

function CreateNewPost($connection, $username, $postTitle ,$postBody){
    $SQL = "INSERT INTO $username (postName, postBody) VALUES (?,?);";
    $stmt = mysqli_stmt_init($connection);
    
    if(!mysqli_stmt_prepare($stmt, $SQL)){
        header("location: ../createPost.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt,"ss", $postTitle, $postBody);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../createPost.php?error=none");
    exit();
}

?>