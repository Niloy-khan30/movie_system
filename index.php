<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
</head>
<body>
<?php include('connect.php') ?>
<?php include('header.php') ?>

<section id="team" class="team section light-background">

      <!-- Section Title -->
      <div class="container section-title aos-init aos-animate" data-aos="fade-up">
       
        <p><span>ALL</span> <span class="description-title">MOVIES</span></p>
      </div><!-- End Section Title -->

      <!-- searching movie  -->
      <form action="index.php" method="post">
        <div class="row" style = 'margin-left: 100px; margin-bottom : 50px'>

          <!-- Movie search input -->
          <div class="col-lg-3 col-md-6 d-flex">
            <div class="form-group">
              <input type="text" class="form-control" name="movie_search" placeholder="Search Movie">
            </div>
          </div>

          <!-- Category dropdown -->
          <div class="col-lg-3 col-md-6 d-flex"  style = 'margin-left: -150px;'>
            <div class="form-group">
              <select name="catID" class="form-control">
                <option value="">Select Category</option>
                <?php
                $sql = "SELECT * FROM catagories"; // use your real table name
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){
                        echo "<option value='".$row['catID']."'>".$row['catname']."</option>";
                    }
                } else {
                    echo "<option value=''>No categories found</option>";
                }
                ?>
              </select>
            </div>
          </div>

          <!-- Search button -->
          <div class="col-lg-3 col-md-6 d-flex" style = 'margin-left: -200px;'>
            <div class="form-group">
              <button type="submit" class="btn btn-primary" name = 'searchbtn'>Search</button>
            </div>
          </div>

        </div>
    </form>

    <script>
        function validateSearch() {
          let category = document.getElementById("catID").value;
          if (category === "") {
            alert("⚠ Please select a category before searching!");
            return false; // prevent form submission
          }
          return true; // allow form to submit
        }
    </script>



      <div class="container">

        <div class="row gy-4">
          <?php 
            if(isset($_POST['searchbtn'])){
              $movie_name = $_POST['movie_search'];
              $catid = $_POST['catID'];

              $sql = "SELECT movies.*, catagories.catname FROM movies JOIN catagories ON movies.catID = catagories.catID where movies.title like '%$movie_name%' and movies.catID = $catid";
              $result = mysqli_query($conn, $sql);
              if(mysqli_num_rows($result) > 0){
              while($row = mysqli_fetch_array($result)){


                ?>
                  <div class="col-lg-3 col-md-6 d-flex align-items-stretch aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                    <div class="team-member">
                      <div class="member-img">
                        <img src="admin/uploads/<?= $row['image']?>" style ='height : 230px; width : 200px' alt="">
                        <div class="social">
                          <a href="booking.php"  style = 'width : 100% ; color : black;'>BOOK NOW</a>
                        </div>
                      </div>
                      <div class="member-info">
                        <h4><?= $row['title']?></h4>
                        <span><?= $row['catname']?></span>
                      </div>
                    </div>
                  </div>
                <?php
              }
              }

          


            }else{

            
      
          
          $sql = "SELECT movies.*, catagories.catname FROM movies JOIN catagories ON movies.catID = catagories.catID";
          $result = mysqli_query($conn, $sql);
          if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_array($result)){

          ?>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
            <div class="team-member">
              <div class="member-img">
                <img src="admin/uploads/<?= $row['image']?>" style ='height : 230px; width : 200px' alt="">
                <div class="social">
                  <a href="booking.php"  style = 'width : 100% ; color : black;'>BOOK NOW</a>
                </div>
              </div>
              <div class="member-info">
                <h4><?= $row['title']?></h4>
                <span><?= $row['catname']?></span>
              </div>
            </div>
          </div><!-- End Team Member -->

        <?php
          }
        }
      }
          ?>

        </div>

        

      </div>

    </section>














<?php include('footer.php') ?>
</body>
</html>