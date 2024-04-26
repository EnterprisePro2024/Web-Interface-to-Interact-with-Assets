<?php 
require_once("includes/setup.php");
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
    <?php require_once("includes/navbar.php"); ?>
    
    <?php
        include("phpdb.php");
    ?>

    <?php
        include("map.php");
    ?>
    
</body>

<?php require_once("includes/footer.php"); ?>