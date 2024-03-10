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

<!-- "OK" button to confirm table selection -->
<button id="okButton" style="display: none;" onclick="confirmTableSelection()">OK</button>

<!-- Display selected table data -->
<div id="tableDataContainer"></div>

<script>
function showTableData() {
    var tableName = document.getElementById("tableSelect").value;
    if (tableName !== "") {
        // Show the "OK" button
        document.getElementById("okButton").style.display = "inline-block";
    } else {
        // Hide the "OK" button if no table is selected
        document.getElementById("okButton").style.display = "none";
        // Clear the tableDataContainer if no table is selected
        document.getElementById("tableDataContainer").innerHTML = "";
    }
}

function fetchTableData(tableName) {
    // Fetch table data 
}

function confirmTableSelection() {
    var tableName = document.getElementById("tableSelect").value;
    if (tableName !== "") {
        // Fetch table data if a table is selected
        fetchTableData(tableName);
    }
}
</script>

</body>
</html>

