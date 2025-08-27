
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

<div class="row">
    <div class="col-lg-6">
        <form action="hosting.php" method="post"  enctype="multipart/form-data">

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
                <select name="theater_id" id="theater_id">
                    <option value="">Select theater</option>
                    <?php
                    $sql = "SELECT * FROM new_theater";
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                            echo "<option value='".$row['theater_id']."'>".$row['tname']."</option>";
                        }
                    } else {
                        echo "<option value=''>No theater found</option>";
                    }
                    ?>

                </select>
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
                    <th>Name</th>
                    <th>Category</th>
                    <th>Theater Name</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>

                <?php
                $sql = "select hosting.*, movies.*, catagories.catname, new_theater.tname, new_theater.tlocation from hosting
                INNER JOIN movies ON hosting.movieID = movies.movieID
                INNER JOIN catagories ON movies.catID = catagories.catID
                INNER JOIN new_theater ON hosting.theater_id = new_theater.theater_id";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){
                ?>
                        <tr>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['catname']; ?></td>
                            <td><?php echo $row['tname']; ?></td>
                            <td><?php echo $row['tlocation']; ?></td>
                            <td>
                                <a href="hosting.php?editID=<?php echo $row['theater_id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="hosting.php?deleteID=<?php echo $row['theater_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this theater?');">Delete</a>
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
    $theator_id = $_POST['theater_id'];



  
    $sql = "INSERT INTO hosting (movieID, theater_id) VALUES ('$movieid', '$theator_id')";
    
            
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Hosting successfully');</script>";
        echo "<script>window.location.href = 'hosting.php';</script>";
    } else {
        echo "<script>alert('Error adding hosting: " . $conn->error . "');</script>";
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