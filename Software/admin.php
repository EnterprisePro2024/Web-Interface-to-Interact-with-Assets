<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] == false || $_SESSION['admin'] == false) {
    header("Location: home.php");
 }

   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "assets";
   
   
   $conn1 = new mysqli($servername, $username, $password, $dbname);

ob_start();
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="stylesheet.css">
    <style>
    body {
        font-family: 'Roboto', Arial, sans-serif;
        background-color: #ffffff;
        margin: 0;
        padding: 0;
    }

    .page-container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
    }

    .main-content-inner {
        padding: 0px;
    }

    .col-md-6 h2 {
        text-align: center;
        margin-bottom: 10px;
        color: #006871;
    }

    .btn {
        display: inline-block;
        padding: 8px 16px;
        margin: 5px;
        border: none;
        border-radius: 3px;
        text-decoration: none;
        color: #fff;
        background-color: #007bff;
        cursor: pointer;
    }

    .btn-success {
        background-color: #28a745;
    }

    .btn-danger {
        background-color: #dc3545;
    }

    .btn-warning {
        background-color: #ffc107;
    }

    .btn i {
        margin-right: 5px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 1px; 
        text-align: center; 
        border: 1px solid #dddddd;
    }

    th {
        background-color: #f2f2f2;
        color: #000000;
    }

    .dropdown-menu {
        display: none; 
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0 2px 4px 0 rgba(0,0,0,0.2);
        z-index: 1;
    }

    .dropdown-menu .dropdown-item {
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
        color: #000;
    }

    .dropdown-menu .dropdown-item:hover {
        background-color: #ddd;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .show {
        display: block; 
    }
    </style>
</head>

<body>
<?php require_once("includes/navbar.php"); ?>
    <div class="page-container">
        <div class="main-content-inner">
            <div class="row">
                <div class="col-lg-12 mt-5">
                    <div class='row'>
                        <div class='col-md-6 text-center'>
                            <h2>User Registration Management</h2>
                        </div>
                    </div>
                    <?php
                    $sql = "SELECT  
                    u.forename, 
                    u.surname, 
                    u.email, 
                    u.role, 
                    u.registered_at, 
                    u.status, 
                    d.department
                FROM 
                    users u
                JOIN 
                    departments d ON u.department_id = d.department_id;
                ";
                    $result = mysqli_query($conn1, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        echo "
                            <div class='table-responsive'>
                                <table id='dataTable2' class='table table-hover table-border'>
                                    <thead>
                                        <tr>
                                            <th>Forename</th>
                                            <th>Surname</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Department</th>
                                            <th>Registered At</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['forename']}</td>";
                            echo "<td>{$row['surname']}</td>";
                            echo "<td>{$row['email']}</td>";
                            echo "<td>{$row['role']}</td>";
                            echo "<td>{$row['department']}</td>";
                            echo "<td>{$row['registered_at']}</td>";
                            echo "<td>";

                            if ($row['status'] == 'Verified') {
                                echo "<i style='color:green' class='fa fa-check'></i> ";
                            } elseif ($row['status'] == 'Rejected') {
                                echo "<i style='color:red' class='fa fa-close'></i> ";
                            } elseif ($row['status'] == 'Blocked') {
                                echo "<i style='color:black' class='fa fa-ban'></i> ";
                            }
                            
                            echo "{$row['status']}</td>";
                            echo "<td>"; ?>
                            <div class="dropdown">
                                <button class="btn btn-primary" onclick="toggleDropdown(this)">Action</button>
                                <div class="dropdown-menu" id="dropdownMenu">
                                    <a class="dropdown-item" href='admin.php?action=verify&email=<?php echo $row['email']; ?>'>Verify</a>
                                    <a class="dropdown-item" href='admin.php?action=reject&email=<?php echo $row['email']; ?>'>Reject</a>
                                    <a class="dropdown-item" href='admin.php?action=block&email=<?php echo $row['email']; ?>'>Block</a>
                                </div>
                            </div>
                    <?php
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody></table></div>";
                    } else {
                        echo "No records found.";
                    }
                    ?>
                    <?php
                    if (isset($_GET['action']) && isset($_GET['email'])) {
                        $action = $_GET['action'];
                        $email = $_GET['email'];

                        switch ($action) {
                            case 'verify':
                                $query = "UPDATE users SET status='Verified' WHERE email='$email'";
                                break;
                            case 'reject':
                                $query = "UPDATE users SET status='Rejected' WHERE email='$email'";
                                break;
                            case 'block':
                                $query = "UPDATE users SET status='Blocked' WHERE email='$email'";
                                break;
                            default:
                                
                                break;
                        }

                        if (isset($query)) {
                            $result = mysqli_query($conn1, $query);
                            if ($result) {
                                echo "<script>location.href='admin.php'</script>";
                            } else {
                                echo "Error updating status: " . mysqli_error($conn1);
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php require_once("admin/ALog.php"); ?>
<?php require_once("includes/footer.php"); ?>

<script>
function toggleDropdown(btn) {
    var dropdownMenu = btn.nextElementSibling;
    dropdownMenu.classList.toggle('show');
    document.addEventListener('click', function(event) {
        if (!dropdownMenu.contains(event.target) && event.target !== btn) {
            dropdownMenu.classList.remove('show');
        }
    });
}
</script>

</body>

</html>
