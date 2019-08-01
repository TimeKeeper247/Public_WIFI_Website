<?php
session_start();
include 'db.php';
//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_GET['searchButton'])) {
      // if a custom location search was made
      include 'search_results.php';
  } else {
      // if a location was searched based on geolocation
      $mylat = $_GET['w1'];
      $mylon = $_GET['w2'];
      include 'location_result.php';
  }
  $latitude = array_column($result_arr, 'itemLatitude');
  $longitude = array_column($result_arr, 'itemLongitude');
//}
// include 'search_results.php';
// $latitude = $_GET['w1'];
// $longitude = $_GET['w2'];
// include 'location_result.php';
try {
  $itemCount = $pdo->query('SELECT count(*) FROM items')->fetchColumn(); 
} catch (PDOException $e) {
  echo $e->getMessage();
}
//include 'results.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta property="og:title" content="Wifispot">
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://cab230.sef.qut.edu.au/Students/n9554181/index.php">
  <meta property="og:image" content="https://cab230.sef.qut.edu.au/Students/n9554181/img/logo.png">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" sizes="57x57" href="img/icon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="img/icon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="img/icon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="img/icon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="img/icon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="img/icon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="img/icon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="img/icon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="img/icon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="img/icon/android-icon-36x36.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="img/icon/android-icon-48x48.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="img/icon/android-icon-72x72.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="img/icon/android-icon-96x96.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="img/icon/android-icon-144x144.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="img/icon/android-icon-192x192.png">

  <!-- Grid stylesheet -->
  <link rel="stylesheet" href="css/grid.css" type="text/css">

  <!-- Main website's stylesheet -->
  <link rel="stylesheet" href="css/style.css" type="text/css">

  <!-- Fontawesome Icons -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
  <title>Wifispot</title>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script type="text/javascript" src="js/thumb-icon.js"></script>
</head>

<body>
  <!-- Navigation for all other pages -->
  <header class="navigationMenu">
    <nav>
      <div class="container">
        <div class="row">
          <div class="col-6 left">
            <a class="navBtns" href="index.php">Home</a>
          </div>
          <div class="col-6 right">
            <?php
            if(!isset($_SESSION['loggedIn'])){
              echo '<a id="accountBtn" href="registration.php">Account</a>';
            } else {
              echo '<a id="accountBtn" href="logout.php">' . $_SESSION['memberUsername'] . '</a>';
            }
            ?>
          </div>
        </div>
      </div>
    </nav>
  </header>
  <!-- Results section - Showing results based on user's search -->
  <section class="titleCover">
    <div class="container">
      <div class="row">
        <div class="col-12 center">
          <h2>Results 
          <?php
            if(isset($_GET['searchInput'])){
              echo '- "';
              echo filter_input(INPUT_GET, 'searchInput');
              echo '"';
            }
          ?>
          </h2>
          <?php
          echo '<span class="subtitle mb15px">' . count($result_arr) . ' - ' . $itemCount . ' results found';
          if(!empty($_GET['searchInput'])){
            echo ' with the term <em>' . filter_input(INPUT_GET, 'searchInput') . '</em>';
          }
          if(isset($_GET['searchSuburb'])){
            echo ' and in the suburb <em>' . filter_input(INPUT_GET, 'searchSuburb') . '</em>';
          }
          if(isset($_GET['searchRating'])){
            echo ' with a <em><strong>' . filter_input(INPUT_GET, 'searchRating') . '</strong></em> star rating';
          }
          echo '</span>';
          ?>
        </div>
      </div>
    </div>
  </section>
  <main>
    <section class="mainArea">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="mainHeader">
              <h2 class="mainTitle font-heavy">Results:</h2>
            </div>
          </div>
        </div>
        <div class="row mb25px">
          <div class="col-12">
            <div id="resultsMap"></div>
          </div>
        </div>
        <div class="row">
		<?php
		foreach ($result_arr as $results) {
		  include 'wifi_thumb.php';
		}
		?>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer section - Comprising of Website name, Sitemap and Social links -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-4">
          <h3 id="footerLogo"><a href="index.php">Wifispot</a></h3>
        </div>
        <div class="col-4">
          <div class="footerTitle font-heavy mb20px">Sitemap</div>
          <ul class="sitemapList">
            <li><a href="registration.php">Account</a></li>
          </ul>
        </div>
        <div class="col-4">
          <div class="footerTitle font-heavy mb20px">Follow Us</div>
          <div class="socialButtons">
            <a href="#" class="socialButton facebookLogo"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="socialButton instagramLogo"><i class="fab fa-instagram"></i></a>
            <a href="#" class="socialButton twitterLogo"><i class="fab fa-twitter"></i></a>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Google maps API and Javascript -->
  <?php
  echo '
  <script type="text/javascript">
    var result_arr = ' . json_encode($result_arr) . ';
  </script>
  ';
  ?>
  <script type="text/javascript" src="js/results-map.js"></script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDhSI0bxEbtth95myJ0oG2UYXko6CeKwHI&callback=initMap"></script>
</body>
</html>
