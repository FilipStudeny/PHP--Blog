<?php
    include_once "./Components/header.php"
?>

<main class="PageBody">

<section class="SignUpSection">
    <form class="SignUpForm" action="guards/login_inc.php" method="post">
        <div>
            <label>Username</label>
            <input type="text" name="username" placeholder="Username/email@email.com...">
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" placeholder="Password...">
        </div>

        <button type="submit" name="submit">Login</button>
    </form>
<?php

    if(isset($_GET["error"])){
        if($_GET["error"] == "emtpyinput"){
            echo "<p>ALL FIELDS REQUIRED !</p>";

        }else if($_GET["error"] == "UserDoesNotExist"){
            echo "<p>USER DOES NOT EXIST !</p>";  

        }else if($_GET["error"] == "IncorrectPassword"){
            echo "<p>INCORECT PASSWORD!</p>"; 
        }
    }
?>
</section>

</main>
<?php
    include_once "./Components/footer.php"
?>