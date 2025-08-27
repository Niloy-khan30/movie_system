<?php include('connect.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register page</title>
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
            <form action="register.php" method="post" class="php-email-form aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4" style ="box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 20px; border-radius: 10px;">
                <span style = 'text-align:center'>RAGISTRATION FORM</span>
                <div class="col-md-6">
                  <label for="email-field" class="pb-2">Name</label>
                  <input type="text" class="form-control" name="name" id="name" required="">
                </div>


                <div class="col-md-6">
                  <label for="email-field" class="pb-2">Your Email</label>
                  <input type="email" class="form-control" name="email" id="email-field" required="">
                </div>

                

                <div class="col-md-12">
                  <label for="subject-field" class="pb-2">Password</label>
                  <input type="password" class="form-control" name="password" id="subject-field" required="" placeholder="Enter your password">
                </div >

                  <button type="submit" class= 'btn btn-primary' name= 'register'>register</button>
                </div>

              </div>
            </form>
          </div>
</body>
</html>


<?php

if(isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

   // print_r($_POST);

    $sql = "INSERT INTO users (name, email, password, roletype) VALUES ('$name', '$email', '$password', 2)";

    if(mysqli_query($conn, $sql)) {
        header("Location: login.php");
    } else {
        echo "<script>alert('Registration failed: " . $conn->error . "');</script>";

    }



}
?>