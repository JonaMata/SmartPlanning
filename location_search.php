<?php
$title = 'Home';
require('includes/header.php');
?>
    <script>
        var marker;
        // Initialize and add the map
        function initMap() {
          var pos = {lat: 52.239469, lng: 6.850834};  // university of twente
          var map = new google.maps.Map(document.getElementById('map'), {zoom: 6, center: pos});
          google.maps.event.addListener(map, 'click', function(event) {
            document.getElementById("lat2").value = event.latLng.lat();
            document.getElementById("lng2").value = event.latLng.lng();

            marker = new google.maps.Marker({
              position: new google.maps.LatLng(event.latLng.lat(),event.latLng.lng()),
              map: map,
              draggable:true,
              title: 'destination'
            });
            marker.setMap(map);
          });

        }


    </script>
    <!-- API key needs to be updated -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAd8kdXbfNiuxZfyi6UNHH2Rfpck0Pdwfc&callback=initMap"></script>

    <div id="map" style="width: 95%; height: 300px"></div><br>
    <form id="start" method="post" action="saveLoc.php">
        <input type="hidden" id="lat1" value="">
        <input type="hidden" id="lng1" value="">
        <input type="hidden" id="lat2" value="">
        <input type="hidden" id="lng2" value="">

        <input type="submit" value="save location">
    </form>

<?php
require('includes/footer.php');
?>
