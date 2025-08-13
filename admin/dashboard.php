<?php 
include('../connect.php');

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
} 



include('header.php');
include('footer.php');
?>