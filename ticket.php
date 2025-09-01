<?php include('connect.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
    if (isset($_GET['theater_id'])) {  
        $theater_id = $_GET['theater_id']??null;
    }
    if(isset($_GET['booking_id'])) {  
        $booking_id = $_GET['booking_id']??null;
    }

    if(isset($_GET['seat_id'])) {  
        $seat_id = $_GET['seat_id']??null;
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
          top : 70px;
          right : 20px;
        }
    </style>

</head>
<body>
  



    <div class="d-flex flex-column justify-content-center align-items-center vh-100 bg-gray">
            <form action="ticket.php" method="post" class="php-email-form aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4" style ="box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 20px; border-radius: 10px;" id = 'bookingform'>
                <span style = 'text-align:center'>BOOKING TICKET</span>
                <div>
                  <?php
                      $sql = "select booking.*, movies.*, new_theater.*, showtimes.*, users.*, seats.* from booking
                      INNER JOIN showtimes ON booking.showtime_id = showtimes.showtime_id
                      INNER JOIN movies ON showtimes.movieID = movies.movieID
                      INNER JOIN new_theater ON showtimes.theater_id = new_theater.theater_id
                      INNER JOIN users ON booking.userID = users.userID
                      INNER JOIN seats ON seats.theater_id = new_theater.theater_id
                      WHERE seats.seatID = '$seat_id' and users.userID = '".$_SESSION['user_id']."' and new_theater.theater_id = '$theater_id' and booking.bookingID = '$booking_id'";
                      

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
                          echo "<p style = 'margin-top: -20px'>Seat Type   : ".$row['type']."</p>";
                          echo "<p style = 'margin-top: -20px'>Seat quantity   : ".$row['No_of_seats']."</p>";
                          echo "<img src='admin/uploads/" . $row['image'] . "' style='height:230px; width:200px' alt=''>";
                          echo "<input type= 'hidden' class='form-control' name= 'seat_type' value =".$row['type']." required=''>";
                          echo "<input type= 'hidden' class='form-control' name= 'no_of_seat' value =".$row['No_of_seats']." required=''>";
                      }
                      }

                
                  ?>

                </div>

                <div class="col-md-12">
                  <input type="hidden" class="form-control" name="seat_id" value ='<?= $seat_id ?>' required="">
                </div>
                <div class="col-md-12">
                  <input type="hidden" class="form-control" name="booking_id" value ='<?= $booking_id ?>' required="">
                </div>


                  <button type="submit" class= 'btn btn-primary' name= 'register'>MAKE PAYMENT</button>
                </div>

              </div>
            </form>
          </div>

</body>
</html>


<?php

if(isset($_POST['register'])) {
    $seat_id = $_POST['seat_id'];
    $booking_id = $_POST['booking_id'];

    //if seat type is normal price is 500 , vip price is 800 , premium price is 1000
    $seat_type = $_POST['seat_type'];
    $no_of_seat = $_POST['no_of_seat'];

    if ($seat_type == 'NORMAL') {
        $price_per_seat = 500;
    } elseif ($seat_type == 'VIP') {
        $price_per_seat = 800;
    } elseif ($seat_type == 'PREMIUM') {
        $price_per_seat = 1000;
    } else {
        echo "<script>alert('Invalid seat type! Please enter NORMAL, VIP, or PREMIUM.');</script>";
        exit();
    }
    



    $sql = "insert into ticket (seatID, bookingID, price) values ('$seat_id', '$booking_id', '$price_per_seat' * '$no_of_seat')";
    if(mysqli_query($conn, $sql)) {
        //Redirect to a confirmation page or show a success message  
        //echo "<script>alert('Ticket booked successfully!');</script>";
        header('Location: payment.php');
        
    } 


}

?>