<?php

/*** mysql hostname ***/
$hostname = 'localhost';

/*** mysql username ***/
$username = 'adam';

/*** mysql password ***/
$password = 'YES';

// Initialize variables to hold table data and selected table name
$tableData = [];
$tableName = "";

try {
    $conn = new PDO("mysql:host=$hostname;dbname=assets", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
      // Check if a table has been selected
      if(isset($_POST["table"])) {
        $tableName = $_POST["table"];
        // Fetch data from the selected table
        $stmt = $conn->prepare("SELECT * FROM `$tableName`"); // Enclose table name in backticks
        $stmt->execute();
        $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch(PDOException $e) {
    echo $e->getMessage();
}

?>

<html>
<head>
    <title>Display Table Data</title>
    <style>
        /* Style for table */
        table {
            width: 100%;
            border-collapse: collapse;
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

<h2>Display Table Data</h2>

<!-- Form to select table -->
<form method="post">
    <!-- Dropdown menu to select table -->
    <select name="table">
        <option value="">Select Table</option>
        <?php
        // Loop through each row of the result set and populate the dropdown menu
        $tables_query = "SHOW TABLES";
        $tables_result = $conn->query($tables_query);
        while($row = $tables_result->fetch(PDO::FETCH_ASSOC)) {
            $tableName = $row['Tables_in_assets'];
            echo "<option value='".$tableName."'>".$tableName."</option>";
        }
        ?>
    </select>
    <!-- Submit button to confirm table selection -->
    <input type="submit" value="OK">
</form>

<!-- Display selected table data -->
<div id="tableDataContainer">
    <?php
    // Check if table data is available
    if(!empty($tableData)) {
        // Display table data in an HTML table
        echo "<table>";
        // Display table header
        echo "<tr>";
        foreach($tableData[0] as $column => $value) {
            echo "<th>$column</th>";
        }
        echo "</tr>";
        // Display table rows
        foreach($tableData as $row) {
            echo "<tr>";
            foreach($row as $value) {
                echo "<td>$value</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } elseif ($tableName !== "") {
        echo "No data available in table: $tableName";
    }
    $servername = "localhost";
$username = "root";
$password = "";
$dbname = "assets";

// Create connection
$conn1 = new mysqli($servername, $username, $password, $dbname);
    ?>
</div>

</body>
</html>

