<?php
$title = 'Home';
require('includes/header.php');
?>
    <script>
        var infoWindow;
        // Initialize and add the map
        function initMap() {
          var pos = {lat: 52.239469, lng: 6.850834};  // university of twente
          var map = new google.maps.Map(document.getElementById('map'), {zoom: 8, center: pos, streetViewControl: false});
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

            getTravelTime();
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
                  draggable: true,
                  title: 'current location',
                  label: 'A'
              });
              map.setCenter(pos);

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

      function getTravelTime(){

        var directionsService = new google.maps.DirectionsService();
        var request = {
          origin: new GLatLng(document.getElementById("lat1"),document.getElementById("long1")), // LatLng|string
          destination: new GLatLng(document.getElementById("lat2"),document.getElementById("long2")), // LatLng|string
          travelMode: google.maps.DirectionsTravelMode.DRIVING
        };

        directionsService.route( request, function( response, status ) {
          if ( status === 'OK' ) {
            var point = response.routes[0].legs[0];
            document.getElementById("log").value = + point.duration.text + ' (' + point.distance.text + ") from A to B";
          }
          else {
              document.getElementById("log").value = "unable to calculate";
          }
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

        <input type="text" id="log" value="">
    </form>

<?php
require('includes/footer.php');
?>
