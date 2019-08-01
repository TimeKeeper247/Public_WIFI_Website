<?php
include 'db.php';

// if (isset($_GET['w1']) && isset($_GET['w2'])) {
//     $mylat = $_GET['w1'];
//     $mylon = $_GET['w2'];
// } else {
//     header('location: index.php');
// }
//echo $mylat . " " . $mylon;

$result_lat = array();
$result_lon = array();
$sql = "SELECT * FROM items";
$query = $pdo->prepare($sql);
$query->execute();
while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
    array_push($result_lat, $result['itemLatitude']);
    array_push($result_lon, $result['itemLongitude']);
}
$latlon = array_combine($result_lat, $result_lon);
$i = 0;
$wifi_rad = 20000; // radius in metres for search by current location
foreach ($latlon as $rlat => $rlon) {
    if(haversine($mylat, $mylon, $rlat, $rlon) > $wifi_rad){
        //unset($latlon[$rlat]);
        unset($result_lat[$i]);
    }
    $i += 1;
}
array_values($result_lat); // reorganises array indices

$result_arr = array();
foreach($result_lat as $rlat) {
	if(!empty($rlat)) {
		$sql = "SELECT * FROM items WHERE itemLatitude = :latitude";
		$query = $pdo->prepare($sql);
		$query->bindValue(':latitude', $rlat);
		$query->execute();
		
		while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
		    array_push($result_arr, $result);
		}
	}
}

function haversine($lat1, $lon1, $lat2, $lon2){ // calculates arc distance
    $R = 6371e3; //Earth's radius in metres
    $rad1 = deg2rad($lat1);
    $rad2 = deg2rad($lat2);
    $delta_lat = deg2rad($lat2-$lat1);
    $delta_lon = deg2rad($lon2-$lon1);

    $a = sin($delta_lat/2) * sin($delta_lat/2) +
        cos($rad1) * cos($rad2) *
        sin($delta_lon/2) * sin($delta_lon/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));

    $d = $R * $c;
    return $d;
}
?>