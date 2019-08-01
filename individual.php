<?php
  session_start();
  include 'db.php';
  try {
    $itemResult = $pdo->query('SELECT * FROM items WHERE itemID = ' . $_GET['itemID'] . '');
    if(isset($_POST['submitReview'])){
      $insertReview = $pdo->prepare('INSERT INTO reviews(itemID, memberUsername, reviewDescription, reviewRating) VALUES(:itemID, :memberUsername, :commentMessage, :commentRating)');
      $insertReview->bindValue(':itemID', $_GET['itemID']);
      $insertReview->bindValue(':memberUsername', $_SESSION['memberUsername']);
      $insertReview->bindValue(':commentMessage', $_POST['commentMessage']);
      $insertReview->bindValue(':commentRating', $_POST['commentRating']);
      $insertReview->execute();
    }
    $reviewResult = $pdo->query('SELECT * FROM reviews WHERE itemID = ' . $_GET['itemID'] . '');
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
  foreach($itemResult as $itemDetails){
    $itemName = $itemDetails['itemName'];
    $itemAddress = $itemDetails['itemAddress'];
    $itemSuburb = $itemDetails['itemSuburb'];
    $itemLatitude = $itemDetails['itemLatitude'];
    $itemLongitude = $itemDetails['itemLongitude'];
  }
?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta property="og:title" content="Wifispot">
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://cab230.sef.qut.edu.au/Students/n9554181/index.html">
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

  <!-- <script src="js/map.js"></script> -->
  <title>Wifispot</title>
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

  <!-- Individual section - Showing each individual wifi hotspots -->
  <main class="individualSection">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="row" id="backResults">
            <a href="index.php"><i class="fas fa-arrow-left"></i> Back to home</a>
          </div>
          <div class="row">
            <h1><?php echo $itemName; ?></h1>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-8">
          <div class="row">
            <div class="individualWidget">
              <h3 class="widgetTitle">Comments</h3>
              <?php    
                foreach($reviewResult as $reviewDetails){
                  $reviewDatePosted = $reviewDetails['datePosted'];
                  $reviewMemberUsername = $reviewDetails['memberUsername'];
                  $reviewDescription = $reviewDetails['reviewDescription'];
                  $reviewRating = $reviewDetails['reviewRating'];
                  $formatReviewDatePosted = date( "jS F Y g:ia", strtotime($reviewDatePosted));
              ?>
              <div class="widgetComment">
                <p class="commentAuthor font-heavy"><?php echo $reviewMemberUsername; ?></p>
                <span class="commentRating">
                  <?php
                    for($i = 0; $i < $reviewRating; $i++){
                      echo '<i class="fas fa-star"></i>';
                    }
                  ?>
                </span>
                <p class="commentContent"><?php echo $reviewDescription; ?></p>
                <p class="commentContent font-heavy">Posted on: <?php echo $formatReviewDatePosted; ?></p>
              </div>
              <?php
                }
              ?>
            </div>
          </div>
          <?php
            if(isset($_SESSION['loggedIn'])){
          ?>
          <div class="row">
            <div class="individualWidget">
              <h3 class="widgetTitle">New Comment</h3>
              <form method="POST">
                <div class="col-6">
                  <div class="commentFields">
                    <input class="commentInput" type="text" name="memberUsername" value="<?php echo $_SESSION['memberUsername']; ?>" disabled>
                  </div>
                </div>
                <div class="col-6">
                  <div class="commentFields">
                    <input class="commentInput" type="number" min="1" max="5" name="commentRating" placeholder="Rating" required>
                  </div>
                </div>
                <div class="col-12">
                  <div class="commentFields">
                    <textarea rows="10" name="commentMessage" placeholder="Your Review" required></textarea>
                  </div>
                </div>
			          <input name="submitReview" class="btns btn" type="submit" value="Submit">
              </form>
            </div>
          </div>
          <?php
            }
          ?>
        </div>
        <aside class="col-4">
          <div class="row">
            <div class="individualWidget">
              <h3 class="widgetTitle">Location</h3>
              <div id="individualMap"></div>
              <p class="widgetDescription">Location: <?php echo $itemAddress . ', ' . $itemSuburb; ?> </p>
              <p class="widgetDescription">Avg Rating: 5 <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></p>
            </div>
          </div>
        </aside>
      </div>
    </div>
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
  <script>
    function initMap() {
      var location = {lat: <?php echo $itemLatitude; ?>, lng: <?php echo $itemLongitude; ?>};
      var locationMap = new google.maps.Map(document.getElementById('individualMap'), {
        zoom: 18,
        center: location
      });
      var marker = new google.maps.Marker({
        position: location,
        map: locationMap
      });
    }
    </script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDhSI0bxEbtth95myJ0oG2UYXko6CeKwHI&callback=initMap"></script>
</body>
</html>
