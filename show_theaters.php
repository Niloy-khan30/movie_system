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
       
        <p><span>ALL</span> <span class="description-title">THEATERS</span></p>
      </div><!-- End Section Title -->




      <div class="container">

        <div class="row gy-4">
          <?php

          $sql = "select * from new_theater";
          

          $result = mysqli_query($conn, $sql);
          if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_array($result)){

          ?>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
            <div class="team-member">
              <div class="member-img">
                <img src="admin/uploads/<?= $row['tlogo']?>" style ='height : 230px; width : 200px' alt="">
                <div class="social">
                  <a href="view_shows.php?theator_id=<?= $row['theater_id'] ?>"  style = 'width : 100% ; color : black;'>VIEW SHOWS</a>
                </div>
              </div>
              <div class="member-info">
                <h5><?= $row['tname']?></h5>
                <p style = 'margin-top: 10px'>Location :<?= $row['tlocation']?></p>
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