<!DOCTYPE html>
<html>
<head>
    <title>Upload CSV File</title>
</head>
<body>

<h2>Upload CSV File</h2>

<form action="upload.php" method="post" enctype="multipart/form-data">
    Select CSV file to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload CSV" name="submit">
</form>

<?php

// MySQL hostname
$hostname = 'localhost';

// MySQL username
$username = 'adam';

// MySQL password
$password = 'YES';

try {
    // Connect to MySQL database
    $conn = new PDO("mysql:host=$hostname;dbname=assets", $username, $password);
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Catch and display any PDO connection errors
    echo $e->getMessage();
}

// Check if the form is submitted
if(isset($_POST["submit"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
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

            // Import CSV data into MySQL database and create a table
            $conn = new mysqli($hostname, $username, $password, "assets");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Create a table based on CSV file structure
            $tableName = "csv_" . date("Ymd_His");
            $sql = "CREATE TABLE IF NOT EXISTS $tableName (id INT AUTO_INCREMENT PRIMARY KEY)";
            if ($conn->query($sql) === TRUE) {
                echo "Table created successfully";
            } else {
                echo "Error creating table: " . $conn->error;
                exit; // Stop execution if table creation fails
            }

            // Read the CSV file and insert data into the table
            $file = fopen($target_file, "r");
            $header = fgetcsv($file); // Get the header row
            fclose($file);

            // Clean column names and replace spaces with underscores
            $columns = array_map(function($column) {
                return str_replace(' ', '_', trim($column));
            }, $header);

            // Prepare the INSERT statement
            $placeholders = rtrim(str_repeat("?, ", count($columns)), ", ");
            $sqlInsert = "INSERT INTO `$tableName` (`" . implode("`, `", $columns) . "`) VALUES ($placeholders)";
            $stmt = $conn->prepare($sqlInsert);
            if ($stmt === false) {
                die("Error preparing statement: " . $conn->error);
            }

            // Read CSV file and insert data into the table
            $file = fopen($target_file, "r");
            // Skip the header row
            fgetcsv($file);
            while (($data = fgetcsv($file)) !== FALSE) {
                // Ensure the number of values matches the number of columns
                if (count($data) != count($columns)) {
                    die("Error: Number of columns in CSV does not match the number of columns in the table");
                }
                $result = $stmt->execute($data);
                if ($result === false) {
                    die("Error inserting data: " . $stmt->error);
                }
            }
            fclose($file);

            $conn->close();

        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

</body>
</html>
