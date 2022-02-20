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
    $SQL = "INSERT INTO posts (creatorName,postTitle, postBody) VALUES (?,?,?);";
    $stmt = mysqli_stmt_init($connection);
    
    if(!mysqli_stmt_prepare($stmt, $SQL)){
        header("location: ../createPost.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt,"sss", $username ,$postTitle, $postBody);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../createPost.php?error=none");
    exit();
}


function RenderAllPosts($connection){

    $SQL = "SELECT creatorName, postTitle, postBody, timeOfCreation FROM posts ORDER BY postID DESC";
    $data = mysqli_query($connection, $SQL);

    //OUTPUT DATA 
    if(mysqli_num_rows($data) > 0){

        while($row = mysqli_fetch_assoc($data)){
            $post = "
            <section class='Post'>
                <h3>" . $row["postTitle"] . "</h3>
                <p>" . str_replace(array("\r\n", "\r", "\n"), "<br/>",$row["postBody"]) . "</p>
                <div>
                    <h4>Written by " . $row["creatorName"] . "</h4>
                    <h4>Date of creation: " . $row["timeOfCreation"] . "</h4>
                </div>
            </section>";

            echo $post;
        }
    }else{
        $post = "
            <section class='Post'>
                <p> No posts </p>
            </section>";

            echo $post;
    }

    mysqli_close($connection);
}

?>