<?php
$connection = mysqli_connect('localhost', 'root');

if ($connection === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
// TEst
mysqli_select_db($connection, "bradford");

$fname = "";
$sname = "";
$email = "";
$password = "";
$department = "";

if (isset($_POST['forename'])) {
    $fname = $_POST['forename'];
}
if (isset($_POST['surname'])) {
    $sname = $_POST['surname'];
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}
if (isset($_POST['password'])) {
    $password = $_POST['password'];
}
if (isset($_POST['department'])) {
    $department = $_POST['department'];
}

$query = "INSERT INTO `users` (`forename`, `surname`, `email`, `password`, `department`) VALUES ('$fname', '$sname', '$email', '$password', '$department')";

if (mysqli_query($connection, $query)) {
    header("Location: Register.html");
} else {
    echo "ERROR: Could not able to execute $query. " . mysqli_error($connection);
}

// Close connection
mysqli_close($connection);
