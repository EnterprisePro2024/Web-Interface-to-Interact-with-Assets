<?php

require_once("includes/setup.php");

// Redirect to login page if user is not logged in
if (!isset($_SESSION['login']) || !$_SESSION['login']) {
    header("Location: login.php");
    exit(); // Stop further execution
}

// Database connection parameters
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'assets';

// Initialize variables
$tableData = [];
$tableName = "";

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch tables relevant to the user's department
    $department = $_SESSION['department_id'];
    $stmtTables = $conn->prepare("SHOW TABLES");
    $stmtTables->execute();
    $tables = $stmtTables->fetchAll(PDO::FETCH_COLUMN);

    // Filter tables based on the presence of department_id column and exclude users and files tables
    $filteredTables = [];
    foreach ($tables as $table) {
        if ($table !== 'users' && $table !== 'files' && $table !== 'departments') {
            // Check if the table has a 'department_id' column
            $stmtCheck = $conn->prepare("SHOW COLUMNS FROM `$table` LIKE 'department_id'");
            $stmtCheck->execute();
            if ($stmtCheck->rowCount() > 0) {
                // If the table has a 'department_id' column, check if it matches the user's department
                $stmtDepartment = $conn->prepare("SELECT * FROM `$table` WHERE department_id = ?");
                $stmtDepartment->execute([$department]);
                if ($stmtDepartment->rowCount() > 0) {
                    $filteredTables[] = $table;
                }
            }
        }
    }

    // Assign filtered tables to $tables variable
    $tables = $filteredTables;

    // Check if a table has been selected
    if (isset($_POST["table"])) {
        $tableName = $_POST["table"];
        // Fetch data from the selected table
        $stmt = $conn->prepare("SELECT * FROM `$tableName`");
        $stmt->execute();
        $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Process form submission
if (isset($_POST['submit'])) {
    try {
        $tableName = $_POST['table'];
        $columns = array_keys($_POST);
        $columns = array_diff($columns, ['table', 'submit']);

        // Prepare SQL query to insert data
        $query = "INSERT INTO `$tableName` (";
        $query .= implode(", ", $columns) . ") VALUES (";
        $query .= implode(", ", array_fill(0, count($columns), "?")) . ")";

        // Prepare statement
        $stmt = $conn->prepare($query);

        // Bind parameters
        $i = 1;
        foreach ($columns as $column) {
            $stmt->bindParam($i++, $_POST[$column]);
        }

        // Execute statement
        $stmt->execute();

        // Refresh table data
        $stmt = $conn->prepare("SELECT * FROM `$tableName`");
        $stmt->execute();
        $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Table Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        
        h2 {
            margin-top: 0;
        }

        form {
            margin-bottom: 20px;
        }

        select, input[type="submit"] {
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Display Table Data</h2>

    <!-- Form to select table -->
    <form method="post">
        <!-- Dropdown menu to select table -->
        <select name="table">
            <option value="">Select Table</option>
            <?php foreach ($tables as $table) : ?>
                <option value="<?php echo $table; ?>"><?php echo $table; ?></option>
            <?php endforeach; ?>
        </select>
        <!-- Submit button to confirm table selection -->
        <input type="submit" value="OK">
    </form>

    <!-- Add New Data form -->
    <?php if (!empty($tableName)) : ?>
        <div>
            <h2>Add New Data</h2>
            <form method="post">
                <input type="hidden" name="table" value="<?php echo $tableName; ?>">
                <?php
                // Get columns of the selected table
                $stmtColumns = $conn->prepare("SHOW COLUMNS FROM `$tableName`");
                $stmtColumns->execute();
                $columns = $stmtColumns->fetchAll(PDO::FETCH_COLUMN);
                foreach ($columns as $column) : ?>
                    <label for="<?php echo $column; ?>"><?php echo ucfirst($column); ?>:</label>
                    <input type="text" name="<?php echo $column; ?>" id="<?php echo $column; ?>"><br>
                <?php endforeach; ?>
                <input type="submit" name="submit" value="Add Data">
            </form>
        </div>
    <?php endif; ?>

    <!-- Filter column options -->
    <?php if (!empty($tableData)) : ?>
        <form id="filterForm">
            <label>Filter by Column:</label><br>
            <?php foreach (array_keys($tableData[0]) as $column) : ?>
                <input type="checkbox" name="columns[]" value="<?php echo $column; ?>"><?php echo $column; ?><br>
            <?php endforeach; ?>
            <input type="button" value="Apply Filter" onclick="applyFilter()">
        </form>
    <?php endif; ?>

    <!-- Search functionality -->
    <?php if (!empty($tableData)) : ?>
        <form id="searchForm">
            <label for="searchInput">Search Asset:</label>
            <input type="text" id="searchInput" name="searchInput">
            <input type="button" value="Search" onclick="searchAsset()">
        </form>
    <?php endif; ?>

    <!-- Display selected table data -->
    <?php if (!empty($tableData)) : ?>
        <h2>Table Data</h2>
        <table id="dataTable">
            <thead>
            <tr>
                <?php foreach (array_keys($tableData[0]) as $column) : ?>
                    <th><?php echo $column; ?></th>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tableData as $row) : ?>
                <tr>
                    <?php foreach ($row as $value) : ?>
                        <td><?php echo $value; ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>

<script>
    function applyFilter() {
        var selectedColumns = document.querySelectorAll('input[name="columns[]"]:checked');
        var table = document.getElementById('dataTable');
        var columnIndex, cell;

        // Hide all columns
        for (var i = 0; i < table.rows.length; i++) {
            for (var j = 0; j < table.rows[i].cells.length; j++) {
                table.rows[i].cells[j].style.display = 'none';
            }
        }

        // Show selected columns
        for (var i = 0; i < selectedColumns.length; i++) {
            columnIndex = selectedColumns[i].value;
            // Find the index of the selected column
            for (var j = 0; j < table.rows[0].cells.length; j++) {
                if (table.rows[0].cells[j].textContent === columnIndex) {
                    // Show the column
                    for (var k = 0; k < table.rows.length; k++) {
                        cell = table.rows[k].cells[j];
                        cell.style.display = '';
                    }
                    break;
                }
            }
        }
    }

    function searchAsset() {
        var searchInput = document.getElementById('searchInput').value.toLowerCase();
        var table = document.getElementById('dataTable');
        var cellText;

        // Loop through each cell in the table and hide rows that don't match the search input
        for (var i = 1; i < table.rows.length; i++) {
            var row = table.rows[i];
            var rowMatch = false;
            for (var j = 0; j < row.cells.length; j++) {
                cellText = row.cells[j].textContent.toLowerCase();
                if (cellText.includes(searchInput)) {
                    rowMatch = true;
                    break;
                }
            }
            if (rowMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    }
</script>

</body>
</html>
