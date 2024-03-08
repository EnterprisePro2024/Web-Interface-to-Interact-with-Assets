<?php
$connection = mysqli_connect('localhost', 'root');

if ($connection === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

mysqli_select_db($connection, "bradford");

// Define email and password variables
$email = "";
$password = "";

// Check if email and password are set in the form data
if(isset($_POST['email']) && isset($_POST['password'])) {
    // Retrieve email and password from login form
    $email = $_POST['email'];
    $password = $_POST['password'];
}

// Query to check if email and password exist in the database
$query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
$result = mysqli_query($connection, $query);

if ($result) {
    // Check if any rows were returned
    if(mysqli_num_rows($result) > 0) {
        // Login successful, redirect to Home.html
        header("Location: Home.html");
        exit;
    } else {
        // Login failed, redirect to Login.html
        header("Location: Login.html");
        exit;
    }
} else {
    echo "ERROR: Could not able to execute $query. " . mysqli_error($connection);
}

// Close connection
mysqli_close($connection);
?>