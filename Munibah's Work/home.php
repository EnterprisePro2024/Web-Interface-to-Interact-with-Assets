<?php 
require_once("setup.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] == false) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <Title>Home|Bradford Council</Title>
    <link rel="stylesheet" href="stylesheet.css">
</head>

<body class="main">
    <?php require_once("navbar.php"); ?>
    
    <?php
        include("phpdb.php");
    ?>
    
</body>

<?php require_once("footer.php"); ?>