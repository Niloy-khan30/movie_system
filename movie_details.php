<?php
include('connect.php');
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Movie Details</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f9;
      margin: 0;
      padding: 0;
      color: #333;
    }

    .movie-container {
      max-width: 900px;
      margin: 40px auto;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      overflow: hidden;
      display: flex;
      flex-wrap: wrap;
    }

    .movie-image {
      flex: 1 1 300px;
      text-align: center;
      background: #fafafa;
      padding: 20px;
    }

    .movie-image img {
      max-width: 100%;
      height: auto;
      border-radius: 6px;
    }

    .movie-details {
      flex: 2 1 500px;
      padding: 20px 30px;
    }

    .movie-details h2 {
      margin-top: 0;
      font-size: 28px;
      color: #222;
      border-left: 5px solid #28a745;
      padding-left: 10px;
    }

    .movie-details p {
      margin: 10px 0;
      line-height: 1.6;
    }

    .btn {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .btn-primary {
      background: #28a745;
      color: #fff;
    }

    .btn-primary:hover {
      background: #218838;
        box-shadow: 0 4px 12px rgba(255, 255, 255, 0.88);

    }

    .back-link {
      display: block;
      text-align: center;
      margin-top: 20px;
    }

    .back-link a {
      color: #555;
      text-decoration: none;
    }

    .back-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
<?php
if (isset($_GET['movie_id'])) {
    $movie_id = $_GET['movie_id'];

    $sql = "SELECT movies.*, catagories.catname, showtimes.showtime_id, showtimes.theater_id
            FROM movies 
            JOIN catagories ON movies.catID = catagories.catID 
            JOIN showtimes ON movies.movieID = showtimes.movieID
            WHERE movies.movieID = '$movie_id'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="movie-container">
          <div class="movie-image">
            <img src="admin/uploads/<?= $row['image']?>" alt="<?= $row['title'] ?>">
          </div>
          <div class="movie-details">
            <h2><?= $row['title'] ?></h2>
            <p><strong>Category:</strong> <?= $row['catname'] ?></p>
            <p><strong>Release Date:</strong> <?= $row['releaseDate'] ?></p>
            <p><strong>Description:</strong> <?= $row['description'] ?></p>
            <a href="book_movie.php?showtime_id=<?= $row['showtime_id'] ?>&theater_id=<?= $row['theater_id'] ?>"  style = 'width : 30% ; color : black;' class = 'btn btn-primary'>BOOK NOW</a>
          </div>
        </div>
        <div class="back-link">
          <a href="home.php">⬅ Back to Movies</a>
        </div>
        <?php
    } else {
        echo "<p style='text-align:center; margin-top:50px;'>❌ Movie not found!</p>";
    }
} else {
    echo "<p style='text-align:center; margin-top:50px;'>⚠ No movie selected!</p>";
}

include('footer.php');
?>
</body>
</html>
