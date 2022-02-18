<?php
    include_once "./Components/header.php"
?>

<main class="PageBody">

<section class="SignUpSection">
    <form class="SignUpForm" action="guards/signUp_inc.php" method="post">
        <div>
            <label>Name</label>
            <input type="text" name="name" placeholder="Name...">
        </div>
        <div>
            <label>Surname</label>
            <input type="text" name="surname" placeholder="Surname...">
        </div>
        <div>
            <label>Username</label>
            <input type="text" name="username" placeholder="Username...">
        </div>
        <div>
            <label>Email</label>
            <input type="text" name="email" placeholder="email@email.com...">
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" placeholder="Password...">
        </div>
        <div>
            <label>Repeat Password</label>
            <input type="password" name="passwordRepeat" placeholder="Password...">
        </div>
        <button type="submit" name="submit">Sign Up</button>
    </form>
<?php

    if(isset($_GET["error"])){
        if($_GET["error"] == "emtpyinput"){
            echo "<p>ALL FIELDS REQUIRED !</p>";

        }else if($_GET["error"] == "InvalidUsername"){
            echo "<p>INVALID USERNAME !</p>";  

        }else if($_GET["error"] == "InvalidEmail"){
            echo "<p>INVALID EMAIL!</p>"; 

        }else if($_GET["error"] == "InvalidPasswordMatch"){
            echo "<p>PASSWORDS DON'T MATCH !</p>";   

        }else if($_GET["error"] == "UsernameAlreadyTaken"){
            echo "<p>USERNAME IS ALREADY TAKEN !</p>";  

        }else if($_GET["error"] == "stmtFailed"){
            echo "<p>SOMETHING WENT WRONG TRY AGAIN !</p>";   
        }else if($_GET["error"] == "none"){
            echo "<p>SUCCESS</p>";   
        }
    }
?>
</section>



</main>
<?php
    include_once "./Components/footer.php"
?>