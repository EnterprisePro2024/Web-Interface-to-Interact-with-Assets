<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table of Assets</title>
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            background-color: #006871;
        }
        
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #006871;
        }

        form {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
        
    </style>
</head>
<body>
    <?php
/*** mysql hostname ***/
$hostname = 'localhost';

/*** mysql username ***/
$username = 'root';

/*** mysql password ***/
$password = '';

// Initialize variables to hold table data and selected table names
$tableData = [];
$tableNames = [];
try {
    $conn = new PDO("mysql:host=$hostname;dbname=assets", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if tables have been selected
    if(isset($_POST["selected_tables"])) {
        $selectedTables = $_POST["selected_tables"];
        // Fetch data from each selected table
        foreach($selectedTables as $tableName) {
            $stmt = $conn->prepare("SELECT * FROM `$tableName`"); // Enclose table name in backticks
            $stmt->execute();
            $tableData[$tableName] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
} catch(PDOException $e) {
    echo $e->getMessage();
}

?>
<div class="container">
    <h2>Table of Assets</h2>

    <!-- Form to select tables -->
    <form method="post">
        <?php
        // PHP code for generating checkboxes
        try {
            $conn = new PDO("mysql:host=$hostname;dbname=assets", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $tables_query = "SHOW TABLES";
            $tables_result = $conn->query($tables_query);
            while ($row = $tables_result->fetch(PDO::FETCH_ASSOC)) {
                $tableName = $row['Tables_in_assets'];
                if ($tableName != "users") {
                   echo "<input type='checkbox' name='selected_tables[]' value='$tableName'> $tableName<br>";
                }
            }
        } catch(PDOException $e) {
            echo "<p class='error-message'>Error: " . $e->getMessage() . "</p>";
        }
        ?>
        <!-- Submit button to confirm table selection -->
        <input type="submit" value="OK">
    </form>

     <!-- Button to clear all displayed tables -->
     <form method='post'>
        <input type='hidden' name='clear_all_tables'>
        <button type='submit'>Clear All Tables</button>
    </form>

    <!-- Display selected table data -->
    <div id="tableDataContainer">
        <?php
        // PHP code for displaying selected table data
        try {
            if (isset($_POST["selected_tables"])) {
                $selectedTables = $_POST["selected_tables"];
                foreach ($selectedTables as $tableName) {
                    $stmt = $conn->prepare("SELECT * FROM `$tableName`");
                    $stmt->execute();
                    $tableData[$tableName] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }
        } catch(PDOException $e) {
            echo "<p class='error-message'>Error: " . $e->getMessage() . "</p>";
        }

        if (!empty($tableData)) {
            foreach ($tableData as $tableName => $data) {
                echo "<h3>Table: $tableName</h3>";
                if (!empty($data)) {
                    echo "<table>";
                    echo "<tr>";
                    foreach ($data[0] as $column => $value) {
                        echo "<th>$column</th>";
                    }
                    echo "</tr>";
                    foreach ($data as $row) {
                        echo "<tr>";
                        foreach ($row as $value) {
                            echo "<td>$value</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No data available in table: $tableName";
                }
            }
        } else {
            echo "No tables selected.";
        }
        ?>
    </div>

   
</div>

</body>
</html>