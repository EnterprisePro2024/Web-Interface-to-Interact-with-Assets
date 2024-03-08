<?php

/*** mysql hostname ***/
$hostname = 'localhost';

/*** mysql username ***/
$username = 'adam';

/*** mysql password ***/
$password = 'YES';

try {
    $conn = new PDO("mysql:host=$hostname;dbname=assets", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo $e->getMessage();
}

// Check if a table has been selected
if(isset($_GET["table"])) {
    $tableName = $_GET["table"];
    // Fetch data from the selected table
    $stmt = $conn->prepare("SELECT * FROM $tableName");
    $stmt->execute();
    $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
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

<!-- Dropdown menu to select table -->
<select id="tableSelect" onchange="showTableData()">
    <option value="">Select Table</option>
    <?php
    // Loop through each row of the result set and populate the dropdown menu
    $tables_query = "SHOW TABLES";
    $tables_result = $conn->query($tables_query);
    while($row = $tables_result->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='".$row['Tables_in_assets']."'>".$row['Tables_in_assets']."</option>";
    }
    ?>
</select>

<!-- Display selected table data -->
<div id="tableDataContainer">
    <?php
    // Check if table data is available
    if(isset($tableData)) {
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
    }
    ?>
</div>

<script>
function showTableData() {
    var tableName = document.getElementById("tableSelect").value;
    if (tableName !== "") {
        // Redirect to the same page with the selected table as a URL parameter
        window.location.href = "display_table.php?table=" + tableName;
    } else {
        // Clear the tableDataContainer if no table is selected
        document.getElementById("tableDataContainer").innerHTML = "";
    }
}
</script>

</body>
</html>
