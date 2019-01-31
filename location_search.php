<?php
$title = 'Home';
require('includes/header.php');
?>
    <script>
        var infoWindow;
        // Initialize and add the map
        function initMap() {
          var pos = {lat: 52.239469, lng: 6.850834};  // university of twente
          var map = new google.maps.Map(document.getElementById('map'), {zoom: 7, center: pos, streetViewControl: false});
          var marker = new google.maps.Marker({
              position: pos,
              map: map,
              draggable:true,
              title: 'destination',
              label: 'B'
            });

          google.maps.event.addListener(map, 'click', function(event) {
            document.getElementById("lat2").value = event.latLng.lat();
            document.getElementById("lng2").value = event.latLng.lng();

            marker.setPosition(event.latLng);
          });

          // get current geolocation data _______________________
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
              pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
              };
              infoWindow = new google.maps.InfoWindow;
              infoWindow.setPosition(pos);
              infoWindow.setContent('This is your location');
              infoWindow.open(map);

              var location = new google.maps.Marker({
                  position: pos,
                  map: map,
                  draggable:true,
                  title: 'current location',
                  label: 'A'
                });
              map.setCenter(location);

              document.getElementById("lat1").value = position.coords.latitude;
              document.getElementById("lng1").value = position.coords.longitude;
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
