function initMap() {
  var location = {lat: -27.467209, lng: 153.049656};
  var locationMap = new google.maps.Map(document.getElementById('individualMap'), {
    zoom: 18,
    center: location
  });
  var marker = new google.maps.Marker({
    position: location,
    map: locationMap
  });
}
