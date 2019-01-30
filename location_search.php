<?php
$title = 'Home';
require('includes/header.php');
?>
<script>
        // Initialize and add the map
        function initMap() {

            var pos = {lat: 52.14196, lng: 6.51223};  // university of twente
            var map = new google.maps.Map(document.getElementById('map'), {zoom: 6, center: utwente});
            google.maps.event.addListener(map, 'click', function(event) {
                document.getElementById("inputlat").value = event.latLng.lat();
                document.getElementById("inputlng").value = event.latLng.lng();
            });
            infoWindow = new google.maps.InfoWindow;

            // get current geolocation data _______________________
            if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(function(position) {
                pos = {
                  lat: position.coords.latitude,
                  lng: position.coords.longitude
                };

                infoWindow.setPosition(pos);
                infoWindow.setContent('Location found.');
                infoWindow.open(map);
                map.setCenter(pos);
              }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
              });
            } else {
              // Browser doesn't support Geolocation
              handleLocationError(false, infoWindow, map.getCenter());
            }
          }

          function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
              'Error: The Geolocation service failed.' :
              'Error: Your browser doesn\'t support geolocation.');
              infoWindow.open(map);
            }


            // code needed for markers _______________________

            <?php
            require('includes/database.php');

            $query = $conn->prepare("SELECT * FROM locations WHERE id <> ? AND lat IS NOT NULL AND lng IS NOT NULL;");
            $query->bind_param('i', $_SESSION['id']);
            $query->execute();
            $result = $query->get_result();

            for ($i = 0; $i < $query->rowCount(); $i++){
                $row = $result[$i];
                ?>
            var pos<?php echo $i?> = new google.maps.LatLng(<?php echo $row['lat']?>,<?php echo $row['lng']?>);
            var marker<?php echo $i?> = new google.maps.Marker({position:pos<?php echo $i?>});
            marker<?php echo $i?>.setMap(map);

            google.maps.event.addListener(marker<?php echo $i?>,'click',function() {
                document.getElementById("inputlat").value = <?php echo $row['lat']?>;
                document.getElementById("inputlng").value = <?php echo $row['lng']?>;
                map.setCenter(marker<?php echo $i?>.getPosition());
                var infoWindow = new google.maps.InfoWindow({
                    content:"Title: <?php echo $row['title']?>"
                });
                infoWindow.open(map, marker<?php echo $i?>);
                document.getElementById("saveL").disabled = true;
                document.getElementById("saveL").style.display = 'none';
                document.getElementById("deleteL").disabled = false;
                document.getElementById("deleteL").style.display = 'block';
            });
            <?php } ?>
        }
    </script>
    <!-- API key needs to be updated -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=_INSERTKEYHERE_&callback=initMap"></script>

    <div id="map" style="width: 100%; height: 300px"></div><br>
    <form id="saveL" method="post" action="saveLoc.php">
        <input type="hidden" id="inputlat" value="">
        <input type="hidden" id="inputlng" value="">
        <input type="submit" value="save location">
    </form>
    <form id="deleteL" method="post" action="deleteLoc.php">
        <input type="hidden" id="inputlat" value="">
        <input type="hidden" id="inputlng" value="">
        <input type="submit" value="deleteLoc">
    </form>

<?php
require('includes/footer.php');
?>
