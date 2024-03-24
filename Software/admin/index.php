<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] == false || $_SESSION['admin'] == false) {
    header("Location: /home.php");
 }

   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "assets";
   
   // Create connection
   $conn1 = new mysqli($servername, $username, $password, $dbname);


ob_start();
?>
<html  lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/stylesheet.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .page-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .main-content-inner {
            padding: 20px;
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
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        .fa {
            font-size: 18px;
            margin-right: 5px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
<?php require_once("../includes/navbar.php"); ?>
    <div class="page-container">
        <div class="main-content-inner">
            <div class="row">
                <div class="col-lg-12 mt-5">
                    <div class='row'>
                        <div class='col-md-6'>
                            <h2>Add Users</h2>
                        </div>
                        <div class='col-md-6 text-right'>
                            <a href='#' class='btn btn-success'><i class='fa fa-download'></i> Download</a>
                        </div>
                    </div>
                    <?php


                    $sql = "SELECT * FROM users";
                    $result = mysqli_query($conn1, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        echo "
                            <div class='table-responsive'>
                                <table id='dataTable2' class='table table-hover table-border'>
                                    <thead>
                                        <tr>
                                         
                                            <th>Forename</th>
                                            
                                            <th>Surname</th>
                                            <th>email</th>
                                            <th>password</th>
                                            <th>role</th>
                                            <th>department</th>
                                            <th>registered_at</th>
                                            <th>status	</th>
                                            					

                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        ";

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            		
                            
                            echo "<td>{$row['forename']}</td>";
                            echo "<td>{$row['surname']}</td>";
                            echo "<td>{$row['email']}</td>";
                            echo "<td>{$row['password']}</td>";

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
                           
                            echo "<td>";
                           echo "<a href='index.php?verify={$row['email']}' class='btn btn-success'><i style='color:white' class='fa fa-check'></i> Verifiy User </a>
                           <a href='index.php?reject={$row['email']}' class='btn btn-danger'><i style='color:white' class='fa fa-close'></i>Reject </a>
                           <a href='index.php?block={$row['email']}' class='btn btn-warning'><i style='color:white' class='fa fa-ban'></i>Block</a>";
                            echo "</td>";
                            echo "</tr>";
                        }

                        echo "
                                    </tbody>
                                </table>
                            </div>";
                    } else {
                        echo "No records found.";
                    }

                    ?>

                    <?php
                    if (isset($_GET['verify'])) {
                        $verfiy = $_GET['verify'];
                        $vq = "update  users set status='Verified' WHERE email = '$verfiy' ";
                        $re = mysqli_query($conn1, $vq);
                        if ($re) {
                            echo "<script>location.href='index.php'</script>";
                        } else {
                            echo "Error update status of contact: " . mysqli_error($conn);
                        }
                    }
                    if (isset($_GET['reject'])) {
                        $reject = $_GET['reject'];
                        $vq = "update  users set status='Rejected' WHERE email = '$reject' ";
                        $re = mysqli_query($conn1, $vq);
                        if ($re) {
                            echo "<script>location.href='index.php'</script>";
                        } else {
                            echo "Error update status of contact: " . mysqli_error($conn);
                        }
                    }
                    if (isset($_GET['block'])) {
                        $block = $_GET['block'];
                        $vq = "update  users set status='Blocked' WHERE email = '$block' ";
                        $re = mysqli_query($conn1, $vq);
                        if ($re) {
                            echo "<script>location.href='index.php'</script>";
                        } else {
                            echo "Error update status of contact: " . mysqli_error($conn);
                        }
                    }
                    ?>
                </div>

      

</body>

<?php require_once("../includes/footer.php"); ?>
</html>

