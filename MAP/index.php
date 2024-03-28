<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Map | View</title>
</head>
<body>
    <nav>  
        <ul> 
            <li class="active"><a href="#"><img src="img/map.png"></a></li>
            <li><a href="#"><img src="img/logout.png"></a></li>
        </ul> 
    </nav>

    <div id="map" style="width: 100%; height: 80vh;"></div>

    <?php
        /* Database connection settings */
        $host = 'localhost';
        $user = 'adam';
        $pass = 'YES';
        $db = 'assets';
        $mysqli = new mysqli($host, $user, $pass, $db) or die($mysqli->error);

        $markers = array();

        // Select all the rows in the markers table
        $query = "SELECT `Latitude`, `Longitude`, `Allotment` FROM `allotmentlist2017` ";
        $result = $mysqli->query($query) or die('Data selection for google map failed: ' . $mysqli->error);

        while ($row = mysqli_fetch_array($result)) {
            $markers[] = array(
                'lat' => $row['Latitude'],
                'lng' => $row['Longitude'],
                'allotment' => $row['Allotment']
            );
        }
    ?>

    <script>
        function initMap() {
            var mapOptions = {
                zoom: 12,
                center: {lat: <?php echo $markers[0]['lat']; ?>, lng: <?php echo $markers[0]['lng']; ?>},
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var map = new google.maps.Map(document.getElementById('map'), mapOptions);

            var markers = <?php echo json_encode($markers); ?>;

            markers.forEach(function(markerData) {
                var marker = new google.maps.Marker({
                    position: {lat: parseFloat(markerData.lat), lng: parseFloat(markerData.lng)},
                    map: map,
                    title: "Marker"
                });

                var infoWindow = new google.maps.InfoWindow({
                    content: markerData.allotment
                });

                marker.addListener('mouseover', function() {
                    infoWindow.open(map, marker);
                });

                marker.addListener('mouseout', function() {
                    infoWindow.close();
                });
            });
        }
    </script>

    <!-- Remember to put your Google Maps API key -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-dFHYjTqEVLndbN2gdvXsx09jfJHmNc8&callback=initMap"></script>
</body>
</html>
