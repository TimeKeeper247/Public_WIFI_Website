function initMap() {
  var map;
  var bounds = new google.maps.LatLngBounds();
  var mapOptions = {
      mapTypeId: 'roadmap'
  };

  // Display a map on the page
  map = new google.maps.Map(document.getElementById("resultsMap"), mapOptions);
  map.setTilt(45);

  //Multiple Markers
  var markers = [];
  var infoWindowContent = [];
  for (i=0; i<result_arr.length; i++){
    markers.push(['test', result_arr[i]['itemLatitude'], result_arr[i]['itemLongitude']]);
    infoWindowContent.push(
      ['<div class="info_content">' +
      '<h3>' + result_arr[i]['itemName'] + '</h3>' +
      '<p>Location: ' + result_arr[i]['itemAddress'] + '</p>' +
      '<p><a href="individual.php?itemID=' + result_arr[i]['itemID'] + '">Click to view wifi hotspot</a></p>' +
      '</div>']
    );
  }

  // Display multiple markers on a map
  var infoWindow = new google.maps.InfoWindow(), marker, i;

  // Loop through our array of markers & place each one on the map
  for( i = 0; i < markers.length; i++ ) {
      var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
      bounds.extend(position);
      marker = new google.maps.Marker({
          position: position,
          map: map,
          title: markers[i][0],
          //icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
      });

      // Allow each marker to have an info window
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
              infoWindow.setContent(infoWindowContent[i][0]);
              infoWindow.open(map, marker);
          }
      })(marker, i));

      // Automatically center the map fitting all markers on the screen
      map.fitBounds(bounds);
  }

  // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
  var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
      this.setZoom(14);
      google.maps.event.removeListener(boundsListener);
  });
}
