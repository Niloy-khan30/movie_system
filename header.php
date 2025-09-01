 <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">



<!-- Header -->
 <div class="branding d-flex align-items-center">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <!-- <img src="assets/img/logo.png" alt=""> -->
          <h1 class="sitename" style = 'mergin-left:50px;'>Movies System</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="home.php" class="active">Home</a></li>

            <?php
          

              if (!isset($_SESSION['user_id'])) {
                  echo '
                  <li><a href="index.php">Movies</a></li>
                  <li><a href="show_theaters.php">Theator</a></li>
                  <li><a href="login.php">Login</a></li>
                  <li><a href="register.php">Register</a></li>
                  ';
              } else {
                  $type = $_SESSION['role']; // corrected
                  if ($type == 2) {
                      echo '
                      <li><a href="user_dashboard.php">Dashboard</a></li>
                      <li><a href="index.php">Movies</a></li>
                      <li><a href="show_theaters.php">Theator</a></li>
                      <li><a href="bookingHistory.php">Booking</a></li>
                      <li><a href="logout.php">Logout</a></li>
                      ';
                  } elseif ($type == 1) {
                      echo '
                      <li><a href="admin/dashboard.php">Admin Dashboard</a></li>
                      <li><a href="logout.php">Logout</a></li>
                      ';
                  }
              }
              ?>



            
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

      </div>

    </div>