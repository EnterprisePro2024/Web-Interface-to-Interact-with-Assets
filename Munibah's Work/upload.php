<?php
require_once("setup.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] == false) {
    header("Location: login.php");
}

try {
    // Connect to the database
    $conn = $connection;
    // Check if the form is submitted
    if(isset($_POST["submit"])) {
        // File upload settings
        $current_dir = str_replace('\\', '/', __DIR__);
        $target_dir = "/uploads/";
        $target_file = $current_dir . $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the uploaded file is a CSV file
        if($fileType != "csv") {
            echo "Sorry, only CSV files are allowed.";
            $uploadOk = 0;
        }

        // Check if the file upload was successful
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file ". basename($_FILES["fileToUpload"]["name"]). " has been uploaded.";

                // Read the CSV file and insert data into the table
                $file = fopen($target_file, "r");
                $header = fgetcsv($file); // Get the header row

                // Clean column names and replace spaces with underscores
                $columns = array_map(function($column) {
                    return str_replace(' ', '_', trim($column));
                }, $header);

                // Prepare the table name
                $fileNameWithoutExtension = pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_FILENAME);
                $tableName = str_replace(' ', '_', $fileNameWithoutExtension);

                // Create the table if it doesn't exist
                $sqlCreateTable = "CREATE TABLE IF NOT EXISTS `$tableName` (";
                foreach ($columns as $column) {
                    $sqlCreateTable .= "`$column` VARCHAR(255), ";
                }
                $sqlCreateTable = rtrim($sqlCreateTable, ", ") . ")";
                if ($conn->query($sqlCreateTable) === TRUE) {
                    echo "Table created successfully";
                } else {
                    echo "Error creating table: " . $conn->error;
                }

                // Prepare the INSERT statement
                $placeholders = rtrim(str_repeat("?, ", count($columns)), ", ");
                $sqlInsert = "INSERT INTO `$tableName` (`" . implode("`, `", $columns) . "`) VALUES ($placeholders)";
                $stmt = $conn->prepare($sqlInsert);
                if ($stmt === false) {
                    die("Error preparing statement: " . $conn->error);
                }
                
                // Read CSV file and insert data into the table
                fgetcsv($file); // Skip the header row
                while (($data = fgetcsv($file)) !== FALSE) {
                    if (count($data) != count($columns)) {
                        die("Error: Number of columns in CSV does not match the number of columns in the table");
                    }

                    if (!$stmt->bind_param(str_repeat("s", count($data)), ...$data)) {
                        die("Error binding parameters: " . $stmt->error);
                    }

                    if (!$stmt->execute()) {
                        die("Error inserting data: " . $stmt->error);
                    }
                }

                fclose($file);
                $conn = null;

            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
} catch(PDOException $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<head>
    <title>Upload CSV File</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>

<body class="main">
    <?php require_once("navbar.php"); ?>
    <h2>Upload CSV File</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
    Select CSV file to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload CSV" name="submit">
</form>
</body>

<?php require_once("footer.php"); ?>