<!DOCTYPE html>
<html lang="en">

<head>
    <Title>Forgotten Password|Bradford Council</Title>
    <link rel="stylesheet" href="stylesheet.css">
</head>

<body class="main">

<?php require_once("includes/navbar.php"); ?>
    

    <div class="log">
        <form action="sendResetLink.php" method="post">
            <label class="placeholder">Email</label>
            <input class="log input" type="email" name="email"/>
            <button class="log button" type="submit">Send</button>
        </form>

    </div>

    <div class="register-text">
        <a href="login.php">Log In</a>
    </div>



</body>

<?php require_once("includes/footer.php"); ?>