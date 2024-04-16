<?php
require_once("includes/setup.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['forename'];
    $sname = $_POST['surname'];;
    $email = $_POST['email'];;
    $password = $_POST['password'];;
    $department = $_POST['department'];;

    if (!empty($fname) && !empty($sname) && !empty($email) && !empty($password) && !empty($department)) {
        $query = "INSERT INTO `users` (`forename`, `surname`, `email`, `password`, `department_id`) VALUES ('$fname', '$sname', '$email', '$password', '$department')";
        
        if (mysqli_query($connection, $query)) {
            header("Location: home.php");
        } else {
            echo "ERROR: Could not able to execute $query. " . mysqli_error($connection);
        }
    
        // Close connection
        mysqli_close($connection);  
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <Title>Register|Bradford Council</Title>
    <link rel="stylesheet" href="/assets/stylesheet.css">
</head>

<body class="main">

    <?php require_once("includes/navbar.php"); ?>

    <div class="log">
        <form action="register.php" method="post">
    <label class="placeholder">Forename</label>
            <input class="log input" type="text" name="forename" maxlength="15"></input>
            <label class="placeholder">Surname</label> 
            <input class="log input" type="text" name="surname" maxlength="15"></input>
            <label class="placeholder">Email</label> 
            <input class="log input" type="email" name="email" maxlength="30"></input>
            <label class="placeholder">Password</label>
            <input class="log input" type="text" name="password" minlength="8"></input>
            <label class="placeholder">Department</label>
            <select class="log input" name="department">
                <option value="" disabled selected>Department</option>
                <!-- For loop for each department and value=ID and name in the option -->
                <option value="1">Housing</option>
                <option value="2">Education and Skills</option>
                <option value="3">Transport and Roads</option>
            </select>
            <button class="log button" type="submit">Register</button>
        </form>

    </div>

    <div class="register-text">
        Created an account? <a href="Login.html">Log in here</a>
    </div>

</body>

<?php require_once("includes/footer.php"); ?>

