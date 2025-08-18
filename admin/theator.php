
<?php 
include('../connect.php');
include('header.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theators</title>
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
<div class="row">
    <div class="col-lg-6">
        <form action="theator.php" method="post"  enctype="multipart/form-data">

            <div class="form-group mb-4">
                <select name="movieID" id="movieID">
                    <option value="">Select Movie</option>
                    <?php
                    $sql = "SELECT * FROM movies";
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                            echo "<option value='".$row['movieID']."'>".$row['title']."</option>";
                        }
                    } else {
                        echo "<option value=''>No Movie found</option>";
                    }
                    ?>

                </select>
            </div>

            <div class="form-group mb-4">
                Time :
                <input type="time" class="form-control" name="timing" value="" placeholder="Enter movie's time">
            </div>


            <div class="form-group mb-4">
                Release Date :
                <input type="date" class="form-control" name="date" value="" placeholder="Enter release date">
            </div>

            <div class="form-group mb-4">
                Ticket :
                <input type="number" class="form-control" name="price" value="" placeholder="Enter price">
            </div>

            <div class="form-group mb-4">
                Location :
                <input type="text" class="form-control" name="location" value="" placeholder="Enter location">
            </div>

            <div class="form-group mb-4">
                Theator Name :
                <input type="text" class="form-control" name="theator_name" value="" placeholder="Enter theator name">
            </div>






            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Add" name="add">
                <input type="submit" class="btn btn-info" value="Update" name="update">
            </div>
        </form>
    </div>


    <div class="col-lg-6">
            <table class='table'>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Release Date</th>
                    <th>Ticket</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>

                <?php
                $sql = "SELECT theator.theatorID, theator.date AS release_date, theator.price, theator.location,
                            movies.title, catagories.catname
                        FROM theator
                        INNER JOIN movies ON movies.movieID = theator.movieID 
                        INNER JOIN catagories ON catagories.catID = movies.catID";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){
                ?>
                        <tr>
                            <td><?php echo $row['theatorID']; ?></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['catname']; ?></td>
                            <td><?php echo $row['release_date']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['location']; ?></td>
                            <td>
                                <a href="theator.php?editID=<?php echo $row['theatorID']; ?>" class="btn btn-warning">Edit</a>
                                <a href="theator.php?deleteID=<?php echo $row['theatorID']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this theater?');">Delete</a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No theaters found</td></tr>";
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
    $time = $_POST['timing'];
    $date = $_POST['date'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $theator_name = $_POST['theator_name'];

  
    $sql = "INSERT INTO theator (movieID, timing, date, price, location, theator_name) 
            VALUES ('$movieid', '$time', '$date', '$price', '$location', '$theator_name')";
            
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('theator added successfully');</script>";
        echo "<script>window.location.href = 'theator.php';</script>";
    } else {
        echo "<script>alert('Error adding category: " . $conn->error . "');</script>";
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

// if(isset($_GET['deleteID'])) {
//     $catid = $_GET['deleteID'];
//     $sql = "DELETE FROM catagories WHERE catID='$catid'";
//     if(mysqli_query($conn, $sql)) {
//         echo "<script>alert('Category deleted successfully');</script>";
//         echo "<script>window.location.href = 'catagories.php';</script>";

//     } else {
//         echo "<script>alert('Error deleting category: " . $conn->error . "');</script>";
//     }   



// }
//
?>