
<?php 
include('../connect.php');
include('header.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies</title>
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
        <form action="movies.php" method="post"  enctype="multipart/form-data">

            <div class="form-group mb-4">
                <select name="catID" id="catID">
                    <option value="">Select Catagories</option>
                    <?php
                    $sql = "SELECT * FROM catagories";
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

            <div class="form-group mb-4">
                Title :
                <input type="text" class="form-control" name="title" value="" placeholder="Enter movie title">
            </div>

            <div class="form-group mb-4">
                Description :
                <input type="text" class="form-control" name="description" value="" placeholder="Enter movie description">
            </div>

            <div class="form-group mb-4">
                Release Date :
                <input type="date" class="form-control" name="releaseDate" value="" placeholder="Enter release date">
            </div>

            <div class="form-group mb-4">
                poster :
                <input type="file" class="form-control" name="image" value="" placeholder="Enter movie image">
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
                <th>Catagory </th>
                <th>Release Date</th>
                <th>Poster</th>
                <th>Action</th>
            </tr>

            <?php
            $sql = "SELECT movies.*, catagories.catname FROM movies JOIN catagories ON movies.catID = catagories.catID";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                
                    ?>
                    <tr>
                        <td><?php echo $row['movieID']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['catname']; ?></td>
                        <td><?php echo $row['releaseDate']; ?></td>
                        <td><img src="uploads/<?php echo $row['image']; ?>" alt="" srcset="" width = '60px' height = '80px'></td>
                        <td>
                            <a href="movies.php?editID=<?php echo $row['movieID']; ?>" class="btn btn-warning">Edit</a>
                            <a href="movies.php?deleteID=<?php echo $row['movieID']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>



                    <?php


                }
            }else {
                echo "<tr><td colspan='3'>No categories found</td></tr>";
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
    $catid = $_POST['catID'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $releaseDate = $_POST['releaseDate'];

    $image = $_FILES['image']['name'];
    $tmp_image = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp_image, "uploads/$image");
    $sql = "INSERT INTO movies (catID, title, description, releaseDate, image) VALUES ('$catid', '$title', '$description', '$releaseDate', '$image')";
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Movies added successfully');</script>";
        echo "<script>window.location.href = 'movies.php';</script>";
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