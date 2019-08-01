<?php
  session_start();
  include 'db.php';
  include 'form_gen.php';
  if(isset($_SESSION['loggedIn'])){
    header('location: index.php');
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
            <a id="accountBtn" href="registration.php">Account</a>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <!-- Registration / Login section - Users can opt to register or login onto the website -->
  <section class="titleCover">
    <div class="container">
      <div class="row">
        <div class="col-12 center">
          <h2>Register / Login</h2>
        </div>
      </div>
    </div>
  </section>
  <!-- Registration section - Username, Email and Password is required to register -->
  <main class="registrationSection">
    <div class="container">
      <div class="row">
        <div class="col-6">
          <div class="individualWidget">
            <h3 class="widgetTitle">Register</h3>
            <form action="reg_form.php" method="post" id="formRegister">
              <div class="col-12">
                <div class="commentFields">
                  <label for="registerUsername">Username</label>
        				  <?php input_field($errors, 'usrname', 'commentInput', 'Username'); ?>
        				</div>
              </div>
      			  <div class="col-12">
        				<div class="commentFields">
        				  <label for="registerName">Name</label>
        				  <?php input_field($errors, 'name', 'commentInput', 'Name'); ?>
        				</div>
      			  </div>
              <div class="col-12">
                <div class="commentFields">
                  <label for="registerEmail">Email Address</label>
                  <?php input_field($errors, 'email', 'commentInput', 'Email Address'); ?>
                </div>
              </div>
              <div class="col-12">
                <div class="commentFields">
                  <label for="registerPassword">Password</label>
				          <?php passw_field($errors, 'pass', 'commentInput', 'Password'); ?>
                </div>
              </div>
              <div class="col-12 left">
                <input type="checkbox" name="registerAgree"><span class="accountCheckboxText">I agree to the Terms and Conditions</span>
              </div>
              <input class="btns btn authenticationBtns" type="submit" name="submitMember" value="Register">
            </form>
          </div>
        </div>

        <!-- Login section - Correct username and password is required to login -->
        <div class="col-6">
          <div class="individualWidget">
            <h3 class="widgetTitle">Login</h3>
            <form action="reg_form.php" method="post" id="formLogin">
              <div class="col-12">
                <div class="commentFields">
                  <label for="loginUsername">Username</label>
                  <!-- <input class="commentInput" type="text" name="loginUsername" id="loginUsername" placeholder="Username" required> -->
                  <?php input_field($errors, 'loginUsername', 'commentInput', 'Username'); ?>
                </div>
              </div>
              <div class="col-12">
                <div class="commentFields">
                  <label for="loginPassword">Password</label>
                  <input class="commentInput" type="password" name="loginPassword" id="loginPassword" placeholder="Password" required>
                </div>
              </div>
              <div class="col-12 left">
                <input type="checkbox" name="loginStay"><span class="accountCheckboxText">Stay logged in</span>
              </div>
              <input class="btns btn authenticationBtns" type="submit" name="loginMember" value="Login">
            </form>
          </div>
        </div>
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
</body>
</html>
