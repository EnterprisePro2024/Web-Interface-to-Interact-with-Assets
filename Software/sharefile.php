<?php
require_once("includes/setup.php");

if (!isset($_SESSION['login']) || $_SESSION['login'] == false) {
    header("Location: login.php");
}
 
$user_id = $_SESSION['user_id'];
$department_id = $_SESSION['department_id'];

// Check if the form is submitted to share files
if (isset($_POST['share'])) {
    $file_id = $_POST['file_id'];
    $department_id = $_POST['department_id'];

    // Store sharing information in the shared_files table
    $insert_query = "INSERT INTO shared_files (file_id, shared_by_user_id, shared_with_department_id) VALUES (?, ?, ?)";
    $stmt_insert = $connection->prepare($insert_query);
    if ($stmt_insert) {
        $stmt_insert->bind_param("iii", $file_id, $user_id, $department_id);
        if ($stmt_insert->execute()) {
            $affected_rows = $stmt_insert->affected_rows;
            if ($affected_rows > 0) {
                 // Set success message session variable
                 $_SESSION['file_shared'] = true;
                // Redirect after successful sharing
                header("Location: sharefile.php"); 
                exit; // Stop execution after redirect
            } 
        } else {
            echo "Error sharing file: " . $stmt_insert->error;
        }
        $stmt_insert->close();
    } else {
        echo "Error preparing sharing statement: " . $connection->error;
    }
} elseif (isset($_POST['share']) && isset($_SESSION['form_submitted'])) {
    // Avoids duplicate submissions 
    header("Location: sharefile.php");
    exit; // Stop execution after redirect
}

// Clears the session variable after the page has loaded
unset($_SESSION['form_submitted']);

// Query to retrieve files uploaded by the user in their department or shared with their department
$query_files = "SELECT file_id, file_name 
                FROM files 
                WHERE (uploaded_by_user_id = ? AND uploaded_by_department_id = ?) 
                    OR file_id IN (SELECT file_id 
                                   FROM shared_files 
                                   WHERE shared_with_department_id = ?)";
$stmt_files = $connection->prepare($query_files);
if ($stmt_files) {
    $stmt_files->bind_param("iii", $user_id, $department_id, $department_id);
    $stmt_files->execute();
    $result_files = $stmt_files->get_result();

    if ($result_files->num_rows > 0) {
        while ($row = $result_files->fetch_assoc()) {
            $files_array[] = $row;
        }
    } 

    $stmt_files->close();
} else {
    echo "Error fetching files: " . $connection->error;
    exit; // Stop execution if there's an error
}


// Query to retrieve departments for selection
$query_departments = "SELECT department_id, department FROM departments WHERE department_id <> ?";
$stmt_departments = $connection->prepare($query_departments);
if ($stmt_departments) {
    $stmt_departments->bind_param("i", $department_id);
    $stmt_departments->execute();
    $result_departments = $stmt_departments->get_result();
    
    $departments = [];
    if ($result_departments->num_rows > 0) {
        while ($row = $result_departments->fetch_assoc()) {
            $departments[] = $row;
        }
    } else {
        echo "No departments available for sharing.";
    }

    $stmt_departments->close();
} else {
    echo "Error fetching departments: " . $connection->error;
    exit; // Stop execution if there's an error
}

// Query to retrieve CSV files shared with the user's department and the department that shared it
$query_shared_csv = "SELECT files.file_name, departments.department AS shared_by_department
                     FROM files
                     INNER JOIN shared_files ON files.file_id = shared_files.file_id
                     INNER JOIN users ON shared_files.shared_by_user_id = users.user_id
                     INNER JOIN departments ON users.department_id = departments.department_id
                     WHERE shared_files.shared_with_department_id = ? AND files.uploaded_by_department_id <> ?
                     ORDER BY files.file_name ASC";

$stmt_shared_csv = $connection->prepare($query_shared_csv);
if ($stmt_shared_csv) {
    $stmt_shared_csv->bind_param("ii", $department_id, $department_id);
    $stmt_shared_csv->execute();
    $result_shared_csv = $stmt_shared_csv->get_result();

    if ($result_shared_csv->num_rows > 0) {
        $shared_csv_files = $result_shared_csv->fetch_all(MYSQLI_ASSOC);
    } else {
        $shared_csv_files = []; // Empty array if no CSV files found
    }

    $stmt_shared_csv->close();
} else {
    echo "Error in preparing SQL statement: " . $connection->error;
}


$connection->close();
?>


<!DOCTYPE html>
<head>
    <title>Share CSV File</title>
    <link rel="stylesheet" href="/assets/stylesheet.css">
    <style>
        /* temporary CSS for forms and shared csv files table - can change and adjust this in the css styelsheet */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }

        select, button {
            width: 100%;
            padding: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #0056b3;
        }
        
    </style>
</head>

<body class="main">
    <?php require_once("includes/navbar.php"); ?>
    <h2>Share CSV File</h2>
    <?php
    // Display "No files available for sharing" message under the file selection form
    if (empty($files_array)) {
        echo "<p>No files available for sharing.</p>";
    }
    ?>
    <form action="sharefile.php" method="post" enctype="multipart/form-data">
    Select CSV File to Share:
    <select name="file_id" id="file_id" required>
    <option value="">Select File</option>
    <?php
        // Display files for selection
        foreach ($files_array as $file) {
            echo "<option value='" . $file["file_id"] . "'>" . $file["file_name"] . "</option>";
        }
        ?>
    </select>
    <br><br><br>
    Select Department to Share With:
    <select name="department_id" id="department_id" required>
    <option value="">Select Department</option>
            <?php
            // Display departments for selection
            foreach ($departments as $dept) {
                echo "<option value='" . $dept["department_id"] . "'>" . $dept["department"] . "</option>";
            }
            ?>
        </select>
    <br><br>
    <input type="submit" name="share" value="Share File">
    <?php
    // Display success message if file sharing was successful
    if (isset($_SESSION['file_shared']) && $_SESSION['file_shared'] === true) {
        echo "<p>File shared successfully!</p>";
        unset($_SESSION['file_shared']); // Clear the session variable
    }
    ?>

</form>

<br>
<h2>CSV Files Shared By Other Departments</h2>
<?php if (!empty($shared_csv_files)) : ?>
        <table>
            <thead>
                <tr>
                    <th>File Name</th>
                    <th>Shared By Department</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($shared_csv_files as $file) : // Displays name of shared file and the department which shared it?>
                    <tr>
                        <td><?php echo $file['file_name']; ?></td>
                        <td><?php echo $file['shared_by_department']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No shared CSV files available for your department.</p>
    <?php endif; ?>
</body>

<?php require_once("includes/footer.php"); ?>