<?php 
include('../connect.php');

// check if admin is logged in
if(!isset($_SESSION['user_id'])){
    header("Location:../login.php");
    exit();
}

// Fetch movies
$movies = mysqli_query($conn, "SELECT * FROM movies");

// Fetch users
$users = mysqli_query($conn, "SELECT * FROM users");

// Fetch bookings
$bookings = mysqli_query($conn, "select booking.*, users.*, showtimes.*, movies.* from booking
join users on booking.userID = users.userID
join showtimes on booking.showtime_id = showtimes.showtime_id
join movies on showtimes.movieID = movies.movieID");

$payments = mysqli_query($conn, "SELECT payment.*, booking.*,users.* from payment
join booking on payment.bookingID = booking.bookingID
join users on booking.userID = users.userID");


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: #f4f4f4;
    color: #333;
}

section {
    padding: 20px;
    max-width: 1200px;
    margin: auto;
}

h2 {
    margin: 20px 0 10px;
    color: #444;
    font-size: 22px;
    border-left: 5px solid #007bff;
    padding-left: 10px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 40px;
    background: #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    border-radius: 6px;
    overflow: hidden;
}

table thead {
    background: #007bff;
    color: #fff;
    font-weight: bold;
}

table th, table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table tr:nth-child(even) {
    background: #f9f9f9;
}

table tr:hover {
    background: #f1f7ff;
    transition: 0.3s;
}

table th:first-child, table td:first-child {
    border-left: none;
}

table th:last-child, table td:last-child {
    border-right: none;
}

</style>
   
</head>
<?php include ('header.php'); ?>
<body>
    <section>
        <h2>Movies</h2>
        <table>
            <tr><th>ID</th><th>Name</th><th>Description</th><th>Release Date</th></tr>
            <?php while($m = mysqli_fetch_assoc($movies)){ ?>
            <tr>
                <td><?= $m['movieID'] ?></td>
                <td><?= $m['title'] ?></td>
                <td><?= $m['description'] ?></td>
                <td><?= $m['releaseDate'] ?></td>
            </tr>
            <?php } ?>
        </table>

        <h2>Users</h2>
        <table>
            <tr><th>ID</th><th>Name</th><th>Email</th></tr>
            <?php while($u = mysqli_fetch_assoc($users)){ ?>
            <tr>
                <td><?= $u['userID'] ?></td>
                <td><?= $u['name'] ?></td>
                <td><?= $u['email'] ?></td>
            </tr>
            <?php } ?>
        </table>

        <h2>Bookings</h2>
        <table>
            <tr><th>Booking ID</th><th>User</th><th>Movie</th><th>Date</th><th>Time</th></tr>
            <?php while($b = mysqli_fetch_assoc($bookings)){ ?>
            <tr>
                <td><?= $b['bookingID'] ?></td>
                <td><?= $b['name'] ?></td>
                <td><?= $b['title'] ?></td>
                <td><?= $b['date'] ?></td>
                <td><?= $b['time'] ?></td>
            </tr>
            <?php } ?>
        </table>
        <h2>Payments</h2>
        <table>
            <tr><th>Booking ID</th><th>User</th><th>Amount</th><th>Status</th></tr>
            <?php while($p = mysqli_fetch_assoc($payments)){ ?>
            <tr>
                <td><?= $p['bookingID'] ?></td>
                <td><?= $p['name'] ?></td>
                <td><?= $p['amount'] ?></td>
                <td><?php 
                if($p['status'] == 0){
                    echo "Pending";
                } else {
                    echo "Approved";
                }
                ?></td>
            </tr>
            <?php } ?>
        </table>





    </section>
   
</body>
</html>
 <?php
        include('footer.php');
    ?>