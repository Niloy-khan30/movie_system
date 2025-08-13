<?php include('connect.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login page</title>
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

</head>
<body>
    <div class="d-flex flex-column justify-content-center align-items-center vh-100 bg-gray">
            <form action="login.php" method="post" class="php-email-form aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">


                <div class="col-md-6">
                  <label for="email-field" class="pb-2">Your Email</label>
                  <input type="email" class="form-control" name="email" id="email-field" required="">
                </div>

                <div class="col-md-12">
                  <label for="subject-field" class="pb-2">password</label>
                  <input type="password" class="form-control" name="password" id="subject-field" required="" placeholder="Enter your password">
                </div>

                  <button type="submit" name = 'login' class = 'btn btn-primary'>login</button>
                </div>

              </div>
            </form>
          </div>
</body>
</html>

<?php
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";

    $rsult = mysqli_query($conn, $sql);
    if(mysqli_num_rows($rsult) > 0){
        $data = mysqli_fetch_array($rsult);


        $_SESSION['user_id'] = $data['userID'];
        $_SESSION['role'] = $data['roletype'];

        if ($data['roletype'] == 1){
            header('location: admin/dashboard.php ');
        } else if($data['roletype'] == 2){
            header('location:index.php');
        }
    } else {
        echo "<script>alert('Invalid email or password');</script>";
    }
}



?>