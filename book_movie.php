<?php include('connect.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking page</title>
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
    <style>
        #bookingform {
            position : relative;
        }

        img{
          position :absolute;
          top : 40px;
          right : 20px;
        }
    </style>

</head>
<body>

    <?php
    if(isset($_GET['showtime_id'])) {  
        $showtime_id = $_GET['showtime_id'];
    }

    if(isset($_GET['theater_id'])) {  
        $theater_id = $_GET['theater_id'];
    }
    ?>
    <div class="d-flex flex-column justify-content-center align-items-center vh-100 bg-gray">
            <form action="book_movie.php" method="post" class="php-email-form aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4" style ="box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 20px; border-radius: 10px;" id = 'bookingform'>
                <span style = 'text-align:center'>BOOKING FORM</span>
                <div>
                  <?php
                      $sql = "select movies.*, new_theater.*, showtimes.* from showtimes
                      INNER JOIN movies ON showtimes.movieID = movies.movieID
                      INNER JOIN new_theater ON showtimes.theater_id = new_theater.theater_id
                      WHERE showtimes.showtime_id = '$showtime_id'";
                      $result = mysqli_query($conn, $sql);
                      if(mysqli_num_rows($result) > 0){
                      while($row = mysqli_fetch_array($result)){
                          echo "<h4 style = 'font-weight : bold;'>Movie   : ".$row['title']."</h4>";
                          echo "<p style = 'margin-top: 20px'>Show Time   : ".$row['time']."</p>";
                          echo "<p style = 'margin-top: -20px'>Show Date  : ".$row['date']."</p>";
                          echo "<p style = 'margin-top: -20px'>Location   : ".$row['tlocation']."</p>";
                          echo "<img src='admin/uploads/".$row['image']."' style ='height : 230px; width : 200px' alt=''>";
                      }
                      }
                
                  ?>

                </div>

                <div class="col-md-12">
                  <label for="bookingdate" class="pb-2">Booking Date</label>
                  <input type="date" class="form-control" name="bookingdate" required="">
                </div>

                <div class="col-md-6">
                  <input type="hidden" class="form-control" name="showtimeID" value = "<?= $showtime_id ?>" required="">
                </div>
                <div class="col-md-6">
                  <input type="hidden" class="form-control" name="theaterID" value = "<?= $theater_id ?>" required="">
                </div>
                  <button type="submit" class= 'btn btn-primary' name= 'register'>Book Seat</button>
                </div>

              </div>
            </form>
          </div>
</body>
</html>


<?php

if(isset($_POST['register'])) {
    $user_id = $_SESSION['user_id'];
    $showtime_id = $_POST['showtimeID'];
    $booking_date = $_POST['bookingdate'];
    $theater_id = $_POST['theaterID'];
   // print_r($_POST);

    $sql = "INSERT INTO booking (userID, showtime_id, bookingDate) VALUES ('$user_id', '$showtime_id', '$booking_date')";
    if(mysqli_query($conn, $sql)) {
      //booking id
        $booking_id = mysqli_insert_id($conn);
        // Redirect to a confirmation page or show a success message  
        echo "<script>alert('Booking added successfully!');</script>";
        echo "<script>window.location.href='book_seat.php?theater_id=".$theater_id."&booking_id=".$booking_id."';</script>";
    } else {
        echo "<script>alert('Booking failed: " . $conn->error . "');</script>";

    }



}
?>
