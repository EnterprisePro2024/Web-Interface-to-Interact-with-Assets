<?php
require_once("includes/setup.php");

$stmt = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['forename'];
    $sname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $department = isset($_POST['department']) ? $_POST['department'] : null;

    
    $query = "SELECT department_id FROM departments WHERE department = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "s", $department);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $department_id = $row['department_id'];

        if (!empty($fname) && !empty($sname) && !empty($email) && !empty($password) && !empty($department) && $department !== 'Department') {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            
            $query = "INSERT INTO `users` (`forename`, `surname`, `email`, `password`, `department_id`) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "ssssi", $fname, $sname, $email, $hashed_password, $department_id);

            try {
                if (mysqli_stmt_execute($stmt)) {
                    header("Location: home.php");
                    exit();
                } else {
                    echo "ERROR: Could not execute query.";
                }
            } catch (mysqli_sql_exception $e) {
                if ($e->getCode() === 1062) {
                    $_SESSION['error'] = "Email address already exists.";
                } else {
                    echo "An error occurred: " . $e->getMessage();
                }
            }
        } else {
            $_SESSION['error'] = "Invalid email format";
        }
    } else {
        $_SESSION['error'] = "Department not found in the database.";
    }
}

if ($stmt !== null) {
    mysqli_stmt_close($stmt);
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register | Bradford Council</title>
    <link rel="stylesheet" href="stylesheet.css">
    <style>
        .error-banner {
            background-color: #ffcccc;
            color: red;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body class="main">
    <?php require_once("includes/navbar.php"); ?>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['error'])) {
        echo "<div class='error-banner'>{$_SESSION['error']}</div>";
        unset($_SESSION['error']); 
    }
    ?>

    <div class="log">
        <form action="register.php" method="post">
            <label class="placeholder">Forename</label>
            <input class="log input" type="text" name="forename" maxlength="15"></input>
            <label class="placeholder">Surname</label>
            <input class="log input" type="text" name="surname" maxlength="15"></input>
            <label class="placeholder">Email</label>
            <input class="log input" type="email" name="email" maxlength="30"></input>
            <label class="placeholder">Password</label>
            <input class="log input" type="password" name="password" minlength="8"></input>
            <label class="placeholder">Department</label>
            <select class="log input" name="department">
                <option value="" disabled selected>Department</option>
                <option value="Housing">Housing</option>
                <option value="Education and Skills">Education and Skills</option>
                <option value="Transport and Roads">Transport and Roads</option>
            </select>
            <button class="log button" type="submit">Register</button>
        </form>
    </div>

    <div class="register-text">
        Created an account? <a href="Login.php">Log in here</a>
    </div>

    <?php require_once("includes/footer.php"); ?>

</body>

</html>
