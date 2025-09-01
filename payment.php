<?php 
include('connect.php'); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PAYMENT page</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  

  <!-- Custom CSS -->
  <style>
    body {
      margin: 0;
      font-family: 'Roboto', sans-serif;
      background: linear-gradient(135deg, #4e73df, #1cc88a);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-box {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.2);
      animation: fadeIn 0.6s ease-in-out;
    }

    .login-box h3 {
      text-align: center;
      font-weight: 600;
      color: #4e73df;
      margin-bottom: 20px;
    }

    .login-box label {
      font-weight: 500;
      color: #333;
    }

    .login-box .form-control {
      border-radius: 8px;
      padding: 10px;
      border: 1px solid #ccc;
      transition: 0.3s;
    }

    .login-box .form-control:focus {
      border-color: #4e73df;
      box-shadow: 0 0 5px rgba(78,115,223,0.4);
    }

    .login-box .btn-primary {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      font-weight: 500;
      background: #4e73df;
      border: none;
      transition: 0.3s;
    }

    .login-box .btn-primary:hover {
      background: #2e59d9;
      transform: scale(1.03);
    }

    .extra-links {
      text-align: center;
      margin-top: 15px;
    }

    .extra-links a {
      text-decoration: none;
      color: #4e73df;
      font-size: 14px;
    }

    .extra-links a:hover {
      text-decoration: underline;
    }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(-20px);}
      to {opacity: 1; transform: translateY(0);}
    }
  </style>
</head>
<body>
  <form action="payment.php" method="post" class="login-box">
    <?php
        $sql = "select ticket.*, booking.*, seats.* from ticket
        INNER JOIN booking ON ticket.bookingID = booking.bookingID
        INNER JOIN seats ON ticket.seatID = seats.seatID
        WHERE booking.userID = '".$_SESSION['user_id']."' ORDER BY ticket.ticket_id
        DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            echo "<p style = 'text-align : center; font-weight : bold;'>Total Ammount to be paid : ".$row['price']."</p>";
            echo "<input type= 'hidden' class='form-control' name= 'booking_id' value =".$row['bookingID']." required=''>";
            echo "<input type= 'hidden' class='form-control' name= 'price' value =".$row['price']." required=''>";
        }
        }
    ?>
    <div class="mb-3">
      <label for="email-field" class="pb-1">Enter your ammount</label>
      <input type="number" class="form-control" name="amount" id="email-field" required>
    </div>

    

    <button type="submit" name="PAY" class="btn btn-primary">PAY</button>

    <div class="extra-links"> 
      <a href="home.php">HOME</a>
    </div>
  </form>
</body>
</html>

<?php
if(isset($_POST['PAY'])){
    $amount = $_POST['amount'];
    $booking_id = $_POST['booking_id'];
    $price = $_POST['price'];
    if($amount < $price){
        echo "<script>alert('Insufficient amount. Please enter at least: $price');</script>";
        exit();
    }

  
    $sql = "insert into payment (bookingID, amount) values ('$booking_id', '$amount')";
    if(mysqli_query($conn, $sql)) {
        //Redirect to a confirmation page or show a success message  
        echo "<script>alert('Ticket booked successfully!');</script>";
        header('Location: bookingHistory.php');
        
    } else {
        echo "<script>alert('Payment failed: " . $conn->error . "');</script>";

 }
}
?>
