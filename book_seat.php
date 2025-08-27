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
    if (isset($_GET['theater_id'])) {  
        $theater_id = $_GET['theater_id'];
    }
    if(isset($_GET['booking_id'])) {  
        $booking_id = $_GET['booking_id'];
    }
    ?>


    <div class="d-flex flex-column justify-content-center align-items-center vh-100 bg-gray">
            <form action="book_seat.php" method="post" class="php-email-form aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4" style ="box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 20px; border-radius: 10px;" id = 'bookingform'>
                <span style = 'text-align:center'>BOOKING SEAT</span>
                <div>
                  <?php
                      $sql = "select movies.*, new_theater.*, showtimes.*, booking.*, users.* from booking
                      INNER JOIN users ON booking.userID = users.userID
                      INNER JOIN showtimes ON booking.showtime_id = showtimes.showtime_id
                      INNER JOIN movies ON showtimes.movieID = movies.movieID
                      INNER JOIN new_theater ON showtimes.theater_id = new_theater.theater_id
                      WHERE booking.bookingID = '$booking_id'";

                      $result = mysqli_query($conn, $sql);
                      if(mysqli_num_rows($result) > 0){
                      while($row = mysqli_fetch_array($result)){
                        echo "<p style = 'font-weight : bold;'>Booking ID : ".$row['bookingID']."</p>";
                          echo "<h4 style = 'font-weight : bold;'>Movie   : ".$row['title']."</h4>";
                          echo "<p style = 'margin-top: 20px'>Show Time   : ".$row['time']."</p>";
                          echo "<p style = 'margin-top: -20px'>Show Date   : ".$row['date']."</p>";
                          echo "<p style = 'margin-top: -20px'>Theater  : ".$row['tname']."</p>";
                          echo "<p style = 'margin-top: -20px'>Location   : ".$row['tlocation']."</p>";
                          echo "<p style = 'margin-top: -20px'>Booked By   : ".$row['name']."</p>";
                          echo "<p style = 'margin-top: -20px'>Booking Date   : ".$row['bookingDate']."</p>";
                          echo "<img src='admin/uploads/" . $row['image'] . "' style='height:230px; width:200px' alt=''>";

                      }
                      }

                
                  ?>

                </div>

                <div class="col-md-12">
                  <input type="hidden" class="form-control" name="theater_id" value ='<?= $theater_id ?>' required="">
                </div>

                <div class="col-md-12">
                  <label  class="pb-2">Seat Type (Normal/VIP/Premium)</label>
                  <input type="text" class="form-control" name="seat_type" value = '' required="" placeholder="Enter Seat Type in Capital Letter">
                </div>
                
                <div class="col-md-12">
                  <label  class="pb-2">No of seat: </label>
                  <input type="number" class="form-control" name="no_of_seat" value = '' required="" placeholder="Enter seat quantity">
                </div>


                  <button type="submit" class= 'btn btn-primary' name= 'register'>Book Ticket</button>
                </div>

              </div>
            </form>
          </div>

</body>
</html>


<?php

if(isset($_POST['register'])) {

    $user_id = $_SESSION['user_id'];
    $theater_id = $_POST['theater_id'];
    $seat_type = $_POST['seat_type'];
    $no_of_seat = $_POST['no_of_seat'];

    $sql = "insert into seats (theater_id, type, No_of_seats) values ('$theater_id', '$seat_type', '$no_of_seat')";
    if(mysqli_query($conn, $sql)) {
        // Redirect to a confirmation page or show a success message  
        echo "<script>alert('Ticket booked successfully!');</script>";
        echo "<script>window.location.href='show_theaters.php';</script>";
    } else {
        echo "<script>alert('Ticket booking failed: " . $conn->error . "');</script>";
    }


}

?>