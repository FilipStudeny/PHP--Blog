<?php
    include_once "./Components/header.php"
?>

<main class="PageBody">

<section class="SignUpSection">
    <form class="SignUpForm" action="signup.inc.php" method="post">
        <div>
            <label>Username</label>
            <input type="text" name="username" placeholder="Username/email@email.com...">
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" placeholder="Password...">
        </div>

        <button type="submit" name="submit">Sign Up</button>
    </form>
</section>

</main>
<?php
    include_once "./Components/footer.php"
?>