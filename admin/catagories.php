
<?php 
include('../connect.php');
include('header.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>catagories</title>

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
        <form action="catagories.php" method="post">
            <div class="form-group mb-4">
                <input type="hidden" class="form-control" value="<?=$editRow['catID']?>" name="catid">
            </div>
            <div class="form-group mb-4">
                <input type="text" class="form-control" name="catname" value="<?=$editRow['catname']?>" placeholder="Enter category name">
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
                <th>Action</th>
            </tr>

            <?php
            $sql = "SELECT * FROM catagories";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                
                    ?>
                    <tr>
                        <td><?php echo $row['catID']; ?></td>
                        <td><?php echo $row['catname']; ?></td>
                        <td>
                            <a href="catagories.php?editID=<?php echo $row['catID']; ?>" class="btn btn-warning">Edit</a>
                            <a href="catagories.php?deleteID=<?php echo $row['catID']; ?>" class="btn btn-danger">Delete</a>
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
    $catname = $_POST['catname'];
    $sql = "INSERT INTO catagories (catname) VALUES ('$catname')";
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Category added successfully');</script>";
        echo "<script>window.location.href = 'catagories.php';</script>";
    } else {
        echo "<script>alert('Error adding category: " . $conn->error . "');</script>";
    }

}

if(isset($_POST['update'])) {
    $catid = $_POST['catid'];
    $catname = $_POST['catname'];
    $sql = "UPDATE catagories SET catname='$catname' WHERE catID='$catid'";
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Category updated successfully');</script>";
        echo "<script>window.location.href = 'catagories.php';</script>";
    } else {
        echo "<script>alert('Error updating category: " . $conn->error . "');</script>";
    }   
}

if(isset($_GET['deleteID'])) {
    $catid = $_GET['deleteID'];
    $sql = "DELETE FROM catagories WHERE catID='$catid'";
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Category deleted successfully');</script>";
        echo "<script>window.location.href = 'catagories.php';</script>";

    } else {
        echo "<script>alert('Error deleting category: " . $conn->error . "');</script>";
    }   



}
?>