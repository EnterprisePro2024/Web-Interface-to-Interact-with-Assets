<?php

include ('../config.php');
session_start();
if (!isset($_SESSION['UID']) || ($_SESSION['type'] !== 'admin')) {
    header('Location: /login.php');
    exit(); // Ensure script stops executing after redirecting
}
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
      <!-- amcharts css --><script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
     <style>
   .frm_form_field .grecaptcha-badge { 
  display:none;
}
label{
  float:left;
}
.btn {
    width:100%;
}
.overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(
    125deg,
    rgba(0, 0, 0, 0.5),
    rgba(0, 0, 0, 0.5),
    rgba(0, 0, 0, 0.5)
  );
  pointer-events: none; /* Allows interaction with elements behind the overlay */
}
label{
    font-weight:bold;
}
.form-step {
            display: none;
        }

        .current-step {
            display: block;
        }


  </style>
</head>

<body>
  
    <div class="page-container">
        <?php
        include('nav.php');
        ?>
        <br>
         
   <Center>
     
            <div class="row">
                <div class="col-lg-12 mt-5">
                    <div class='row'>
                        <div class='col-md-6'>
                            <h2>Add Prayer</h2>
                        </div>
                        <div class='col-md-6 text-right'>
                     <div class='row'>
    <div class='col'>
        <a class='btn btn-success' style='color:white' data-toggle='modal' data-target='#addcontactModal'><i style='color:white' class='fa fa-plus-circle'></i> Add </a>
    </div>
    <div class='col'>
        <a href='export-anoint-prayer-user.php.php' class='btn btn-success'><i class='fa fa-download'></i> Download</a>
    </div>
</div>
  </div>
                    </div>
<div class="row">
    <div class="col-md-1"></div>
<div class="col-md-10"><br><br><Br>
     <h4 style="float:left"><u> Booked Prayers</u></h4><br><br><Br>
<div class="table-responsive">
    <table id="dataTable2" class="table table-striped table-bordered">
        <thead>
            <tr style='background-color:navy;color:white'>
                <th>Prayer ID</th>
                <th>State</th>
                <th>Country</th>
                <th>Street</th>
                <th>ZIP</th>
                <th>Prayer</th>
                <th>Church</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date Completed</th>
                <th>Single Prayer</th>
                <th>Category</th>
                <th>Notes</th>
                <th>Individual Contact</th>
                <th>Contact First Name</th>
                <th>Contact Last Name</th>
                <th>Contact Email</th>
                <th>Contact Phone</th>
                <th>Action</th>
              
            </tr>
        </thead>
        <tbody>
            <?php
   
            $prayerUser = "SELECT `apid`, `state`, `country`, `street`, `zip`, `pray`, `church`, `fname`, `lname`, `email`, `phone`, `date_completed`, `single-pray`, `category`, `notes`, `inidvidual_contact`, `first_name`, `last_name`, `email_1`, `phone_1`, `UID` FROM `anoint-prayer-user` ";
            $result = mysqli_query($conn, $prayerUser);
            $num = mysqli_num_rows($result);

            if ($num == 0) {
                echo "<tr><td colspan='22'>Nothing</td></tr>";
            } else {
                $counter = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $apid = $row['apid'];
                    $state = $row['state'];
                    $country = $row['country'];
                    $street = $row['street'];
                    $zip = $row['zip'];
                    $pray = $row['pray'];
                    $church = $row['church'];
                    $fname = $row['fname'];
                    $lname = $row['lname'];
                    $email = $row['email'];
                    $phone = $row['phone'];
                    $dateCompleted = $row['date_completed'];
                    $singlePray = $row['single-pray'];
                    $category = $row['category'];
                    $notes = $row['notes'];
                    $individualContact = $row['inidvidual_contact'];
                    $contactFirstName = $row['first_name'];
                    $contactLastName = $row['last_name'];
                    $contactEmail = $row['email_1'];
                    $contactPhone = $row['phone_1'];
                    $uid = $row['UID'];

                    // Fetch username based on UID
                    $usernameQuery = "SELECT `username` FROM `user` WHERE `UID` = '$uid'";
                    $usernameResult = mysqli_query($conn, $usernameQuery);
                    $usernameRow = mysqli_fetch_assoc($usernameResult);
                    $username = $usernameRow['username'];
    // Fetch STREET based on SID
    $usernaQuery = "SELECT * FROM `anointstreet` WHERE `ASID` = '$street'";
    $usernaResult = mysqli_query($conn, $usernaQuery);
    $snameRow = mysqli_fetch_assoc($usernaResult);
    $streetname= $snameRow['Street'];
     $streetZIP= $snameRow['zipcode'];
    $usernamQuery = "SELECT * FROM `anointcountry` WHERE `COID` = '$country'";
    $usernamResult = mysqli_query($conn, $usernamQuery);
    $cnameRow = mysqli_fetch_assoc($usernamResult);
    $countryname = $cnameRow['name'];
                    $counter++;
                    ?>
                    <tr>
                        <td><?php echo $apid ?></td>
                        <td><?php echo $state ?></td>
                        <td><?php echo $countryname ?></td>
                        <td><?php echo $streetname.$streetZIP ?></td>
                        <td><?php echo $zip ?></td>
                        <td><?php echo $pray ?></td>
                        <td><?php echo $church ?></td>
                        <td><?php echo $fname ?></td>
                        <td><?php echo $lname ?></td>
                        <td><?php echo $email ?></td>
                        <td><?php echo $phone ?></td>
                        <td><?php echo $dateCompleted ?></td>
                        <td><?php echo $singlePray ?></td>
                        <td><?php echo $category ?></td>
                        <td><?php echo $notes ?></td>
                        <td><?php echo $individualContact ?></td>
                        <td><?php echo $contactFirstName ?></td>
                        <td><?php echo $contactLastName ?></td>
                        <td><?php echo $contactEmail ?></td>
                        <td><?php echo $contactPhone ?></td>
                  <?php      echo "<td>";
       
        echo "<a  data-toggle='modal' data-target='#editModal' onclick='editRecord({$row['apid']});' class='btn btn-info'><i style='color:white' class='fa fa-edit'></i></a>  ";
        echo "<a href='anoint-prayer-point-user.php?delete={$row['apid']}' class='btn btn-danger'><i style='color:white' class='fa fa-trash'></i> </a>";
        echo "</td>";  ?>
                 
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>
<?php
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $dele = "DELETE FROM anoint-prayer-user WHERE apid = $delete"; // Fix the DELETE query
    $re = mysqli_query($conn, $dele);
    if ($re) {
        echo "<script>location.href='anoint-prayer-point-user.php'</script>";
    } else {
        echo "Error deleting event: " . mysqli_error($conn);
    }
}
?>
</div>
 <div class="col-md-1"></div>
 </div>

  </center><?php
