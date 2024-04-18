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
<div id="tableDataContainer">
    <?php
    // Check if table data is available
    if(!empty($tableData)) {
        // Display table data in an HTML table
        echo "<table id='dataTable'>";
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
    ?>
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
        for (var i = 1; i < table.rows.length; i++) { // Start from 1 to skip header row
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
