<?php
require_once("includes/setup.php");

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
$query = "SELECT * FROM users WHERE email = '$email' AND password = '$password' AND status='Verified' ";
$result = mysqli_query($connection, $query);

if ($result) {
    // Check if any rows were returned
    if(mysqli_num_rows($result) > 0) {
        $row=mysqli_fetch_assoc($result);
        session_start(); 
        $type=$row['role'];
        $_SESSION['login'] = true;
       
        $_SESSION['email'] = $row['email'];
        $_SESSION['type'] = $row['role'];

        switch ($type) {
            case 'Admin':
                 echo "<script>location.href='../admin/index.php'</script>";
                exit();
                break;
                case 'General User':
                    echo "<script>location.href='home.php'</script>";
                   exit();
                   break;
            // Add more cases if needed
        }
        // Login successful, redirect to Home.html
        //header("Location: Home.html");
        //exit;
    } else {
        // Login failed, redirect to Login.html
     
    }
} else {
    echo "ERROR: Could not able to execute $query. " . mysqli_error($connection);
}

// Close connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <Title>Login|Bradford Council</Title>
    <link rel="stylesheet" href="/assets/stylesheet.css">
</head>

<body class="main">

    <?php require_once("includes/navbar.php"); ?>

    <div class="log">
        <form action="login.php" method="post">
            <label class="placeholder">Email</label>
            <input class="log input" type="email" name="email"/>
            <label class="placeholder">Password</label>
            <input class="log input" type="password" name="password">
            <button class="log button" type="submit">Log In</button>
        </form>

    </div>

    <div class="register-text">
        Don't have an account? <a href="register.php">Register here</a>
    </div>

</body>

<?php require_once("includes/footer.php"); ?>