// Assuming you've already established your database connection ($conn)

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Update record
    // Validate and sanitize input data as needed
    $apid = $_POST["apid"];
    $state = $_POST["state1"];
    $country = $_POST["country"];
    $street = $_POST["street"];
    $zip = $_POST["zip"];
    $pray = $_POST["pray"];
    $church = $_POST["church"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $dateCompleted = $_POST["date_completed"];
    $singlePray = $_POST["single_pray"];
    $category = $_POST["category"];
    $notes = $_POST["notes"];
    $individualContact = $_POST["individual_contact"];
    $contactFirstName = $_POST["contact_first_name"];
    $contactLastName = $_POST["contact_last_name"];
    $contactEmail = $_POST["contact_email"];
    $contactPhone = $_POST["contact_phone"];
    $uid = $_POST["uid"];

    // Update the record in the 'anoint-prayer-user' table
    $sql = "UPDATE `anoint-prayer-user`
            SET state = '$state', 
                country = '$country', 
                street = '$street', 
                zip = '$zip', 
                pray = '$pray', 
                church = '$church', 
                fname = '$fname', 
                lname = '$lname', 
                email = '$email', 
                phone = '$phone', 
                date_completed = '$dateCompleted', 
                 `single-pray` = '$singlePray', 
                category = '$category', 
                notes = '$notes', 
                inidvidual_contact = '$individualContact', 
                first_name = '$contactFirstName', 
                last_name = '$contactLastName', 
                email_1 = '$contactEmail', 
                phone_1 = '$contactPhone' 
            WHERE apid = $apid";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<script>location.href='anoint-prayer-point-user.php'</script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} 
   
?>
<script>
    function editRecord(eid) {
        // Assuming 'editModal' is the ID of your modal
        $('#editModal').modal('show');

        // Fetch the record details using AJAX
        $.ajax({
            type: 'GET',
            url: 'get-street.php',
            data: { 'eid': eid },
            success: function(response) {
                // Parse the JSON response or handle it based on your data format
                var record = JSON.parse(response);
                // Set the values in the form fields
                $('#apidInput').val(record['apid']);  // Change 'data' to 'record'
                $('#stateInput').val(record['state']);
                $('#countrySelect').val(record['country']); // Change to country name
                $('#streetInput').val(record['street']); // Change to street name
                $('#zipInput').val(record['zip']);
                $('#prayInput').val(record['pray']);
                $('#churchInput').val(record['church']);
                $('#fnameInput').val(record['fname']);
                $('#lnameInput').val(record['lname']);
                $('#emailInput').val(record['email']);
                $('#phoneInput').val(record['phone']);
                $('#dateCompletedInput').val(record['date_completed']);
                $('#singlePrayInput').val(record['single-pray']);
                $('#categoryInput').val(record['category']);
                $('#notesInput').val(record['notes']);
                $('#individualContactInput').val(record['inidvidual_contact']);
                $('#contactFirstNameInput').val(record['first_name']);
                $('#contactLastNameInput').val(record['last_name']);
                $('#contactEmailInput').val(record['email_1']);
                $('#contactPhoneInput').val(record['phone_1']);
            },
            error: function(error) {
                console.log('Error fetching record details: ' + error);
            }
        });
    }
</script>
<div class='modal fade' id='editModal'>
            <div class='modal-dialog modal-dialog-centered' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h4>Edit Details</h4>
                        <button type='button' class='close' data-dismiss='modal'><span>&times;</span></button>
                    </div>
                    <div class='modal-body'>
                       <form method='post'>
    <input type='hidden' id='apidInput' name='apid' >
    State:
    <select name='state1' id='stateInput' class='form-control'>
    <option value='' disabled>Select a state</option>
    <option value='Alabama' disabled>Alabama</option>
    <option value='Alaska' disabled>Alaska</option>
    <option value='Arizona' disabled>Arizona</option>
    <option value='Arkansas' disabled>Arkansas</option>
    <option value='California' disabled>California</option>
    <option value='Colorado' disabled>Colorado</option>
    <option value='Connecticut' disabled>Connecticut</option>
    <option value='Delaware' disabled>Delaware</option>
    <option value='Florida' disabled>Florida</option>
    <option value='Georgia' disabled>Georgia</option>
    <option value='Hawaii' disabled>Hawaii</option>
    <option value='Idaho' disabled>Idaho</option>
    <option value='Illinois' disabled>Illinois</option>
    <option value='Indiana' disabled>Indiana</option>
    <option value='Iowa' disabled>Iowa</option>
    <option value='Kansas' disabled>Kansas</option>
    <option value='Kentucky' disabled>Kentucky</option>
    <option value='Louisiana' disabled>Louisiana</option>
    <option value='Maine' disabled>Maine</option>
    <option value='Maryland' disabled>Maryland</option>
    <option value='Massachusetts' disabled>Massachusetts</option>
    <option value='Michigan' disabled>Michigan</option>
    <option value='Minnesota' disabled>Minnesota</option>
    <option value='Mississippi' disabled>Mississippi</option>
    <option value='Missouri'>Missouri</option>
    <option value='Montana' disabled>Montana</option>
    <option value='Nebraska' disabled>Nebraska</option>
    <option value='Nevada' disabled>Nevada</option>
    <option value='New Hampshire' disabled>New Hampshire</option>
    <option value='New Jersey' disabled>New Jersey</option>
    <option value='New Mexico' disabled>New Mexico</option>
    <option value='New York' disabled>New York</option>
    <option value='North Carolina' disabled>North Carolina</option>
    <option value='North Dakota' disabled>North Dakota</option>
    <option value='Ohio' disabled>Ohio</option>
    <option value='Oklahoma' disabled>Oklahoma</option>
    <option value='Oregon' disabled>Oregon</option>
    <option value='Pennsylvania' disabled>Pennsylvania</option>
    <option value='Rhode Island' disabled>Rhode Island</option>
    <option value='South Carolina' disabled>South Carolina</option>
    <option value='South Dakota' disabled>South Dakota</option>
    <option value='Tennessee' disabled>Tennessee</option>
    <option value='Texas' disabled>Texas</option>
    <option value='Utah' disabled>Utah</option>
    <option value='Vermont' disabled>Vermont</option>
    <option value='Virginia' disabled>Virginia</option>
    <option value='Washington' disabled>Washington</option>
    <option value='West Virginia' disabled>West Virginia</option>
    <option value='Wisconsin' disabled>Wisconsin</option>
    <option value='Wyoming' disabled>Wyoming</option>
</select>
<br>
<select name='country' class='form-control' id='ecountrySelect'>
    <option value=''>Select County</option>
    <option value='2'>City of Saint Louis</option>
    <option value='3'>Unincorporated St, Louis County</option>
    <option value='1'>Florissant</option>
    <option value='4'>Hazelwood</option>
</select>
<label id='selectedStreetLabel'>Select Street</label>
<div id='estreetContainer'></div>

<!-- JavaScript for handling AJAX request -->
<script>
    $(document).ready(function () {
        // Event listener for country selection change
        $('#ecountrySelect').change(function () {
            var selectedCountry = $(this).val();

            // Make an AJAX request to get streets for the selected country
            $.ajax({
                url: 'get_streets.php',
                type: 'POST',
                data: { country: selectedCountry },
                success: function (data) {
                    // Update the street container with the retrieved data
                    $('#estreetContainer').html(data);

                    // Get the selected street name from the input
                    var selectedStreetName = $('#street').val();

                    // Update the label with the selected street name
                    $('#selectedStreetLabel').text(selectedStreetName);
                },
                error: function () {
                    alert('Error fetching streets.');
                }
            });
        });
    });
</script>
<br>
    ZIP: <input type='text' class='form-control' id='zipInput' name='zip'><br>
   Pray:  <select name='pray' id='prayInput' class='form-control'>
      <option value=''>Select option</option>
									<option value='Yes'>Yes</option>
									<option value='No'>No</option>
									
									
      </select>
    
    Church: <input type='text' class='form-control' id='churchInput' name='church' ><br>
    First Name: <input type='text' class='form-control' id='fnameInput' name='fname' ><br>
    Last Name: <input type='text' class='form-control' id='lnameInput' name='lname' ><br>
    Email: <input type='email' class='form-control' id='emailInput' name='email' ><br>
    Phone: <input type='text' class='form-control' id='phoneInput' name='phone' ><br>
    Date Completed: <input type='date' class='form-control' id='dateCompletedInput' name='date_completed'><br>
    Single Pray: 
     <select class='form-control' id='singlePrayInput' name='single_pray'>
      <option value=''>Select option</option>
									<option value='Yes'>Yes</option>
									<option value='No'>No</option>
									
									
      </select><br>
     Category:  <select class='form-control' id='categoryInput' name='category'>
     <option value='Select Category'>Select Category</option>
<option value='Salvation'>Salvation</option>
<option value='Marital Challenge'>Marital Challenge</option>
<option value='Financial Challenge'>Financial Challenge</option>
<option value='Family Challenge'>Family Challenge</option>
<option value='Job Challenge'>Job Challenge</option>
<option value='Other. '>Other. </option>


      </select>
   
    Notes: <input type='text' class='form-control' id='notesInput' name='notes' ><br>
    Individual Contact: 
     <select class='form-control' id='individualContactInput' name='individual_contact'>
      <option value=''>Select option</option>
									<option value='Yes'>Yes</option>
									<option value='No'>No</option>
									
									
      </select><br>
    Contact First Name: <input type='text' class='form-control' id='contactFirstNameInput' name='contact_first_name' ><br>
    Contact Last Name: <input type='text' class='form-control' id='contactLastNameInput' name='contact_last_name' ><br>
    Contact Email: <input type='email' class='form-control' id='contactEmailInput' name='contact_email' ><br>
    Contact Phone: <input type='text' class='form-control' id='contactPhoneInput' name='contact_phone' ><br>
    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
    <button type='submit' name='update' class='btn btn-primary'>Save changes</button>
</form>

                    </div>
                </div>
            </div>
        </div>

         
                <div class="modal fade" id="addcontactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Book Prayer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
              
<form id="multiStepForm"  method="post" autocomplete="off">
    <!-- Step 1: Select State -->
    <div class="form-step current-step" id="step1">
        <label for="form-field-name">Select State:</label>
        <select name="state" class="form-control">
    <option value="" disabled>Select a state</option>
    <option value="Alabama" disabled>Alabama</option>
    <option value="Alaska" disabled>Alaska</option>
    <option value="Arizona" disabled>Arizona</option>
    <option value="Arkansas" disabled>Arkansas</option>
    <option value="California" disabled>California</option>
    <option value="Colorado" disabled>Colorado</option>
    <option value="Connecticut" disabled>Connecticut</option>
    <option value="Delaware" disabled>Delaware</option>
    <option value="Florida" disabled>Florida</option>
    <option value="Georgia" disabled>Georgia</option>
    <option value="Hawaii" disabled>Hawaii</option>
    <option value="Idaho" disabled>Idaho</option>
    <option value="Illinois" disabled>Illinois</option>
    <option value="Indiana" disabled>Indiana</option>
    <option value="Iowa" disabled>Iowa</option>
    <option value="Kansas" disabled>Kansas</option>
    <option value="Kentucky" disabled>Kentucky</option>
    <option value="Louisiana" disabled>Louisiana</option>
    <option value="Maine" disabled>Maine</option>
    <option value="Maryland" disabled>Maryland</option>
    <option value="Massachusetts" disabled>Massachusetts</option>
    <option value="Michigan" disabled>Michigan</option>
    <option value="Minnesota" disabled>Minnesota</option>
    <option value="Mississippi" disabled>Mississippi</option>
    <option value="Missouri">Missouri</option>
    <option value="Montana" disabled>Montana</option>
    <option value="Nebraska" disabled>Nebraska</option>
    <option value="Nevada" disabled>Nevada</option>
    <option value="New Hampshire" disabled>New Hampshire</option>
    <option value="New Jersey" disabled>New Jersey</option>
    <option value="New Mexico" disabled>New Mexico</option>
    <option value="New York" disabled>New York</option>
    <option value="North Carolina" disabled>North Carolina</option>
    <option value="North Dakota" disabled>North Dakota</option>
    <option value="Ohio" disabled>Ohio</option>
    <option value="Oklahoma" disabled>Oklahoma</option>
    <option value="Oregon" disabled>Oregon</option>
    <option value="Pennsylvania" disabled>Pennsylvania</option>
    <option value="Rhode Island" disabled>Rhode Island</option>
    <option value="South Carolina" disabled>South Carolina</option>
    <option value="South Dakota" disabled>South Dakota</option>
    <option value="Tennessee" disabled>Tennessee</option>
    <option value="Texas" disabled>Texas</option>
    <option value="Utah" disabled>Utah</option>
    <option value="Vermont" disabled>Vermont</option>
    <option value="Virginia" disabled>Virginia</option>
    <option value="Washington" disabled>Washington</option>
    <option value="West Virginia" disabled>West Virginia</option>
    <option value="Wisconsin" disabled>Wisconsin</option>
    <option value="Wyoming" disabled>Wyoming</option>
</select>
<br>
        <button type="button" class="btn btn-warning" onclick="nextStep()">Next</button>
        <br>
    </div>

    <!-- Step 2: Additional Fields -->
    <div class="form-step" id="step2">
        <label for="additional-field" >Select County</label>
        <select name="country" class="form-control" id="countrySelect">
        <option value="">Select County</option>
          <option value="2">City of Saint Louis</option>
          <option value="3">Unincorporated St, Louis County</option>
          <option value="1">Florissant</option>
          <option value="4">Hazelwood</option>
      </select>
      <label>Select Street </label>
   
      
<!-- Display streets here -->
<div id="streetContainer"></div>


<!-- JavaScript for handling AJAX request -->
<script>
    $(document).ready(function () {
        // Event listener for country selection change
        $("#countrySelect").change(function () {
            var selectedCountry = $(this).val();

            // Make an AJAX request to get streets for the selected country
            $.ajax({
                url: 'get_streets.php',
                type: 'POST',
                data: { country: selectedCountry },
                success: function (data) {
                    // Update the street container with the retrieved data
                    $("#streetContainer").html(data);
                },
                error: function () {
                    alert('Error fetching streets.');
                }
            });
        });
    });
</script>
<br><br>
  <div class="d-flex">
  <button type="button" class="btn btn-warning" onclick="prevStep()">Previous</button>
  <button type="button" class="btn btn-warning ml-2" onclick="nextStep()">Next</button>
</div>

  </div>
  <div class="form-step" id="step3">
  <label>Did you pray for and anoint this street?</label><Br> <Br>
    <input type="radio" name="prepray"  style="float:left" value="Yes"><label><b> Yes</b></label> <br><br>
    <input type="radio" name="prepray" style="float:left" value="No"><label><b> No</b></label> <br><br>
    
 <div class="d-flex">
  <button type="button" class="btn btn-warning" onclick="prevStep()">Previous</button>
  <button type="button" class="btn btn-warning ml-2" onclick="nextStep()">Next</button>
</div>


  </div>
  
  <div class="form-step" id="step4">
  <label>CHURCH/COMMUNITY ORGANIZATION </label>
    <input type="text" name="churches" class="form-control" placeholder="CHURCH/COMMUNITY ORGANIZATION "> 
    <label>FIRST NAME 
 </label>
    <input type="text" name="fname" class="form-control" placeholder="First Name"> 
    <label>Last NAME 
 </label>
    <input type="text" name="lname" class="form-control" placeholder="Last Name"> 
    <label>EMAIL ADDRESS 
 </label>
    <input type="email" name="email" class="form-control" placeholder="EMAIL ADDRESS "> 
    <label>Phone Number 
 </label>
    <input type="number" name="phone" class="form-control" placeholder="Phone Number "> 
 
    <label>ZIP CODE ASSIGNED
 </label>
    <input type="number" name="zip" class="form-control" placeholder="0000 "> 
 
    <label>Date Completed
 </label>
    <input type="date" name="date" class="form-control" > 
 <br>
    <label>Did you encounter an individual to pray for while out? 
 </label> <br>
  <select name="pray" class="form-control">
      <option value="">Select option</option>
									<option value="Yes">Yes</option>
									<option value="No">No</option>
									
									
      </select>
   
     <label>Select Category
 </label>
      <select name="category" class="form-control">
      <option value="Select Category">Select Category</option>
									<option value="Salvation">Salvation</option>
									<option value="Marital Challenge">Marital Challenge</option>
									<option value="Financial Challenge">Financial Challenge</option>
									<option value="Family Challenge">Family Challenge</option>
									<option value="Job Challenge">Job Challenge</option>
									<option value="Other. ">Other. </option>
									<option value=""></option>
      </select>
      <label>Add Notes
 </label>
    <input type="text" name="notes" class="form-control" placeholder="Notes"> 
     <Br>
     <div class="d-flex">
  <button type="button" class="btn btn-warning" onclick="prevStep()">Previous</button>
  <button type="button" class="btn btn-warning ml-2" onclick="nextStep()">Next</button>
</div>
  </div>
  <div class="form-step" id="step5">
  
 <label>Does the individual agree to be contacted? </label>
 <select name="contacted" class="form-control">
      <option value="">Select option</option>
									<option value="Yes">Yes</option>
									<option value="No">No</option>
									
      </select> 
      <Br>
     <div class="d-flex">
  <button type="button" class="btn btn-warning" onclick="prevStep()">Previous</button>
  <button type="button" class="btn btn-warning ml-2" onclick="nextStep()">Next</button>
</div>
  </div>
  <div class="form-step" id="step6">

    
  <label>First Name</label>
      <input type="text" name="firstname"  class="form-control">
      <label>Last Name</label>
      <input type="text" name="lastname" class="form-control">
      <label>Email Address</label>
      <input type="email" name="email_contact" class="form-control">
      <label>Phone Number</label>
      <input type="number" name="phoneno" class="form-control">
      <br>
      <div class="d-flex">
  <button type="button" class="btn btn-warning" onclick="prevStep()">Previous</button>
  <button type="submit" name="add" class="btn btn-warning ml-2">Submit</button>
</div>

  </div>
        
       
   
  </form>
                            </div>
                        </div>
                    </div>
                </div>


<script>
    let currentStep = 1;
    
    function nextStep() {
        document.getElementById(`step${currentStep}`).classList.remove('current-step');
        currentStep++;
        document.getElementById(`step${currentStep}`).classList.add('current-step');
    }

    function prevStep() {
        document.getElementById(`step${currentStep}`).classList.remove('current-step');
        currentStep--;
        document.getElementById(`step${currentStep}`).classList.add('current-step');
    }
</script>

  
<script>
    function multiStepForm() {
        // Handle form submission via AJAX
        $.ajax({
            type: 'POST',
            url: 'save-street.php', // Adjust the URL based on your file structure
            data: $('#multiStepForm').serialize(),
            success: function(response) {
                // Handle the success response (e.g., show a message)
                alert(response);
                // You may want to reload or update the event list after a successful addition
                location.reload();
            },
            error: function(error) {
                // Handle the error response (e.g., show an error message)
                alert('Error adding event: ' + error.responseText);
            }
        });
    }
</script>


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
   
