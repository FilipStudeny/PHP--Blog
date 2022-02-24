<?php

/**
 * @param string $name  $surname  Name of the person 
 * @param string $surname Surname of the person
 * @param string $username  Username of the account
 * @param string $email  Email adress binded to the account
 * @param string $password  Password of the account
 * @return bool $result  Returns true if one of the user inputs contains empty data
 */

function InputFieldsNotNull($name, $surname, $username, $email, $password, $passwordRepeat){
    $result = false;

    if(empty($name) || empty($surname) || empty($username) || empty($email) || empty($password) || empty($passwordRepeat)){
        $result = true;
    }else{
        $result = false;
    }

    return $result;
};
   
/**
 * @param string $username  Username of the account
 * @return bool $result  Returns true if one of the user inputs contains empty data
 */
function InvalidUserName($username){
    $result = false;
    if(!preg_match("/^[a-zA-Z0-9]*$/",$username)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

/**
 * @param string $email  Email adress binded to the account
 * @return bool $result  Returns true if one of the user inputs contains empty data
 */
function InvalidUserEmail($email){
    $result = false;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

/**
 * Checks if inputed password matches
 * @param string $password  Password of the account
 * @param string $passwordRepeat  Password of the account
 * @return bool $result  Returns true if one of the user inputs contains empty data
 */
function PasswordMatches($password, $passwordRepeat){
    $result = false;
    if($password !== $passwordRepeat){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

/**
 * Checks if username is already taken
 * @param string $username  Username of the account
 * @param string $email  Email adress binded to the account
 */
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

/**
 * Creates new User account
 * @param string $name  Name of the person
 * @param string $surname Surname of the person
 * @param string $username Username of the account
 * @param string $password Password for the account
 * @param string $email Email adress binded to the account
 */

function CreateNewUser($connection, $name, $surname, $username, $password, $email){
    $SQL = "INSERT INTO Users (username, name, surname, email, password) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($connection);
    
    if(!mysqli_stmt_prepare($stmt, $SQL)){
        header("location: ../signUp.php?error=stmtFailed");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt,"sssss",$username, $name,  $surname, $email, $hashedPassword);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../index.php");
    exit();

}

/**
 * Check if Login input is empty
 * @param string $username Username of the account
 * @param string $password Password for the account
 * @return bool $result Returns true if input is empty
 */

function InputFieldsLogin($username, $password){
    $result = false;

    if(empty($username) || empty($password)){
        $result = true;
    }else{
        $result = false;
    }

    return $result;
}

/**
 * Login user and start new session
 * @param string $username Username of the account
 * @param string $password Password for the account
 */

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

/**
 * Check if Post input is empty
 * @param string $postTitle Surname of the person
 * @param string $postBody Username of the account
 * @return bool $result Returns true if post data is empty
 */

function PostFieldsEmpty($postTitle, $postBody){
    $result = false;

    if(empty($postTitle || empty($postBody))){
        $result = true;
    }else{
        $result = false;
    }

    return $result;
}

/**
 * Check if field is empty
 * @param string $text 
 * @return bool $result Returns true if  data is empty
 */
function EmptyField($text){
    $result = false;

    if(empty($text)){
        $result = true;
    }else{
        $result = false;
    }

    return $result;
}

/**
 * Create new Post
 * @param string $username Creator of the post
 * @param string $postTitle Post title
 * @param string $postBody Post body
 */
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

    header("location: ../index.php");
    exit();
}

/**
 * Render all posts
 */
function RenderAllPosts($connection){

    $SQL = "SELECT postID, creatorName, postTitle, postBody, timeOfCreation FROM posts ORDER BY postID DESC";
    $data = mysqli_query($connection, $SQL);

    //OUTPUT DATA 
    if(mysqli_num_rows($data) > 0){

        while($row = mysqli_fetch_assoc($data)){

            $post = "
            <section class='Post'>
                <a href='/postDetail.php?postID=".$row['postID']."'>
                <div>
                    <h3>" . $row["postTitle"] . "</h3>
                </div>
                <p>" . str_replace(array("\r\n", "\r", "\n"), "<br/>",$row["postBody"]) . "</p>
                <div>
                    <h4>Written by " . $row["creatorName"] . "</h4>
                    <h4>Date of creation: " . $row["timeOfCreation"] . "</h4>
                </div>
                </a>
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

/**
 * Render all posts created by user
 * @param string $username Name of the creator of the post
 */
function RenderMyPosts($connection, $username){

    $SQL = "SELECT  postID, creatorName, postTitle, postBody, timeOfCreation FROM posts WHERE creatorName='$username' ORDER BY postID DESC";
    $data = mysqli_query($connection, $SQL);

    //OUTPUT DATA 
    if(mysqli_num_rows($data) > 0){

        while($row = mysqli_fetch_assoc($data)){
            $post = "
            <section class='Post'>
                <a href='/postDetail.php?postID=".$row['postID']."'>
                <div>
                    <h3>" . $row["postTitle"] . "</h3>
                    <form action='guards/myPosts_inc.php' method='post'>
                        <input style='display: none;' type='text' name='postID' value=".$row["postID"] . ">
                        <button class='DeletePostBtn' type='submit' name='submit' >Delete Post</button>
                    </form>
                </div>
                <p>" . str_replace(array("\r\n", "\r", "\n"), "<br/>",$row["postBody"]) . "</p>
                <div>
                    <h4>Written by " . $row["creatorName"] . "</h4>
                    <h4>Date of creation: " . $row["timeOfCreation"] . "</h4>
                </div>
                </a>
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

/**
 * Delete post
 * @param string $postID 
 */
function DeletePost($connection, $postID){
    $SQL = "DELETE FROM posts WHERE postID='$postID'";

    if(mysqli_query($connection, $SQL)){
        mysqli_close($connection);
        header("location: ../myPosts.php");
        exit();
    }
}

function ShowPostDetail($connection, $postID){

    $SQL = "SELECT  postID, creatorName, postTitle, postBody, timeOfCreation FROM posts WHERE postID='$postID'";
    $data = mysqli_query($connection, $SQL);

    //OUTPUT DATA 
    if(mysqli_num_rows($data) > 0){

        while($row = mysqli_fetch_assoc($data)){
            $post = NULL; 
            if($_SESSION['username'] === $row["creatorName"]){
               $post = 
               "<section class='Post'>
                    <div>"
                        .$_SESSION['username']."
                        <h3>" . $row["postTitle"] . "</h3> 
                        <form action='guards/myPosts_inc.php' method='post'>
                            <input style='display: none;' type='text' name='postID' value=".$row["postID"] . ">
                            <button class='DeletePostBtn' type='submit' name='submit' >Delete Post</button>
                        </form>
                    </div>
                    <p>" . str_replace(array("\r\n", "\r", "\n"), "<br/>",$row["postBody"]) . "</p>
                    <div>
                        <h4>Written by " . $row["creatorName"] . "</h4>
                        <h4>Date of creation: " . $row["timeOfCreation"] . "</h4>
                    </div>
                </section>";
            }else{
                $post = 
                "<section class='Post'>
                     <div>
                         <h3>" . $row["postTitle"] . "</h3> 
                     </div>
                     <p>" . str_replace(array("\r\n", "\r", "\n"), "<br/>",$row["postBody"]) . "</p>
                     <div>
                         <h4>Written by " . $row["creatorName"] . "</h4>
                         <h4>Date of creation: " . $row["timeOfCreation"] . "</h4>
                     </div>
                 </section>";
            }
            
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