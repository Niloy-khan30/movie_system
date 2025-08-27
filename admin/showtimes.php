
<?php 
include('../connect.php');
include('header.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>showtime page</title>
    <style>
    select {
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        background-color: white;
        font-size: 16px;
        color: #333;
        width: 100%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    select:focus {
        border-color: #007BFF;
        outline: none;
        box-shadow: 0 0 8px rgba(0,123,255,0.5);
    }
    option {
        padding: 10px;
    }
</style>
    

</head>
<body>
  <?php
        error_reporting(0);
        if(isset($_GET['editID'])) {
            $catid = $_GET['editID'];
            $sql = "SELECT * FROM catagories WHERE catID='$catid'";
            $result = mysqli_query($conn, $sql);
            $editRow = mysqli_fetch_array($result);
           
            

        }

    ?>
<div class="row" style="margin: 20px;">
    <div class="col-lg-4" style ="margin-left: 10%;">
        <form action="showtimes.php" method="post"  enctype="multipart/form-data">

            <div class="form-group mb-4">
                <select name="movieID" id="movieID" onchange="this.form.submit()">
                    <option value="">Select Movie</option>
                    <?php
                    $selectedMovie = isset($_POST['movieID']) ? $_POST['movieID'] : "";

                    $sql = "SELECT hosting.movieID, movies.title 
                            FROM hosting 
                            INNER JOIN movies ON hosting.movieID = movies.movieID 
                            GROUP BY hosting.movieID";
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                            $sel = ($row['movieID'] == $selectedMovie) ? "selected" : "";
                            echo "<option value='".$row['movieID']."' $sel>".$row['title']."</option>";
                        }
                    } else {
                        echo "<option value=''>No Movie found</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group mb-4">
                <select name="theater_id" id="theater_id">
                    <option value="">Select theater</option>
                    <?php
                    if(!empty($selectedMovie)){
                        $sql = "SELECT t.theater_id, t.tname 
                                FROM new_theater t
                                INNER JOIN hosting h ON t.theater_id = h.theater_id
                                WHERE h.movieID = '$selectedMovie'";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_array($result)){
                                echo "<option value='".$row['theater_id']."'>".$row['tname']."</option>";
                            }
                        } else {
                            echo "<option value=''>No theater found</option>";
                        }
                    }
                    ?>
                </select>
            </div>









            <div class="form-group mb-4">
                Time :
                <input type="time" class="form-control" name="time" value="" placeholder="Enter movie's time">
            </div>


            <div class="form-group mb-4">
                show-Date :
                <input type="date" class="form-control" name="date" value="" placeholder="Enter release date">
            </div>




            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Add" name="add">
                <!-- <input type="submit" class="btn btn-info" value="Update" name="update"> -->
            </div>
        </form>
    </div>


    <div class="col-lg-6">
            <table class='table'>
                <tr>

                    <th>Name</th>
                    <th>Theater name</th>
                    <th>show time</th>
                    <th>Date</th>
                    <th>Location</th>
                </tr>

                <?php
                $sql = "select showtimes.*, movies.title, new_theater.tname, new_theater.tlocation from showtimes
                INNER JOIN movies ON showtimes.movieID = movies.movieID
                INNER JOIN new_theater ON showtimes.theater_id = new_theater.theater_id";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){
                ?>
                        <tr>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['tname']; ?></td>
                            <td><?php echo $row['time']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['tlocation']; ?></td>
                            <td>
                                <!-- <a href="showtimes.php?editID=<?php echo $row['showtime_id']; ?>" class="btn btn-warning">Edit</a> -->
                                <a href="showtimes.php?deleteID=<?php echo $row['showtime_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this theater?');">Delete</a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No showtimes found</td></tr>";
                }
                ?>
            </table>
    </div>





    






</div>





<?php include('footer.php');?>

</body>
</html>


<?php
if(isset($_POST['add'])) {
    $movieid = $_POST['movieID'];
    $theater_id = $_POST['theater_id'];
    $time = $_POST['time'];
    $date = $_POST['date'];

  
    $sql = "insert into showtimes (movieID, theater_id, time, date) values ('$movieid', '$theater_id', '$time', '$date')";
            
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('showtime added successfully');</script>";
        echo "<script>window.location.href = 'showtimes.php';</script>";
    } else {
        echo "<script>alert('Error adding showtimes: " . $conn->error . "');</script>";
    }

}

?>
<?php
// if(isset($_POST['update'])) {
    

    

//     $sql = "UPDATE catagories SET catname='$catname' WHERE catID='$catid'";
//     if(mysqli_query($conn, $sql)) {
//         echo "<script>alert('Category updated successfully');</script>";
//         echo "<script>window.location.href = 'catagories.php';</script>";
//     } else {
//         echo "<script>alert('Error updating category: " . $conn->error . "');</script>";
//     }   
// }

if(isset($_GET['deleteID'])) {
    $id = $_GET['deleteID'];
    $sql = "DELETE FROM showtimes WHERE showtime_id ='$id'";
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('showtime deleted successfully');</script>";
        echo "<script>window.location.href = 'showtimes.php';</script>";

    } else {
        echo "<script>alert('Error deleting showtime: " . $conn->error . "');</script>";
    }   



}

?>