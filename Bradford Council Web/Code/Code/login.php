<?php
session_start();
$connection = mysqli_connect('localhost', 'root', '', 'assets');

if ($connection === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Define email and password variables
$email = "";
$password = "";

// Check if email and password are set in the form data
if(isset($_POST['email']) && isset($_POST['password'])) {
    // Retrieve email and password from login form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prevent SQL injection
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);

    // Query to check if email and password exist in the database
    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password' AND status='Verified'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        // Check if any rows were returned
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $type = $row['role'];
            $_SESSION['login'] = true;
            $_SESSION['email'] = $row['email'];
            $_SESSION['type'] = $row['role'];

            switch ($type) {
                case 'Admin':
                    header("Location: ../Code/admin/index.php");
                    exit();
                    break;
                case 'General User':
                    header("Location: home.html");
                    exit();
                    break;
                // Add more cases if needed
            }
        } else {
            echo "Invalid email or password. Please try again.";
        }
    } else {
        echo "ERROR: Could not execute $query. " . mysqli_error($connection);
    }
} else {
    echo "Email and password are required.";
}

mysqli_close($connection);
?>
