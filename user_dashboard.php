<?php
include('connect.php');


// check if user is logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$user = mysqli_query($conn, "SELECT * FROM users WHERE userID = '$user_id'");
$userData = mysqli_fetch_assoc($user);

// Fetch available movies with showtimes
$movies = mysqli_query($conn, "
    SELECT movies.movieID, movies.title, movies.description, movies.releaseDate, showtimes.showtime_id, showtimes.date, showtimes.time, new_theater.tname
    FROM movies
    JOIN showtimes ON movies.movieID = showtimes.movieID
    JOIN new_theater ON showtimes.theater_id = new_theater.theater_id
    ORDER BY showtimes.date, showtimes.time
");

// Fetch user bookings
$bookings = mysqli_query($conn, "select booking.*, users.*, showtimes.*, movies.*, new_theater.* from booking
join users on booking.userID = users.userID
join showtimes on booking.showtime_id = showtimes.showtime_id
join movies on showtimes.movieID = movies.movieID
join new_theater on showtimes.theater_id = new_theater.theater_id
where booking.userID = '$user_id'");
?>
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <style>
        body {font-family: Arial, sans-serif; margin:0; padding:0; background:#f4f4f4; color:#333;}
        section {padding:20px; max-width:1200px; margin:auto;}
        h2 {margin:20px 0 10px; color:#444; font-size:22px; border-left:5px solid #28a745; padding-left:10px;}
        table {width:100%; border-collapse:collapse; margin-bottom:40px; background:#fff; box-shadow:0 2px 6px rgba(0,0,0,0.1); border-radius:6px; overflow:hidden;}
        table th, table td {padding:12px 15px; text-align:left; border-bottom:1px solid #ddd;}
        table thead {background:#28a745; color:#fff;}
        table tr:nth-child(even) {background:#f9f9f9;}
        table tr:hover {background:#eafbea; transition:0.3s;}
    </style>
</head>
<?php include('header.php'); ?>
<body>
    <section>
        <h2>Welcome, <?= $userData['name'] ?></h2>
          <p>  Email: <?= $userData['email'] ?></p>

        <h2>Available Movies & Showtimes</h2>
        <table>
            <thead>
                <tr><th>Movie</th><th>Description</th><th>Release Date</th><th>Theater</th><th>Date</th><th>Time</th></tr>
            </thead>
            <tbody>
            <?php while($m = mysqli_fetch_assoc($movies)){ ?>
                <tr>
                    <td><?= $m['title'] ?></td>
                    <td><?= $m['description'] ?></td>
                    <td><?= $m['releaseDate'] ?></td>
                    <td><?= $m['tname'] ?></td>
                    <td><?= $m['date'] ?></td>
                    <td><?= $m['time'] ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

        <h2>My Bookings</h2>
        <table>
            <thead>
                <tr><th>Booking ID</th><th>Movie</th><th>Theater</th><th>Date</th><th>Time</th></tr>
            </thead>
            <tbody>
            <?php while($b = mysqli_fetch_assoc($bookings)){ ?>
                <tr>
                    <td><?= $b['bookingID'] ?></td>
                    <td><?= $b['title'] ?></td>
                    <td><?= $b['tname'] ?></td>
                    <td><?= $b['date'] ?></td>
                    <td><?= $b['time'] ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </section>
</body>
</html>
<?php include('footer.php'); ?>
