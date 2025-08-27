
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
    <div class="col-lg-5" style ="margin-left: 40px;">
        <form action="new_theater.php" method="post"  enctype="multipart/form-data">

            <div class="form-group mb-4">
                Theator Name :
                <input type="text" class="form-control" name="tname" value="" placeholder="Enter theator name">
            </div>
            
            <div class="form-group mb-4">
                Location :
                <input type="text" class="form-control" name="tlocation" value="" placeholder="Enter location">
            </div>

            <div class="form-group mb-4">
                Logo :
                <input type="file" class="form-control" name="tlogo" value="" placeholder="Enter logo">
            </div>



            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Add" name="add">
                <!-- <input type="submit" class="btn btn-info" value="Update" name="update"> -->
            </div>
        </form>
    </div>


    <div class="col-lg-6" style ="margin-left: 40px;">
            <table class='table'>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Logo</th>
                    <th>Action</th>
                </tr>

                <?php
                $sql = "SELECT * FROM new_theater";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){
                ?>
                        <tr>
                            <td><?php echo $row['theater_id']; ?></td>
                            <td><?php echo $row['tname']; ?></td>
                            <td><?php echo $row['tlocation']; ?></td>
                            <<td><img src="uploads/<?php echo $row['tlogo']; ?>" alt="" srcset="" width = '60px' height = '80px'></td>
                            <td>
                                <!-- <a href="new_theater.php?editID=<?php echo $row['theater_id']; ?>" class="btn btn-warning">Edit</a> -->
                                <a href="new_theater.php?deleteID=<?php echo $row['theater_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this theater?');">Delete</a>
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
    $tname = $_POST['tname'];
    $tlocation = $_POST['tlocation'];
    $tlogo = $_FILES['tlogo']['name'];
    $tmp_logo = $_FILES['tlogo']['tmp_name'];

    move_uploaded_file($tmp_logo, "uploads/$tlogo");
   
  
    $sql = "INSERT INTO new_theater (tname, tlocation, tlogo) VALUES ('$tname', '$tlocation', '$tlogo')";
            
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('theator added successfully');</script>";
        echo "<script>window.location.href = 'new_theater.php';</script>";
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

if(isset($_GET['deleteID'])) {
    $id = $_GET['deleteID'];
    $sql = "DELETE FROM new_theater WHERE  theater_id='$id'";
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('theater deleted successfully');</script>";
        echo "<script>window.location.href = 'new_theater.php';</script>";

    } else {
        echo "<script>alert('Error deleting theater: " . $conn->error . "');</script>";
    }   



}

?>