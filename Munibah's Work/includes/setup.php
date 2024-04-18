<?php 
session_start();
$connection = mysqli_connect('localhost', 'root',);

if ($connection === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

mysqli_select_db($connection, "assets");
?>