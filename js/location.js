/* Getting the Latitude and Longitude for search based on location */
var x = document.getElementById("coordinates");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    //var lat = position.coords.latitude;
    //var lon = position.coords.longitude;
    // x.innerHTML = "Latitude: " + lat +
    // "<br>Longitude: " + lon;
    
    window.location.href = "results.php?w1=" + position.coords.latitude + "&w2=" + position.coords.longitude;
}

// function haversine(lat1, lon1, lat2, lon2) {
//     var R = 6371e3; // metres
//     var rad1 = lat1.toRadians();
//     var rad2 = lat2.toRadians();
//     var delta_lat = (lat2-lat1).toRadians();
//     var delta_lon = (lon2-lon1).toRadians();

//     var a = Math.sin(delta_lat/2) * Math.sin(delta_lat/2) +
//         Math.cos(rad1) * Math.cos(rad2) *
//         Math.sin(delta_lon/2) * Math.sin(delta_lon/2);
//     var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

//     var d = R * c;
//     return d;
// }