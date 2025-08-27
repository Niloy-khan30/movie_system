<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shows</title>
</head>
<body>
<?php include('connect.php') ?>
<?php include('header.php') ?>
<?php
if(isset($_GET['theator_id'])) {
    $theator_id = $_GET['theator_id'];
}
?>



<section id="team" class="team section light-background">

      <!-- Section Title -->
      <div class="container section-title aos-init aos-animate" data-aos="fade-up">
       
        <p><span>ALL</span> <span class="description-title">shows</span></p>
      </div><!-- End Section Title -->




      <div class="container">

        <div class="row gy-4">
          <?php

          $sql = "select movies.*, new_theater.*, showtimes.* from showtimes
          INNER JOIN movies ON showtimes.movieID = movies.movieID
          INNER JOIN new_theater ON showtimes.theater_id = new_theater.theater_id
          WHERE new_theater.theater_id = '$theator_id'";
          
          $result = mysqli_query($conn, $sql);
          if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_array($result)){

          ?>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
            <div class="team-member">
              <div class="member-img">
                <img src="admin/uploads/<?= $row['image']?>" style ='height : 230px; width : 200px' alt="">
                <div class="social">
                  <a href="book_movie.php?showtime_id=<?= $row['showtime_id'] ?>&theater_id=<?= $row['theater_id'] ?>"  style = 'width : 100% ; color : black;'>BOOK NOW</a>
                </div>
              </div>
              <div class="member-info">
                <h4 style = 'font-weight : bold;'>Movie : <?= $row['title']?></h4>
                <p style = 'margin-top: 20px'>Show Time :<?= $row['time']?></p>
                <p style = 'margin-top: -20px'>Show Date :<?= $row['date']?></p>
                <p style = 'margin-top: -20px'>Location :<?= $row['tlocation']?></p>
              </div>
            </div>
          </div><!-- End Team Member -->

        <?php
          }
        }
          ?>

        </div>

        

      </div>

    </section>














<?php include('footer.php') ?>
</body>
</html>