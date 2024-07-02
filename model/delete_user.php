<?php
session_start();
require 'connect.php';

$user = $_SESSION['userid'];

// delete all user locations
$deleteLdLocations = mysqli_query($connect, "DELETE FROM `location` WHERE `user` = '$user'");

// delete all user ld
$deleteLd = mysqli_query($connect, "DELETE FROM `ld` WHERE `user` = '$user'");

// delete user
$deleteLd = mysqli_query($connect, "DELETE FROM `user` WHERE `id` = '$user'");

session_unset();
session_destroy();
header("location:/");
?>