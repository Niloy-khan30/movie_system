<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>all Theator page</title>
</head>
<body>
<?php include('connect.php') ?>
<?php include('header.php') ?>

<section id="team" class="team section light-background">

      <!-- Section Title -->
      <div class="container section-title aos-init aos-animate" data-aos="fade-up">
       
        <p><span>ALL</span> <span class="description-title">theator</span></p>
      </div><!-- End Section Title -->




      <div class="container">

        <div class="row gy-4">
          <?php

          $sql = "select movies.* , theator.*, catagories.catname from theator
          INNER JOIN movies ON theator.movieID = movies.movieID
          INNER JOIN catagories ON movies.catID = catagories.catID";

          $result = mysqli_query($conn, $sql);
          if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_array($result)){

          ?>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
            <div class="team-member">
              <div class="member-img">
                <img src="admin/uploads/<?= $row['image']?>" style ='height : 230px; width : 200px' alt="">
                <div class="social">
                  <a href="booking.php?theator_id=<?= $row['theatorID'] ?>"  style = 'width : 100% ; color : black;'>BOOK NOW</a>
                </div>
              </div>
              <div class="member-info">
                <h5><?= $row['theator_name']?></h5>
                <h4 style = 'font-weight : bold;'>Movie : <?= $row['title']?></h4>
                <p style = 'margin-top: -5px'>Ticket : <?= $row['price']?> TK</p>
                <p style = 'margin-top: -20px'>Time :<?= $row['timing']?></p>
                <p style = 'margin-top: -20px'>Date :<?= $row['date']?></p>
                <p style = 'margin-top: -20px'>Location :<?= $row['location']?></p>
                <span style = 'margin-top: -20px'><?= $row['catname']?></span>
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