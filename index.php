<?php
  session_start();
  include 'db.php';
  try {
    $suburbResult = $pdo->query('SELECT itemSuburb FROM items');
    $randomResult = $pdo->query('SELECT * FROM items ORDER BY RAND() LIMIT 0,6');
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
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
  <script type="text/javascript" src="js/location.js"></script>
  <!-- Navigation for homepage only -->
  <header id="mainHeader">
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

    <!-- Search section - Comprising of a search form to search based on location, suburb and rating. -->
    <section class="searchBody">
      <div class="container">
        <div class="row">
          <div class="col-12 center">
            <div id="headerArea" class="mb20px">
              <h1 class="font-heavy mb15px">Locate the nearest wifi hotspot</h1>
              <span class="subtitle mb15px">With just a click of a button, Wifispot will help you to locate the nearest wifi hotspot in Brisbane</span>
            </div>
              <!-- Search Form (to be made into a correct form in stage 2.) -->
			      <form action="results.php" method="GET" id="searchForm">
              <div class="row">
                <div class="col-3">
                  <input id="searchInput" class="searchInput" name="searchInput" type="text" placeholder="Where">
                </div>
                <!-- Suburbs to be sorted according to alphabetical order -->
                <div class="col-3">
                  <select class="searchInput" name="searchSuburb">
                    <option value="" disabled selected>Suburb</option>
                    <?php
                      foreach($suburbResult as $suburb){
                        echo '<option value="' . $suburb['itemSuburb'] . '">' . $suburb['itemSuburb'] . '</option>';
                      }
                    ?>
                  </select>
                </div>
                <div class="col-3">
                  <select class="searchInput" name="searchRating">
                    <option value="" disabled selected>Rating</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>
                </div>
                <div class="col-3">
  				        <input id="submit" class="btns btn" type="submit" name="searchButton" value="Search">
                </div>
              </div>
			      </form>

            <!-- Search based on user's location -->
            <div class="row">
              <div class="col-12 center">
                <p>or</p>
                <p class="subtitle">Search based on your location</p>
                <button onClick="getLocation()" class="btns btn" name="locationButton">Locate</button>
                <p id="coordinates"></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </header>

  <!-- Homepage main - Comprising of the featured wifi hotspots -->
  <main>
    <section class="mainArea">
      <div class="container">
        <div class="row">
          <div class="col-12 center">
            <div class="mainHeader">
              <h2 class="mainTitle font-heavy">Featured Spots</h2>
              <p class="mainSubtitle">Our featured wifi hotspots!</p>
            </div>
          </div>
        </div>
        <div class="row">
          <?php
            foreach($randomResult as $results){
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

  <!-- External Javascript file linking -->
</body>
</html>
