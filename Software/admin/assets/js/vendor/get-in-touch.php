<?php

include ('../config.php');
session_start();

//  if(!isset($_SESSION['UID'])){
//     header('Location:/login.php');
//  }
ob_start();
// The ob_start () is a built-in function of PHP to enable the output buffering. If the output buffering is enabled, then all output will be stored in the internal buffer and no output from the script will be sent to the browser. Some other built-in functions are used with ob_start () function.

//why we use buffering?
// data is coming from different resources like:databases,APIs and we want to change this data like:convert it to uppercase ,want to copy some part of data in to a variable and move it into another page,trim a part of data then we use output buffering
?>
<html  lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Tei Enterprises & International Ministries, Inc.</title>
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
                            <h2>Add Contact</h2>
                        </div>
                        <div class='col-md-6 text-right'>
                            <a class='btn btn-success' style='color:white' data-toggle='modal' data-target='#addcontactModal'><i style='color:white' class='fa fa-plus-circle'></i> Add contact</a>
                            <a href='export-contacts.php' class='btn btn-success'><i class='fa fa-download'></i> Download</a>
                        </div>
                    </div>
                    <?php

                    $sql = "SELECT * FROM contact";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        echo "
                            <div class='table-responsive'>
                                <table id='dataTable2' class='table table-hover table-border'>
                                    <thead>
                                        <tr>
                                            <th>Contact ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Inquiry</th>
                                            <th>Message</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        ";

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['CID']}</td>";
                            echo "<td>{$row['firstname']}</td>";
                            echo "<td>{$row['lastname']}</td>";
                            echo "<td>{$row['phone']}</td>";
                            echo "<td>{$row['email']}</td>";
                            echo "<td>{$row['inquiry']}</td>";
                            echo "<td>{$row['msg']}</td>";
                            echo "<td>";
                            echo "<a  data-toggle='modal' data-target='#editModal' onclick='editRecord({$row['CID']});' class='btn btn-info'><i style='color:white' class='fa fa-edit'></i></a>  ";
                            echo "<a href='get-in-touch.php?delete={$row['CID']}' class='btn btn-danger'><i style='color:white' class='fa fa-trash'></i> </a>";
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
                    if (isset($_GET['delete'])) {
                        $delete = $_GET['delete'];
                        $dele = "DELETE FROM contact WHERE CID = $delete";
                        $re = mysqli_query($conn, $dele);
                        if ($re) {
                            echo "<script>location.href='get-in-touch.php'</script>";
                        } else {
                            echo "Error deleting contact: " . mysqli_error($conn);
                        }
                    }
                    ?>
                </div>

            <?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $cid = $_POST["cid"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $inquiry = $_POST["inquiry"];
    $msg = $_POST["msg"];

    $sql = "UPDATE contact SET firstname = '$firstname', lastname = '$lastname', email = '$email', phone = '$phone', inquiry = '$inquiry', msg = '$msg' WHERE CID = $cid";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<script>location.href='get-in-touch.php'</script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    $cid = $_GET['cid'];
    $sql = "SELECT * FROM contact WHERE CID = $cid " ;
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    echo "<div class='col-lg-6 mt-5'>
            <div class='card'>
                <div class='card-body'>
                    <div class='modal fade' id='editModal'>
                        <div class='modal-dialog modal-dialog-centered' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h4>Edit contact Details</h4>
                                    <button type='button' class='close' data-dismiss='modal'><span>&times;</span></button>
                                </div>
                                <div class='modal-body'>
                                    <form method='post'>
                                        <input type='hidden' id='cidInput' name='cid' >
                                        First Name: <input type='text' class='form-control' id='firstnameInput' name='firstname' ><br>
                                        Last Name: <input type='text' class='form-control' id='lastnameInput' name='lastname' ><br>
                                        Email: <input type='email' class='form-control' id='emailInput' name='email' ><br>
                                        Phone: <input type='number' class='form-control' id='phoneInput' name='phone' ><br>
                                        Inquiry: 
                                         <select  name='inquiry' id='inquiryInput' class='form-control' required>
                  <option value=''>Please select type of inquiry</option>
                  <option value='Prayer Request'>Prayer Request</option>
                  <option value='Praise Report/Testimony'>Praise Report/Testimony</option>
                  <option value='General Inquiry'>	General Inquiry</option>
                 

                </select><br>
                                        
                                        Message: <textarea class='form-control' id='msgInput' name='msg'></textarea><br>
                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                        <button type='submit' name='update' class='btn btn-primary'>Save changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>";
}
?>

                </div>

                <div class="modal fade" id="addcontactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add contact</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            <form id="addcontactForm" style="width:300px">
    <label for="firstname">First Name:</label>
    <input type="text" class="form-control" placeholder="Enter First Name" name="firstname" required><br>

    <label for="lastname">Last Name:</label>
    <input type="text" class="form-control" placeholder="Enter Last Name" name="lastname" required><br>

    <label for="email">Email:</label>
    <input type="email" class="form-control" placeholder="Enter Email" name="email" required><br>

    <label for="phone">Phone:</label>
    <input type="number" class="form-control" placeholder="Enter Phone" name="phone" required><br>

    <label for="inquiry">Inquiry:</label>
  
     <select name="inquiry"  class="form-control" required>
                  <option value="">Please select type of inquiry</option>
                  <option value="Prayer Request">Prayer Request</option>
                  <option value="Praise Report/Testimony">Praise Report/Testimony</option>
                  <option value="General Inquiry">	General Inquiry</option>
                 

                </select> <br>

    <label for="msg">Message:</label>
    <textarea class="form-control" placeholder="Enter Message" name="msg" required></textarea><br>

    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-info" onclick="addcontact()">Add Contact</button>
</form>

                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function addcontact() {
                        $.ajax({
                            type: 'POST',
                            url: 'save-contact.php',
                            data: $('#addcontactForm').serialize(),
                            success: function(response) {
                                alert(response);
                                location.reload();
                            },
                            error: function(error) {
                                alert('Error adding contact: ' + error.responseText);
                            }
                        });
                    }
                </script>
               <script>
    function editRecord(cid) {
        $('#editModal').modal('show');
        $.ajax({
            type: 'GET',
            url: 'get-contact.php',
            data: {
                cid: cid
            },
            success: function(response) {
                var record = JSON.parse(response);
                $('#cidInput').val(record['CID']);
                $('#firstnameInput').val(record['firstname']);
                $('#lastnameInput').val(record['lastname']);
                $('#emailInput').val(record['email']);
                $('#phoneInput').val(record['phone']);
                $('#inquiryInput').val(record['inquiry']);
                $('#msgInput').val(record['msg']);
            },
            error: function(error) {
                console.log('Error fetching record details: ' + error);
            }
        });
    }
</script>

            </div>
        </div>
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
   
