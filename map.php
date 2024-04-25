<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Map | View</title>
</head>
<body>

<div id="searchOptions">
    <h4>Search Markers</h4>
    <input type="text" id="searchInput" placeholder="Search...">
    <button onclick="searchMarkers()">Search</button>
    <button onclick="resetMarkers()">Reset</button> <!-- Added reset button -->
</div>

<div id="map" style="width: 100%; height: 80vh;"></div>

<?php
/* Database connection settings */
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'assets';
$mysqli = new mysqli($host, $user, $pass, $db) or die($mysqli->error);

$markers = array();

// Get all tables in the database
$query = "SHOW TABLES";
$result = $mysqli->query($query) or die('Error fetching tables: ' . $mysqli->error);

while ($row = mysqli_fetch_array($result)) {
    $table = $row[0];

    // Check if the table has latitude and longitude columns
    $query = "SHOW COLUMNS FROM `$table` WHERE Field REGEXP 'latitude|longitude'"; // Use regular expression
    $columnsResult = $mysqli->query($query);

    // If latitude and longitude columns exist
    if ($columnsResult->num_rows > 0) {
        // Fetch latitude and longitude data
        $latitudeColumnName = '';
        $longitudeColumnName = '';

        while ($columnRow = mysqli_fetch_assoc($columnsResult)) {
            $field = $columnRow['Field'];
            if (preg_match('/latitude/i', $field)) { // Case-insensitive match for latitude
                $latitudeColumnName = $field;
            }
            if (preg_match('/longitude/i', $field)) { // Case-insensitive match for longitude
                $longitudeColumnName = $field;
            }
        }

        if (!empty($latitudeColumnName) && !empty($longitudeColumnName)) {
            $query = "SELECT * FROM `$table` WHERE `$latitudeColumnName` IS NOT NULL AND `$longitudeColumnName` IS NOT NULL";
            $dataResult = $mysqli->query($query);

            while ($dataRow = mysqli_fetch_assoc($dataResult)) {
                $rowData = array();
                foreach ($dataRow as $key => $value) {
                    $rowData[$key] = $value;
                }
                $markers[] = array(
                    'lat' => $dataRow[$latitudeColumnName],
                    'lng' => $dataRow[$longitudeColumnName],
                    'table' => $table,
                    'data' => $rowData
                );
            }
        }
    }
}

// If there are markers, display the map
if (!empty($markers)) {
    echo '<script>';
    echo 'var markers = ' . json_encode($markers) . ';';
    echo '</script>';
} else {
    echo 'No tables with latitude and longitude columns found.';
}
?>

<script>
    var map;
    var allMarkers = []; // Array to hold all markers

    function initMap() {
        var mapOptions = {
            zoom: 12,
            center: {lat: <?php echo $markers[0]['lat']; ?>, lng: <?php echo $markers[0]['lng']; ?>},
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById('map'), mapOptions);

        displayMarkers();
    }

    function displayMarkers() {
        markers.forEach(function(markerData) {
            var marker = new google.maps.Marker({
                position: {lat: parseFloat(markerData.lat), lng: parseFloat(markerData.lng)},
                map: map,
                title: "Marker"
            });

            allMarkers.push(marker); // Add marker to allMarkers array

            var contentString = '<div style="width: 200px; height:200px;">';
            contentString += '<h3>' + markerData.table + '</h3>';
            contentString += '<ul>';
            for (var key in markerData.data) {
                contentString += '<li><strong>' + key + ':</strong> ' + markerData.data[key] + '</li>';
            }
            contentString += '</ul>';
            contentString += '</div>';

            var infoWindow = new google.maps.InfoWindow({
                content: contentString
            });

            marker.addListener('mouseover', function() {
                infoWindow.open(map, marker);
            });

            marker.addListener('mouseout', function() {
                infoWindow.close();
            });
        });
    }

    function searchMarkers() {
        var searchInput = document.getElementById('searchInput').value.toLowerCase();

        var searchResultsFound = false; // Flag to track if any search results are found

        // Clear existing markers from the map
        clearMarkers();

        // Filter markers based on the search input
        markers.forEach(function(markerData) {
            var markerInfo = markerData.table.toLowerCase() + ' ';
            for (var key in markerData.data) {
                markerInfo += markerData.data[key].toLowerCase() + ' ';
            }

            if (markerInfo.includes(searchInput)) {
                searchResultsFound = true; // Set flag to true if at least one search result is found

                // Show marker
                var marker = new google.maps.Marker({
                    position: {lat: parseFloat(markerData.lat), lng: parseFloat(markerData.lng)},
                    map: map,
                    title: "Marker"
                });

                allMarkers.push(marker); // Add marker to allMarkers array

                var contentString = '<div style="width: 200px; height:200px;">';
                contentString += '<h3>' + markerData.table + '</h3>';
                contentString += '<ul>';
                for (var key in markerData.data) {
                    contentString += '<li><strong>' + key + ':</strong> ' + markerData.data[key] + '</li>';
                }
                contentString += '</ul>';
                contentString += '</div>';

                var infoWindow = new google.maps.InfoWindow({
                    content: contentString
                });

                marker.addListener('mouseover', function() {
                    infoWindow.open(map, marker);
                });

                marker.addListener('mouseout', function() {
                    infoWindow.close();
                });
            }
        });

        // If no search results found, display a message
        if (!searchResultsFound) {
            alert('No matching markers found.');
        }
    }

    function resetMarkers() {
        // Clear existing markers from the map
        clearMarkers();
        
        // Display all markers again
        displayMarkers();
    }

    function clearMarkers() {
        // Loop through all markers and remove them from the map
        allMarkers.forEach(function(marker) {
            marker.setMap(null);
        });
        // Reset the allMarkers array
        allMarkers = [];
    }
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-dFHYjTqEVLndbN2gdvXsx09jfJHmNc8&callback=initMap"></script>
</body>
