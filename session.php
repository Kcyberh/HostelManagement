<?php
session_start();
include 'database/connect.php';

if(!isset($_SESSION['username'])){
    header('Location: ../index.php');
    exit();
}

$username = $_SESSION['username'];
$sql = "SELECT name FROM tb_user WHERE index_number = '$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$name = $row['name'];


?>