<?php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "assets";
   
   // Create connection
   $conn1 = new mysqli($servername, $username, $password, $dbname);
session_start();

ob_start();
?>
<html  lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
      <!-- amcharts css -->

    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
  
    <div class="page-container">
        <?php
        include('nav.php');
        ?>
        <br>
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

           
    <?php
    include('footer.php');
    ?>

    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>
   
