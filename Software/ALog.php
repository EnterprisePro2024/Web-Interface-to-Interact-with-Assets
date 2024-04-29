<?php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "assets";
   
   // Create connection
   $conn1 = new mysqli($servername, $username, $password, $dbname);

?>
<html  lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Activity Log|Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="../assets/stylesheet.css">
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
            padding: 20px;
        }

        .col-md-6 h2{
            text-align: center;
            margin-bottom: 10px;
            color: 006871;

        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 50px;
        }

        th,
        td {
            padding: 5px;
            text-align: center;
            border: 1px solid #dddddd;
        }

        th {
            background-color: #f2f2f2;
            color: #000000;
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
    <div class="page-container">
        <div class="main-content-inner">
            <div class="row">
                <div class="col-lg-12 mt-5">
                    <div class='row'>
                        <div class='col-md-6 text-center'>
                            <h2>Activity Log</h2>
                        </div>
                    </div>
                    <?php
                    $sql = "SELECT  
                    u.forename, 
                    u.surname, 
                    u.user_id, 
                    f.file_name,
                    f.uploaded_at,
                    s.shared_with_department_id
                FROM 
                    users u
                JOIN 
                    files f ON f.uploaded_by_user_id = u.user_id
                JOIN 
                    shared_files s ";

                    $result = mysqli_query($conn1, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        echo "
                            <div class='table-responsive'>
                                <table id='dataTable2' class='table table-hover table-border'>
                                    <thead>
                                        <tr>
                                            <th>Forename</th>
                                            <th>Surname</th>
                                            <th>User Id</th>
                                            <th>File Name</th>
                                            <th>Sent to department Name</th>
                                            <th>Timestamp</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['forename']}</td>";
                            echo "<td>{$row['surname']}</td>";
                            echo "<td>{$row['user_id']}</td>";
                            echo "<td>{$row['file_name']}</td>";
                            if ($row['shared_with_department_id'] == 1){
                                echo "<td>Housing</td>";
                            }
                            if ($row['shared_with_department_id'] == 2){
                                echo "<td>Transport and Roads</td>";
                            }
                            if ($row['shared_with_department_id'] == 3){
                                echo "<td>Education and Skills</td>";
                            }
                            echo "<td>{$row['uploaded_at']}</td>";
                            
                            ?>
                    <?php
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody></table></div>";
                    } else {
                        echo "No records found.";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    </body>
    </html>
