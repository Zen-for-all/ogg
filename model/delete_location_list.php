<?php
session_start();
require 'connect.php';

$user = $_SESSION['userid'];

$deleteLd = mysqli_query($connect, "DELETE FROM `location` WHERE `user` = '$user'");

$deleteLdId = mysqli_query($connect, "UPDATE `user` SET `ldlocations` = NULL WHERE `id` = '$user'");

header("location:/?page=location");