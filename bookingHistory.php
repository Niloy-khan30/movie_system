
<?php 
include('connect.php');
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}






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

<div class="row" style="margin-left:50px;">
    
    <div class="col-lg-12">
        <table class='table'>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>user </th>
                <th>Release Date</th>
                <th>Ticket</th>
                <th>Poster</th>
                <th>status</th>
                <th>Download ticket</th>

            </tr>

            <?php
            $sql = "select payment.*, booking.*, showtimes.*, ticket.*, movies.*,users.* from payment
            join booking on payment.bookingID = booking.bookingID
            join showtimes on booking.showtime_id = showtimes.showtime_id
            join ticket on booking.bookingID = ticket.bookingID
            join movies on showtimes.movieID = movies.movieID
            join users on booking.userID = users.userID
            where booking.userID = '" . $_SESSION['user_id'] . "'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                
                    ?>
                    <tr>
                        <td><?php echo $row['movieID']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['releaseDate']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><img src="admin/uploads/<?php echo $row['image']; ?>" alt="" srcset="" width = '60px' height = '80px'></td>
                        <td><?php if ($row['status'] == 1) {
                            echo "<a href = '#' class='btn btn-success'>Approved</a>";
                        } else {
                            echo "<a href = '#' class= 'btn btn-warning'>pending</a>";
                        }
                        ?>
                        </td>

                        <td>
                            <?php 
                            if ($row['status'] == 1) {
                                echo "<a href='download_ticket.php?bookingID=" . $row['bookingID'] . "' class='btn btn-primary'>Download</a>";
                            } else {
                                echo "N/A";
                            }
                            ?>








                    </tr>



                    <?php


                }
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